<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Transaction;
use App\Models\Ticket;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;

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
            'payment_method' => 'required|string',
        ]);

        $ticket = Ticket::where('ticket_id', $request->ticket_id)->with('event')->firstOrFail();
        $pricePerItem = (int) round($ticket->price);
        $amount = $pricePerItem * $request->quantity;

        $noInvoice = 'INV-' . strtoupper(Str::random(8));

        // Simpan transaksi ke database
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'event_id' => $request->event_id,
            'ticket_id' => $request->ticket_id,
            'no_invoice' => $noInvoice,
            'total_price' => $amount,
            'status_pembayaran' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        // Siapkan invoice payload
        $invoiceData = [
            'external_id' => $transaction->no_invoice,
            'amount' => $amount,
            'payer_email' => Auth::user()->email,
            'description' => 'Pembayaran Tiket Event #' . $ticket->event->name_event,
            'customer' => [
                'given_names' => Auth::user()->name,
                'email' => Auth::user()->email
            ],
            'payment_methods' => [$request->payment_method],
            'success_redirect_url' => route('payment.success'),
            'failure_redirect_url' => route('payment.failed'),
        ];

        // Tambahkan items hanya jika kamu yakin field-nya valid
        $invoiceData['items'] = [
            [
                'name' => $ticket->name,
                'quantity' => $request->quantity,
                'price' => $pricePerItem,
                'category' => 'ticket',
                'url' => route('events.show', ['id' => $request->event_id])
            ]
        ];

        // Buat invoice di Xendit
        $invoice = $this->paymentService->createInvoice($invoiceData);

        // Respons tergantung request (API / Web)
        return $request->expectsJson()
            ? response()->json([
                'invoice_url' => $invoice['invoice_url'],
                'message' => 'Invoice created successfully.'
            ])
            : redirect($invoice['invoice_url']);
    }

    public function success()
    {
        return view('payment.success');
    }

    public function failed()
    {
        return view('payment.failed');
    }
}
