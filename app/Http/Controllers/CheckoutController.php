<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Transaction;
use App\Models\Ticket;
use App\Models\Participant;
use App\Models\TransactionDetail;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,event_id',
            'ticket_id' => 'required|exists:tickets,ticket_id',
            'quantity' => 'required|integer|min:1',
            'nama' => 'required|string|max:255',
            'payment_method' => 'nullable|string',
        ]);

        $ticket = Ticket::with('event')->where('ticket_id', $request->ticket_id)->firstOrFail();

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
            // 1. Update stok tiket
            $ticket->quantity_available -= $request->quantity;
            $ticket->quantity_sold += $request->quantity;
            $ticket->save();

            // 2. Simpan transaksi utama
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'event_id' => $request->event_id,
                'ticket_id' => $request->ticket_id,
                'no_invoice' => $noInvoice,
                'total_price' => $amount,
                'status_pembayaran' => 'pending',
                'payment_method' => $request->payment_method ?? "XENDIT",
            ]);

            // 3. Simpan detail transaksi
            TransactionDetail::create([
                'transaction_id' => $transaction->transaction_id,
                'ticket_id' => $ticket->ticket_id,
                'jenis_ticket' => $ticket->jenis_ticket,
                'quantity' => $request->quantity,
                'price_per_ticket' => $pricePerItem,
                'subtotal' => $amount,
            ]);

            // 4. Simpan data peserta
            Participant::create([
                'user_id' => Auth::id(),
                'event_id' => $request->event_id,
                'nama' => $request->nama,
                'name_event' => $ticket->event->name_event,
                'ticket_id' => $ticket->ticket_id,
                'jenis_ticket' => $ticket->jenis_ticket,
                'jumlah' => $request->quantity,
            ]);

            // 5. Siapkan invoice ke Xendit
            $invoiceData = [
                'external_id' => $transaction->no_invoice,
                'amount' => $amount,
                'payer_email' => Auth::user()->email,
                'description' => 'Pembayaran Tiket Event: ' . $ticket->event->name_event,
                'customer' => [
                    'given_names' => Auth::user()->name,
                    'email' => Auth::user()->email
                ],
                'success_redirect_url' => route('payment.success'),
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

            // 6. Kirim ke Xendit
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

        $histories = Transaction::with(['event', 'user'])
            ->where('user_id', $user->user_id)
            ->latest()
            ->get()
            ->map(function ($transaction) {
                return [
                    'transaction_id'     => $transaction->transaction_id,
                    'nama_pembeli'       => $transaction->user->name ?? '-',
                    'nama_event'         => $transaction->event->name_event ?? '-',
                    'tanggal_beli'       => $transaction->created_at,
                    'status_pembayaran'  => $transaction->status_pembayaran ?? 'pending',
                ];
            });

        // Kirim ke view history.index
        return view('history.index', compact('histories'));
    }

    public function failed()
    {
        return view('payment.failed');
    }
}
