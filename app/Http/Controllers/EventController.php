<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
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
        $query->where('status', 'approved');

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

    public function adminEvents()
    {

        // $this->authorize('viewAdmin', User::class);

        $events = Event::with(['category', 'organizer'])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $events
        ]);
    }
    public function approveEvent($id)
    {
        $event = Event::findOrFail($id);

        $this->authorize('approve', $event); // Tambahkan ini

        $event->update(['status_approval' => 'approved']);

        return response()->json([
            'message' => 'Event disetujui'
        ]);
    }

    public function rejectEvent($id)
    {
        $event = Event::findOrFail($id);

        $this->authorize('approve', $event); // Gunakan policy yang sama

        $event->update(['status_approval' => 'rejected']);

        return response()->json([
            'message' => 'Event ditolak'
        ]);
    }


    // public function approveEvent($id)
    // {


    //     $event = Event::findOrFail($id);
    //     $event->update(['status_approval' => 'approved']);

    //     return response()->json([
    //         'message' => 'Event disetujui'
    //     ]);
    // }

    // public function rejectEvent($id)
    // {


    //     $event = Event::findOrFail($id);
    //     $event->update(['status_approval' => 'rejected']);

    //     return response()->json([
    //         'message' => 'Event ditolak'
    //     ]);
    // }


    public function store(StoreEventRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('event_image')) {
            $data['event_image'] = $request->file('event_image')->store('events', 'public');
        }

        $event = Event::create($data);
        return response()->json([
            'message' => 'Event berhasil dibuat',
            'data' => $event
        ], 201);
    }

    public function show($id)
    {
        $event = Event::with(['category', 'organizer'])->findOrFail($id);
        return view('events.show', compact('event'));
        return response()->json($event);
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

        return response()->json(['message' => 'Event berhasil dihapus']);
    }
}
