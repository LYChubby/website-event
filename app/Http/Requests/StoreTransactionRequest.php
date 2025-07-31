<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ubah jika ingin validasi otorisasi
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,user_id',
            'event_id' => 'required|exists:events,event_id',
            'no_invoice' => 'required|unique:transactions,no_invoice',
            'total_price' => 'required|numeric|min:0',
            'status_pembayaran' => 'in:pending,paid,expired',
            'payment_method' => 'required|string|max:255',
        ];
    }
}
