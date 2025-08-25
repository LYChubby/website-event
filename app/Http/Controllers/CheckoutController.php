<?php

namespace App\Http\Controllers;


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Transaction;
use App\Models\Ticket;
use App\Models\Event;
use App\Models\Participant;
use App\Models\TransactionDetail;
use App\Models\Ledger;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;


// use Illuminate\Http\Request;
// use Illuminate\Support\Str;
// use App\Models\Transaction;
// use App\Models\Ticket;
// use App\Models\Event;
// use App\Models\Participant;
// use App\Models\TransactionDetail;
// use App\Models\Ledger;
// use App\Services\PaymentService;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function checkout(Request $request): JsonResponse|Redirector|RedirectResponse
    {
        $request->validate([
            'event_id' => 'required|exists:events,event_id',
            'ticket_id' => 'required|exists:tickets,ticket_id',
            'quantity' => 'required|integer|min:1',
            'nama' => 'required|string|max:255',
            'payment_method' => 'nullable|string',
        ]);

        $ticket = Ticket::with('event')->where('ticket_id', $request->ticket_id)->firstOrFail();
        $event = $ticket->event;
        
        // ✅ Validasi event expired
        if ($event->is_expired) {
            return response()->json([
                'message' => 'Tidak bisa membeli tiket untuk event yang sudah berakhir.'
            ], 403);
        }

        // ✅ Validasi event approval
        if ($event->status_approval !== 'approved') {
            return response()->json([
                'message' => 'Event belum disetujui, tiket tidak dapat dibeli.'
            ], 403);
        }

        // Validasi stok tiket
        if ($ticket->quantity_available < $request->quantity) {
            return response()->json([
                'message' => 'Stok tiket tidak mencukupi'
            ], 400);
        }

        $pricePerItem = (int) round($ticket->price);
        $amount = $pricePerItem * $request->quantity;
        $noInvoice = 'INV-' . strtoupper(Str::random(8));

        DB::beginTransaction();
        try {

            // 1. Simpan transaksi utama
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'event_id' => $request->event_id,
                'ticket_id' => $request->ticket_id,
                'no_invoice' => $noInvoice,
                'total_price' => $amount,
                'status_pembayaran' => 'pending',
                'payment_method' => $request->payment_method ?? "XENDIT",
                // Menyimpan informasi pending untuk Xendit Webhook
                'pending_quantity' => $request->quantity,
                'pending_nama' => $request->nama,
            ]);

            // 2. Simpan detail transaksi
            TransactionDetail::create([
                'transaction_id' => $transaction->transaction_id,
                'ticket_id' => $ticket->ticket_id,
                'jenis_ticket' => $ticket->jenis_ticket,
                'quantity' => $request->quantity,
                'price_per_ticket' => $pricePerItem,
                'subtotal' => $amount,
            ]);

            // 3. Siapkan invoice ke Xendit
            $invoiceData = [
                'external_id' => $transaction->no_invoice,
                'amount' => $amount,
                'payer_email' => Auth::user()->email,
                'description' => 'Pembayaran Tiket Event: ' . $ticket->event->name_event,
                'customer' => [
                    'given_names' => Auth::user()->name,
                    'email' => Auth::user()->email
                ],
                'success_redirect_url' => route('history.index'),
                'failure_redirect_url' => route('payment.failed'),
                'items' => [
                    [
                        'name' => $ticket->event->name_event,
                        'quantity' => $request->quantity,
                        'price' => $pricePerItem,
                        'category' => 'ticket',
                        'url' => route('events.show', ['id' => $request->event_id])
                    ]
                ]
            ];

            // 7. Kirim ke Xendit
            $invoice = $this->paymentService->createInvoice($invoiceData);

            DB::commit();

            return $request->expectsJson()
                ? response()->json([
                    'invoice_url' => $invoice['invoice_url'],
                    'message' => 'Invoice created successfully.'
                ])
                : redirect($invoice['invoice_url']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to create invoice: ' . $e->getMessage()
            ], 500);
        }
    }

    public function success()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $histories = Transaction::select(
            'transactions.transaction_id',
            'participants.nama as nama_peserta',
            'events.name_event',
            'events.venue_name',
            'events.venue_address',
            'transactions.created_at as tanggal_beli',
            'transactions.status_pembayaran'
        )
            ->leftJoin('participants', 'transactions.transaction_id', '=', 'participants.transaction_id')
            ->join('events', 'transactions.event_id', '=', 'events.event_id')
            ->where('transactions.user_id', Auth::id())
            ->latest('transactions.created_at')
            ->get();

        return view('history.index', compact('histories'));
    }

    public function failed()
    {
        return view('payment.failed');
    }
}
