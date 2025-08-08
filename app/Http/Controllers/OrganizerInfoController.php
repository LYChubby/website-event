<?php

namespace App\Http\Controllers;

use App\Models\OrganizerInfo;
use App\Http\Requests\OrganizerInfoRequest;
use App\Services\XenditBankService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerInfoController extends Controller
{
    public function index(Request $request)
    {
        $query = OrganizerInfo::with(['user' => function ($q) {
            $q->where('role', 'organizer'); // Hanya ambil user dengan role organizer
        }])->whereHas('user', function ($q) {
            $q->where('role', 'organizer');
        })->latest();

        if ($request->has('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $organizers = $query->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $organizers, // Langsung return pagination object
            'message' => 'Success'
        ]);
    }

    public function updateVerification(Request $request, $id)
    {
        $request->validate([
            'is_verified' => 'required|boolean'
        ]);

        $organizer = OrganizerInfo::findOrFail($id);

        $organizer->update([
            'is_verified' => $request->is_verified,
            'disbursement_ready' => $request->is_verified // Set sama dengan is_verified
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status verifikasi berhasil diperbarui',
            'data' => $organizer
        ]);
    }

    public function create(XenditBankService $xenditBankService)
    {
        $banks = $xenditBankService->getAvailableBanks();
        return view('organizer.info-form', compact('banks'));
    }

    // public function store(OrganizerInfoRequest $request, XenditBankService $xenditBankService): JsonResponse
    // {
    //     $validated = $request->validated();

    //     $xenditResponse = $xenditBankService->validateBankAccount(
    //         $validated['bank_code'],
    //         $validated['bank_account_number']
    //     );

    //     if (!$xenditResponse || !isset($xenditResponse['account_holder_name'])) {
    //         return response()->json(['message' => 'Nomor rekening tidak valid atau tidak ditemukan.'], 422);
    //     }

    //     // Bandingkan nama (case-insensitive, hilangkan spasi)
    //     $providedName = strtolower(preg_replace('/\s+/', '', $validated['bank_account_name']));
    //     $xenditName = strtolower(preg_replace('/\s+/', '', $xenditResponse['account_holder_name']));

    //     if ($providedName !== $xenditName) {
    //         return response()->json([
    //             'message' => 'Nama rekening tidak cocok dengan data bank.',
    //             'expected_name' => $xenditResponse['account_holder_name']
    //         ], 422);
    //     }

    //     $validated['is_verified'] = true;
    //     $validated['user_id'] = Auth::id();

    //     $organizerInfo = OrganizerInfo::create($validated);

    //     return response()->json($organizerInfo, 201);
    // }

    public function store(OrganizerInfoRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $validated['is_verified'] = false; // Karena tidak divalidasi
        $validated['user_id'] = Auth::id();

        $organizerInfo = OrganizerInfo::create($validated);

        return response()->json($organizerInfo, 201);
    }

    public function show($id): JsonResponse
    {
        $organizerInfo = OrganizerInfo::with('user')->findOrFail($id);
        return response()->json($organizerInfo);
    }

    public function update(OrganizerInfoRequest $request, XenditBankService $xenditBankService, $id): JsonResponse
    {
        $validated = $request->validated();

        $organizerInfo = OrganizerInfo::findOrFail($id);

        $xenditResponse = $xenditBankService->validateBankAccount(
            $validated['bank_code'],
            $validated['bank_account_number']
        );

        if (!$xenditResponse || !isset($xenditResponse['account_holder_name'])) {
            return response()->json(['message' => 'Nomor rekening tidak valid atau tidak ditemukan.'], 422);
        }

        $providedName = strtolower(preg_replace('/\s+/', '', $validated['bank_account_name']));
        $xenditName = strtolower(preg_replace('/\s+/', '', $xenditResponse['account_holder_name']));

        if ($providedName !== $xenditName) {
            return response()->json([
                'message' => 'Nama rekening tidak cocok dengan data bank.',
                'expected_name' => $xenditResponse['account_holder_name']
            ], 422);
        }

        $validated['is_verified'] = true;

        $organizerInfo->update($validated);

        return response()->json($organizerInfo);
    }

    public function destroy($id): JsonResponse
    {
        $organizerInfo = OrganizerInfo::findOrFail($id);
        $organizerInfo->delete();

        return response()->json(['message' => 'Organizer info deleted successfully.']);
    }

    public function getBanks(XenditBankService $xenditBankService)
    {
        $banks = $xenditBankService->getAvailableBanks();
        return response()->json($banks);
    }

    public function verifyAccount(Request $request, XenditBankService $xenditBankService)
    {
        $request->validate([
            'bank_code' => 'required',
            'account_number' => 'required',
        ]);

        $response = $xenditBankService->validateBankAccount(
            $request->bank_code,
            $request->account_number
        );

        if ($response && isset($response['account_holder_name'])) {
            return response()->json(['account_holder_name' => $response['account_holder_name']]);
        }

        return response()->json(['error' => 'Gagal memverifikasi rekening.'], 422);
    }
}
