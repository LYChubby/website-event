<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionDetailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transaction_id' => 'sometimes|exists:transactions,transaction_id',
            'ticket_id' => 'sometimes|exists:tickets,ticket_id',
            'jenis_ticket' => 'sometimes|in:VVIP,VIP,Reguler,Online',
            'quantity' => 'sometimes|integer|min:1',
            'price_per_ticket' => 'sometimes|numeric|min:0',
        ];
    }
}
