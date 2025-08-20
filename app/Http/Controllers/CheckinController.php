<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckinController extends Controller
{
    public function processCheckin($no_invoice)
    {
        // Cari transaction berdasarkan no_invoice
        $transaction = Transaction::with(['participants'])
            ->where('no_invoice', $no_invoice)
            ->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        // Jika sudah check-in semua
        if ($transaction->participants->every(fn($p) => $p->checkin_at !== null)) {
            return response()->json(['message' => 'All participants already checked in'], 200);
        }

        // Update checkin_at untuk semua participant dalam transaksi ini
        try {
            DB::beginTransaction();

            $now = now();
            Participant::where('transaction_id', $transaction->transaction_id)
                ->whereNull('checkin_at')
                ->update(['checkin_at' => $now]);

            DB::commit();

            // Ambil ulang data participants (supaya sudah terupdate)
            $participants = Participant::where('transaction_id', $transaction->transaction_id)->get();

            return response()->json([
                'message' => 'Check-in successful',
                'checked_in_at' => $now->toDateTimeString(),
                'participants' => $participants->map(fn($p) => [
                    'jenis_ticket' => $p->jenis_ticket,
                    'jumlah' => $p->jumlah,
                    'checkin_at' => $now->toDateTimeString()
                ])
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Check-in failed: ' . $e->getMessage()], 500);
        }
    }


    // Untuk halaman scan QR code oleh panitia
    public function showScanner()
    {
        return view('checkin.scanner');
    }
}
