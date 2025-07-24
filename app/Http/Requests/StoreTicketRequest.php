<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,event_id',
            'ticket_code_prefix' => 'required|string|max:50',
            'jenis_ticket' => 'required|in:VVIP,VIP,Reguler,Online',
            'price' => 'required|numeric|min:0',
            'quantity_available' => 'required|integer|min:0',
            'start_pesan' => 'required|date',
            'end_pesan' => 'required|date|after:start_pesan',
            'is_active' => 'boolean',
        ];
    }
}
