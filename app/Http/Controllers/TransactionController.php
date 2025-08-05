<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Event;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['user', 'event'])->latest()->get();
        return response()->json($transactions);
    }

    public function store(StoreTransactionRequest $request)
    {
        $event = Event::findOrFail($request->event_id);

        // Cek apakah event sudah berakhir
        if ($event->is_expired) {
            return response()->json([
                'message' => 'Tidak bisa membeli tiket untuk event yang sudah berakhir.'
            ], 403);
        }

        $transaction = Transaction::create($request->validated());

        return response()->json([
            'message' => 'Transaction created successfully',
            'data' => $transaction
        ], 201);
    }

    public function show($id)
    {
        $transaction = Transaction::with(['user', 'event'])->findOrFail($id);
        return response()->json($transaction);
    }

    public function update(UpdateTransactionRequest $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->validated());

        return response()->json([
            'message' => 'Transaction updated successfully',
            'data' => $transaction
        ]);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return response()->json([
            'message' => 'Transaction deleted successfully'
        ]);
    }
}
