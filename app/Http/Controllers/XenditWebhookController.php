<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;

class XenditWebhookController extends Controller
{
    // XenditWebhookController.php
    public function handle(Request $req)
    {
        Log::info('Xendit Webhook Received', $req->all());

        $signature = $req->header('X-Callback-Token'); // Lowercase!
        $expectedToken = config('services.xendit.webhook_token');

        if (!$signature || $signature !== $expectedToken) {
            Log::error('Invalid Xendit Webhook Token', [
                'received' => $signature,
                'expected' => $expectedToken
            ]);
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $event = $req->input('event');
        $data = $req->input('data');

        if ($event === 'invoice.paid') {
            $externalId = $data['external_id'] ?? null;
            $transaction = Transaction::where('no_invoice', $externalId)->first();

            if (!$transaction) {
                Log::error("Invoice {$externalId} not found");
                return response()->json(['message' => 'Invoice not found'], 404);
            }

            if ($transaction->status_pembayaran !== 'paid') {
                $transaction->update(['status_pembayaran' => 'paid']);
                Log::info("Invoice {$externalId} marked as paid");
            }
        }

        return response()->json(['status' => 'success']);
    }
}
