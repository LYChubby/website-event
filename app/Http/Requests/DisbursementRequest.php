<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisbursementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,event_id',
            // 'user_id' => 'required|exists:users,user_id',
            'amount' => 'required|numeric|min:0',
            'platform_fee' => 'required|numeric|min:0',
            'status' => 'in:sent,completed,failed',
            'external_disbursement_id' => 'nullable|string',
            'disbursed_at' => 'nullable|date',
        ];
    }
}
