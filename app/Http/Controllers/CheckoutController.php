<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;

class CheckoutController extends Controller
{
    public function checkout(Request $req, PaymentService $paymentService)
    {
        // 1. Simpan data order/transaksi di DB dengan status “pending”
        // 2. Panggil Xendit Invoice
        $invoice = $paymentService->createInvoice([
            'external_id' => 'order-' . $order->id,
            'amount'      => $order->total,
            // …payload lainnya
        ]);

        // 3. Redirect user ke $invoice['invoice_url']
        return redirect($invoice->invoice_url);
    }
}
