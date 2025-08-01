<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Transaction;
use App\Models\Event;
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
            'total_price' => 'required|numeric|min:1000',
            'payment_method' => 'required|string',
        ]);

        // Buat nomor invoice unik
        $noInvoice = 'INV-' . strtoupper(Str::random(8));

        // 1. Simpan transaksi ke database
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'event_id' => $request->event_id,
            'no_invoice' => $noInvoice,
            'total_price' => $request->total_price,
            'status_pembayaran' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        // 2. Buat invoice via Xendit
        $invoice = $this->paymentService->createInvoice([
            'external_id' => $transaction->no_invoice,
            'amount' => $transaction->total_price,
            'payer_email' => Auth::user()->email,
            'description' => 'Pembayaran Tiket Event #' . $transaction->event_id,
            'customer' => [
                'given_names' => Auth::user()->name,
                'email' => Auth::user()->email
            ],
            'items' => [
                [
                    'name' => 'Tiket Event',
                    'quantity' => 1,
                    'price' => $transaction->total_price
                ]
            ],
            'success_redirect_url' => route('payment.success'),
            'failure_redirect_url' => route('payment.failed'),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'invoice_url' => $invoice['invoice_url'],
                'message' => 'Invoice created successfully.'
            ]);
        }

        return redirect($invoice['invoice_url']);
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
