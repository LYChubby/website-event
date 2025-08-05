<?php

namespace App\Http\Controllers;

use App\Models\OrganizerInfo;
use App\Http\Requests\OrganizerInfoRequest;
use App\Services\XenditBankService;
use Illuminate\Http\JsonResponse;

class OrganizerInfoController extends Controller
{
    public function index(): JsonResponse
    {
        $data = OrganizerInfo::with('user')->get();
        return response()->json($data);
    }

    public function store(OrganizerInfoRequest $request, XenditBankService $xenditBankService): JsonResponse
    {
        $validated = $request->validated();

        // Validasi rekening ke Xendit
        $xenditResponse = $xenditBankService->validateBankAccount(
            $validated['bank_code'],
            $validated['bank_account_number']
        );

        if (!$xenditResponse || !isset($xenditResponse['account_name'])) {
            return response()->json(['message' => 'Nomor rekening tidak valid atau tidak ditemukan.'], 422);
        }

        // Bandingkan nama (case-insensitive dan hilangkan spasi)
        $providedName = strtolower(preg_replace('/\s+/', '', $validated['bank_account_name']));
        $xenditName = strtolower(preg_replace('/\s+/', '', $xenditResponse['account_name']));

        if ($providedName !== $xenditName) {
            return response()->json([
                'message' => 'Nama rekening tidak cocok dengan data bank.',
                'expected_name' => $xenditResponse['account_name']
            ], 422);
        }

        $validated['is_verified'] = true;

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

        // Validasi ulang ke Xendit jika ada perubahan rekening
        $xenditResponse = $xenditBankService->validateBankAccount(
            $validated['bank_code'],
            $validated['bank_account_number']
        );

        if (!$xenditResponse || !isset($xenditResponse['account_name'])) {
            return response()->json(['message' => 'Nomor rekening tidak valid atau tidak ditemukan.'], 422);
        }

        $providedName = strtolower(preg_replace('/\s+/', '', $validated['bank_account_name']));
        $xenditName = strtolower(preg_replace('/\s+/', '', $xenditResponse['account_name']));

        if ($providedName !== $xenditName) {
            return response()->json([
                'message' => 'Nama rekening tidak cocok dengan data bank.',
                'expected_name' => $xenditResponse['account_name']
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
}
