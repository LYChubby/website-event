<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\Ledger;

class XenditWebhookController extends Controller
{
    public function handle(Request $req)
    {
        // Log untuk memastikan webhook dipanggil
        file_put_contents(
            storage_path('logs/webhook_test.log'),
            date('Y-m-d H:i:s') . " - Webhook called from IP: " . $req->ip() . "\n",
            FILE_APPEND
        );

        // Log SEMUA request yang masuk untuk debugging
        Log::info('=== XENDIT WEBHOOK RECEIVED ===');
        Log::info('Request Method: ' . $req->method());
        Log::info('Request URL: ' . $req->fullUrl());
        Log::info('Request IP: ' . $req->ip());
        Log::info('User Agent: ' . $req->userAgent());
        Log::info('Headers:', $req->headers->all());
        Log::info('Request Data:', $req->all());

        // Validasi signature
        $signature = $req->header('x-callback-token');
        $expectedToken = config('services.xendit.webhook_token');

        Log::info('Signature Check:', [
            'received' => $signature,
            'expected' => $expectedToken,
            'match' => ($signature === $expectedToken)
        ]);

        if (!$signature || $signature !== $expectedToken) {
            Log::error('Invalid Xendit Webhook Token');
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $event = $req->input('event');
        $data = $req->input('data');

        // Jika data langsung di root (format Xendit yang sebenarnya)
        if (!$event && !$data) {
            $status = $req->input('status');
            $externalId = $req->input('external_id');

            Log::info('Direct Xendit Format Detected:', [
                'status' => $status,
                'external_id' => $externalId
            ]);

            // Proses jika status PAID
            if ($status === 'PAID' && $externalId) {
                Log::info("Processing paid invoice: {$externalId}");

                $transaction = Transaction::with('event')->where('no_invoice', $externalId)->first();

                if (!$transaction) {
                    Log::error("Transaction not found for invoice: {$externalId}");
                    return response()->json(['message' => 'Invoice not found'], 404);
                }

                Log::info('Transaction Found:', [
                    'transaction_id' => $transaction->transaction_id,
                    'current_status' => $transaction->status_pembayaran,
                    'total_price' => $transaction->total_price,
                    'event_id' => $transaction->event_id
                ]);

                // Proses hanya jika status belum PAID
                if (in_array($transaction->status_pembayaran, ['pending', 'expired'])) {
                    DB::beginTransaction();
                    try {
                        // 1. Update status transaksi
                        $transaction->update(['status_pembayaran' => 'paid']);
                        Log::info("Transaction status updated to paid for: {$externalId}");

                        // 2. Proses ledger (pastikan relasi event ada)
                        if (!$transaction->event) {
                            throw new \Exception('Event relation not found');
                        }

                        $event = $transaction->event;
                        $organizerId = $event->user_id;
                        $amount = $transaction->total_price;

                        Log::info('Ledger Processing Data:', [
                            'organizer_id' => $organizerId,
                            'amount' => $amount,
                            'event_name' => $event->name_event ?? 'no_name'
                        ]);

                        $fee = $amount * 0.10;
                        $netto = $amount - $fee;

                        // Entry ledger untuk admin fee
                        $adminLedger = Ledger::create([
                            'user_id' => null,
                            'transaction_id' => $transaction->transaction_id,
                            'type' => 'credit',
                            'amount' => $fee,
                            'description' => "Admin fee for {$transaction->no_invoice}"
                        ]);

                        Log::info('Admin Ledger Created:', [
                            'ledger_id' => $adminLedger->id,
                            'amount' => $fee
                        ]);

                        // Entry ledger untuk organizer revenue
                        $organizerLedger = Ledger::create([
                            'user_id' => $organizerId,
                            'transaction_id' => $transaction->transaction_id,
                            'type' => 'credit',
                            'amount' => $netto,
                            'description' => "Revenue for {$transaction->no_invoice}"
                        ]);

                        Log::info('Organizer Ledger Created:', [
                            'ledger_id' => $organizerLedger->id,
                            'amount' => $netto,
                            'organizer_id' => $organizerId
                        ]);

                        DB::commit();
                        Log::info("=== INVOICE {$externalId} PROCESSED SUCCESSFULLY ===");
                    } catch (\Exception $e) {
                        DB::rollBack();
                        Log::error("Failed to process invoice {$externalId}:", [
                            'error' => $e->getMessage(),
                            'line' => $e->getLine(),
                            'file' => $e->getFile(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        return response()->json(['message' => 'Processing failed'], 500);
                    }
                } else {
                    Log::info("Invoice {$externalId} already processed (status: {$transaction->status_pembayaran})");
                }

                Log::info('=== XENDIT WEBHOOK END ===');
                return response()->json(['status' => 'success']);
            }
        }

        Log::info('Event Processing:', [
            'event_type' => $event,
            'data_status' => $data['status'] ?? 'no_status',
            'external_id' => $data['external_id'] ?? 'no_external_id'
        ]);

        // Hanya proses invoice.paid dengan status PAID
        if ($event === 'invoice.paid' && ($data['status'] ?? null) === 'PAID') {
            $externalId = $data['external_id'] ?? null;

            Log::info("Processing paid invoice: {$externalId}");

            $transaction = Transaction::with('event')->where('no_invoice', $externalId)->first();

            if (!$transaction) {
                Log::error("Transaction not found for invoice: {$externalId}");
                return response()->json(['message' => 'Invoice not found'], 404);
            }

            Log::info('Transaction Found:', [
                'transaction_id' => $transaction->transaction_id,
                'current_status' => $transaction->status_pembayaran,
                'total_price' => $transaction->total_price,
                'event_id' => $transaction->event_id
            ]);

            // Proses hanya jika status belum PAID
            if (in_array($transaction->status_pembayaran, ['pending', 'expired'])) {
                DB::beginTransaction();
                try {
                    // 1. Update status transaksi
                    $transaction->update(['status_pembayaran' => 'paid']);
                    Log::info("Transaction status updated to paid for: {$externalId}");

                    // 2. Proses ledger (pastikan relasi event ada)
                    if (!$transaction->event) {
                        throw new \Exception('Event relation not found');
                    }

                    $event = $transaction->event;
                    $organizerId = $event->user_id;
                    $amount = $transaction->total_price;

                    Log::info('Ledger Processing Data:', [
                        'organizer_id' => $organizerId,
                        'amount' => $amount,
                        'event_name' => $event->name_event ?? 'no_name'
                    ]);

                    $fee = $amount * 0.10;
                    $netto = $amount - $fee;

                    // Entry ledger untuk admin fee
                    $adminLedger = Ledger::create([
                        'user_id' => null,
                        'transaction_id' => $transaction->transaction_id,
                        'type' => 'credit',
                        'amount' => $fee,
                        'description' => "Admin fee for {$transaction->no_invoice}"
                    ]);

                    Log::info('Admin Ledger Created:', [
                        'ledger_id' => $adminLedger->id,
                        'amount' => $fee
                    ]);

                    // Entry ledger untuk organizer revenue
                    $organizerLedger = Ledger::create([
                        'user_id' => $organizerId,
                        'transaction_id' => $transaction->transaction_id,
                        'type' => 'credit',
                        'amount' => $netto,
                        'description' => "Revenue for {$transaction->no_invoice}"
                    ]);

                    Log::info('Organizer Ledger Created:', [
                        'ledger_id' => $organizerLedger->id,
                        'amount' => $netto,
                        'organizer_id' => $organizerId
                    ]);

                    DB::commit();
                    Log::info("=== INVOICE {$externalId} PROCESSED SUCCESSFULLY ===");
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error("Failed to process invoice {$externalId}:", [
                        'error' => $e->getMessage(),
                        'line' => $e->getLine(),
                        'file' => $e->getFile(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    return response()->json(['message' => 'Processing failed'], 500);
                }
            } else {
                Log::info("Invoice {$externalId} already processed (status: {$transaction->status_pembayaran})");
            }
        } else {
            Log::info('Event ignored:', [
                'event' => $event,
                'status' => $data['status'] ?? 'no_status',
                'reason' => 'Not invoice.paid with PAID status'
            ]);
        }

        Log::info('=== XENDIT WEBHOOK END ===');
        return response()->json(['status' => 'success']);
    }
}
