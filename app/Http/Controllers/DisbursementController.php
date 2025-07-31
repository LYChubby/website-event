<?php

namespace App\Http\Controllers;

use App\Http\Requests\DisbursementRequest;
use App\Models\Disbursement;
use Illuminate\Http\Request;

class DisbursementController extends Controller
{
    public function index()
    {
        $disbursements = Disbursement::with(['event', 'organizer'])->get();
        return response()->json($disbursements);
    }

    public function store(DisbursementRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id; // Menambahkan user_id dari user yang login

        $disbursement = Disbursement::create($data);

        return response()->json([
            'message' => 'Disbursement created successfully',
            'data' => $disbursement
        ], 201);
    }


    public function show($id)
    {
        $disbursement = Disbursement::with(['event', 'organizer'])->findOrFail($id);
        return response()->json($disbursement);
    }

    public function update(DisbursementRequest $request, $id)
    {
        $disbursement = Disbursement::findOrFail($id);
        $disbursement->update($request->validated());

        return response()->json(['message' => 'Disbursement updated successfully', 'data' => $disbursement]);
    }

    public function destroy($id)
    {
        $disbursement = Disbursement::findOrFail($id);
        $disbursement->delete();

        return response()->json(['message' => 'Disbursement deleted successfully']);
    }
}
