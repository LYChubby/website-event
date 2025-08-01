<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionDetailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transaction_id' => 'required|exists:transactions,transaction_id',
            'ticket_id' => 'required|exists:tickets,ticket_id',
            'jenis_ticket' => 'required|in:VVIP,VIP,Reguler,Online',
            'quantity' => 'required|integer|min:1',
            'price_per_ticket' => 'required|numeric|min:0',
        ];
    }
}
