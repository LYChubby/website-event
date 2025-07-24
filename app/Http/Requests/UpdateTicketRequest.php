<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Sesuaikan jika mau pakai policy/permission.
    }

    public function rules(): array
    {
        return [
            'event_id' => 'sometimes|exists:events,event_id',
            'ticket_code_prefix' => 'sometimes|string|max:50',
            'jenis_ticket' => 'sometimes|in:VVIP,VIP,Reguler,Online',
            'price' => 'sometimes|numeric|min:0',
            'quantity_available' => 'sometimes|integer|min:0',
            'quantity_sold' => 'sometimes|integer|min:0',
            'start_pesan' => 'sometimes|date',
            'end_pesan' => 'sometimes|date|after_or_equal:start_pesan',
            'is_active' => 'sometimes|boolean',
        ];
    }
}
