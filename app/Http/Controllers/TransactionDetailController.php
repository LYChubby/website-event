<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTransactionDetailRequest;
use App\Http\Requests\UpdateTransactionDetailRequest;

class TransactionDetailController extends Controller
{
    public function index()
    {
        $details = TransactionDetail::with(['transaction.participant', 'ticket'])->latest()->get();
        return response()->json($details);
    }

    public function store(StoreTransactionDetailRequest $request)
    {
        $validated = $request->validated();

        // Hitung subtotal
        $validated['subtotal'] = $validated['quantity'] * $validated['price_per_ticket'];

        $detail = TransactionDetail::create($validated);
        return response()->json([
            'message' => 'Transaction detail created successfully',
            'data' => $detail
        ], 201);
    }

    public function show($id)
    {
        $detail = TransactionDetail::with(['transaction.participant', 'ticket'])->findOrFail($id);
        return response()->json($detail);
    }

    public function update(UpdateTransactionDetailRequest $request, $id)
    {
        $detail = TransactionDetail::findOrFail($id);
        $validated = $request->validated();

        // Hitung ulang subtotal
        $validated['subtotal'] = $validated['quantity'] * $validated['price_per_ticket'];

        $detail->update($validated);

        return response()->json([
            'message' => 'Transaction detail updated successfully',
            'data' => $detail
        ]);
    }

    public function destroy($id)
    {
        $detail = TransactionDetail::findOrFail($id);
        $detail->delete();

        return response()->json([
            'message' => 'Transaction detail deleted successfully'
        ]);
    }
}
