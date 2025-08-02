<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;

class XenditWebhookController extends Controller
{
    public function handle(Request $req)
    {
        // Verifikasi token callback
        $signature = $req->header('X-Callback-Token');
        $expectedToken = config('services.xendit.webhook_token');

        if (!$signature || $signature !== $expectedToken) {
            Log::warning('Invalid Xendit webhook token received', [
                'provided' => $signature,
                'expected' => $expectedToken,
            ]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $event = $req->input('event');
        $data = $req->input('data');

        if (!$event || !$data) {
            Log::error('Invalid Xendit webhook payload', [
                'payload' => $req->all()
            ]);
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        if ($event === 'invoice.paid') {
            $externalId = $data['external_id'] ?? null;

            if ($externalId) {
                $transaction = Transaction::where('no_invoice', $externalId)->first();

                if ($transaction) {
                    if ($transaction->status_pembayaran !== 'paid') {
                        $transaction->update([
                            'status_pembayaran' => 'paid',
                        ]);
                        Log::info("Transaksi berhasil dibayar: {$externalId}");
                    } else {
                        Log::info("Transaksi {$externalId} sudah pernah dibayar sebelumnya.");
                    }
                } else {
                    Log::warning("Transaksi dengan no_invoice {$externalId} tidak ditemukan.");
                }
            } else {
                Log::error('external_id tidak ditemukan pada payload invoice.paid', [
                    'data' => $data
                ]);
            }
        }

        return response()->json(['status' => 'OK']);
    }
}
