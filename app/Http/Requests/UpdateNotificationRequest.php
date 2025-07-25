<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Sesuaikan jika ada policy
    }

    public function rules(): array
    {
        return [
            'title'   => 'sometimes|required|string|max:255',
            'message' => 'sometimes|required|string',
            'type'    => 'sometimes|required|in:email,system',
            'is_read' => 'sometimes|boolean',
        ];
    }
}
