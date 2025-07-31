<?php

namespace App\Services;

use Xendit\Payout\PayoutApi;

class DisbursementService
{
    private PayoutApi $payoutApi;
    public function send(array $payload): \Xendit\Payout\GetPayouts200ResponseDataInner
    {
        return $this->payoutApi->createPayout($payload);
    }
}
