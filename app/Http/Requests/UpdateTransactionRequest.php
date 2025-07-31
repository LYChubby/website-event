<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|exists:users,user_id',
            'event_id' => 'sometimes|exists:events,event_id',
            'no_invoice' => 'sometimes|unique:transactions,no_invoice,' . $this->route('transaction'),
            'total_price' => 'sometimes|numeric|min:0',
            'status_pembayaran' => 'sometimes|in:pending,paid,expired',
            'payment_method' => 'sometimes|string|max:255',
        ];
    }
}
