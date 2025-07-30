<?php

namespace App\Services;

use Xendit\Xendit;

class DisbursementService
{
    public function send(array $payload): array
    {
        return Xendit::createDisbursement($payload);
    }
}
