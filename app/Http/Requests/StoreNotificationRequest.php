<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Sesuaikan jika ada policy
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,user_id',
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
            'type'    => 'required|in:email,system',
            'is_read' => 'boolean',
        ];
    }
}
