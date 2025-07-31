<?php

namespace App\Services;

use Xendit\Invoice\InvoiceApi;

class PaymentService
{
    private InvoiceApi $invoiceApi;

    public function __construct(InvoiceApi $invoiceApi)
    {
        $this->invoiceApi = $invoiceApi;
    }

    /**
     * Buat invoice di Xendit dan kembalikan data invoice.
     */
    public function createInvoice(array $payload)
    {
        return $this->invoiceApi->createInvoice($payload);
    }
}
