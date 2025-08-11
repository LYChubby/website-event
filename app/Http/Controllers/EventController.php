<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Feedback;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class EventController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $query = Event::query()->with('category', 'organizer');

        // Filter by kategori
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by tanggal (antara start & end)
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereDate('start_date', '>=', $request->start_date)
                ->whereDate('end_date', '<=', $request->end_date);
        }

        // Opsional: Pencarian by nama event
        if ($request->has('search')) {
            $query->where('name_event', 'like', '%' . $request->search . '%');
        }

        // Hanya tampilkan event yang sudah disetujui
        $query->where('status_approval', 'approved');

        return response()->json([
            'success' => true,
            'data' => $query->latest()->paginate(10)
        ]);
    }

    public function myEvents()
    {
        //dd('myEvents');
        $userId = Auth::id();
        $events = Event::where('user_id', $userId)
            ->with('category')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }

    public function pendingEvents(Request $request)
    {
        try {
            $query = Event::with(['category', 'organizer'])
                ->where('status_approval', 'pending');

            if ($request->search) {
                $query->where('name_event', 'like', '%' . $request->search . '%');
            }

            $perPage = $request->per_page ?? 9;
            $events = $query->latest()->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $events->items(),
                'total' => $events->total(),
                'current_page' => $events->currentPage(),
                'per_page' => $events->perPage()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch events',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function approveEvent(Event $event)
    {
        try {
            $event->update(['status_approval' => 'approved']);

            // Log activity atau send notification bisa ditambahkan di sini
            logActivity('event', 'Event telah disetujui', $event->title . ' telah disetujui oleh ' . Auth::user()->name);

            return response()->json([
                'success' => true,
                'message' => 'Event approved successfully',
                'data' => $event
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to approve event',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function rejectEvent(Event $event)
    {
        try {
            $event->update(['status_approval' => 'rejected']);

            // Log activity atau send notification bisa ditambahkan di sini
            logActivity('event', 'Event telah ditolak', $event->title . ' telah ditolak oleh ' . Auth::user()->name);

            return response()->json([
                'success' => true,
                'message' => 'Event rejected successfully',
                'data' => $event
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject event',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function stats()
    {
        return response()->json([
            'approved' => Event::where('status_approval', 'approved')->count(),
            'pending' => Event::where('status_approval', 'pending')->count(),
            'rejected' => Event::where('status_approval', 'rejected')->count()
        ]);
    }

    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('event_image')) {
            $data['event_image'] = $request->file('event_image')->store('events', 'public');
        }

        $event = Event::create($data);
        $user = Auth::user();
        logActivity('event', 'Event baru diajukan', $event->title . ' telah diajukan oleh ' . $user->name);
        return response()->json([
            'message' => 'Event berhasil dibuat',
            'data' => $event
        ], 201);
    }

    public function events($id)
    {
        $organizer = User::where('role', 'organizer')->findOrFail($id);
        $events = Event::where('user_id', $id)->latest()->get();

        return view('event-list', compact('organizer', 'events'));
    }

    public function eventListView($id)
    {
        $organizer = User::where('role', 'organizer')->findOrFail($id);
        $events = Event::where('user_id', $id)
            ->with('category')
            ->latest()
            ->get();

        return view('event-list', compact('organizer', 'events'));
    }

    // API daftar event milik organizer
    public function getByOrganizer($userId)
    {
        // Cari organizer berdasarkan kolom role langsung
        $organizer = User::where('user_id', $userId)
            ->where('role', 'organizer')
            ->firstOrFail();

        // Ambil semua event milik organizer ini
        $events = Event::with(['category', 'organizer'])
            ->where('user_id', $organizer->user_id)
            ->orderBy('start_date', 'desc')
            ->get();

        return response()->json([
            'data' => $events
        ]);
    }


    public function show($id)
    {
        $event = Event::with(['category', 'organizer'])->findOrFail($id);
        return response()->json($event);
    }

    public function detail($id)
    {
        $event = Event::with(['category', 'organizer', 'tickets', 'feedbacks.user'])->findOrFail($id);

        return view('events.show', compact('event'));
    }

    public function update(UpdateEventRequest $request, $id)
    {
        $event = Event::findOrFail($id);
        $this->authorize('update', $event);
        $data = $request->validated();

        if ($request->hasFile('event_image')) {
            // Hapus gambar lama jika ada
            if ($event->event_image) {
                Storage::disk('public')->delete($event->event_image);
            }
            // Simpan gambar baru
            $data['event_image'] = $request->file('event_image')->store('events', 'public');
        } elseif ($request->has('existing_image')) {
            // Gunakan gambar yang sudah ada jika tidak ada upload baru
            $data['event_image'] = $request->input('existing_image');
        } else {
            // Jika tidak ada gambar baru dan tidak ada existing_image, set ke null
            $data['event_image'] = null;
        }

        $event->update($data);
        logActivity('event', 'Event telah diperbarui', $event->title . ' telah diperbarui oleh ' . Auth::user()->name);

        return response()->json([
            'message' => 'Event berhasil diperbarui',
            'data' => $event
        ]);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $this->authorize('delete', $event);
        if ($event->event_image) {
            Storage::disk('public')->delete($event->event_image);
        }
        $event->delete();
        logActivity('event', 'Event telah dihapus', $event->title . ' telah dihapus oleh ' . Auth::user()->name);

        return response()->json(['message' => 'Event berhasil dihapus']);
    }
}
