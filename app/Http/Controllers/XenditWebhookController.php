<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class XenditWebhookController extends Controller
{
    public function handle(Request $req)
    {
        $signature = $req->header('X-Callback-Token');

        if ($signature !== config('services.xendit.webhook_token')) {
            Log::warning('Invalid Xendit webhook signature', ['provided' => $signature]);
            abort(403, 'Invalid signature');
        }

        $event = $req->input('event');
        $data  = $req->input('data');

        if ($event === 'invoice.paid') {
            $externalId = $data['external_id'];

            // Temukan transaksi berdasarkan external_id (no_invoice)
            $transaction = Transaction::where('no_invoice', $externalId)->first();

            if ($transaction && $transaction->status_pembayaran !== 'paid') {
                $transaction->update([
                    'status_pembayaran' => 'paid',
                ]);

                // Tambahan: logika otomatis bisa ditambahkan di sini jika perlu
                Log::info("Transaksi berhasil dibayar: {$externalId}");
            }
        }

        return response()->json(['status' => 'OK']);
    }
}
