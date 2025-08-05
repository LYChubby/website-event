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
            ->post('https://api.xendit.co/account_validation', [
                'bank_code' => $bankCode,
                'account_number' => $accountNumber,
            ]);

        if ($response->failed()) {
            return null;
        }

        return $response->json(); // Akan mengandung 'account_holder_name'
    }

    public function getAvailableBanks()
    {
        $response = Http::withBasicAuth($this->secretKey, '')
            ->get('https://api.xendit.co/disbursement_banks');

        if ($response->successful()) {
            return $response->json(); // array of banks
        }

        return []; // fallback if gagal
    }
}
