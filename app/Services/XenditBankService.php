<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class XenditBankService
{
    protected $secretKey;

    public function __construct()
    {
        $this->secretKey = config('services.xendit.secret_key');
    }

    public function validateBankAccount(string $bankCode, string $accountNumber)
    {
        $response = Http::withBasicAuth($this->secretKey, '')
            ->get('https://api.xendit.co/bank_account_data', [
                'bank_code' => $bankCode,
                'account_number' => $accountNumber,
            ]);

        if ($response->failed()) {
            return null;
        }

        return $response->json(); // returns account_name if success
    }
}
