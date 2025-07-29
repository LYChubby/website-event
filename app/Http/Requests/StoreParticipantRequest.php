<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,user_id',
            'ticket_id' => 'required|exists:tickets,ticket_id',
            'event_id' => 'required|exists:events,event_id',
            'name_event' => 'required|string|max:255',
            'jenis_ticket' => 'required|in:VVIP,VIP,Reguler,Online',
            'jumlah' => 'required|integer|min:1',
        ];
    }
}