<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Ledger; // tambahkan model Ledger

class XenditWebhookController extends Controller
{
    public function handle(Request $req)
    {
        // Log semua data webhook
        Log::info('Xendit Webhook:', $req->all());

        // Validasi signature
        $signature = $req->header('x-callback-token'); // Case-sensitive!
        if (!$signature || $signature !== config('services.xendit.webhook_token')) {
            Log::error('Invalid Xendit Webhook Token');
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $event = $req->input('event');
        $data = $req->input('data');

        // Hanya proses invoice.paid dengan status PAID
        if ($event === 'invoice.paid' && ($data['status'] ?? null) === 'PAID') {
            $externalId = $data['external_id'] ?? null;
            $transaction = Transaction::with('event')->where('no_invoice', $externalId)->first();

            if (!$transaction) {
                Log::error("Invoice {$externalId} not found");
                return response()->json(['message' => 'Invoice not found'], 404);
            }

            // Proses hanya jika status belum PAID
            if (in_array($transaction->status_pembayaran, ['pending', 'expired'])) {
                DB::beginTransaction();
                try {
                    // 1. Update status transaksi
                    $transaction->update(['status_pembayaran' => 'paid']);

                    // 2. Proses ledger (pastikan relasi event ada)
                    $event = $transaction->event;
                    $organizerId = $event->user_id;
                    $amount = $transaction->total_price;

                    $fee = $amount * 0.10;
                    $netto = $amount - $fee;

                    Ledger::create([
                        'user_id' => null,
                        'transaction_id' => $transaction->transaction_id,
                        'type' => 'credit',
                        'amount' => $fee,
                        'description' => "Admin fee for {$transaction->no_invoice}"
                    ]);

                    Ledger::create([
                        'user_id' => $organizerId,
                        'transaction_id' => $transaction->transaction_id,
                        'type' => 'credit',
                        'amount' => $netto,
                        'description' => "Revenue for {$transaction->no_invoice}"
                    ]);

                    DB::commit();
                    Log::info("Invoice {$externalId} processed successfully");
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error("Failed to process invoice {$externalId}: " . $e->getMessage());
                    return response()->json(['message' => 'Processing failed'], 500);
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
