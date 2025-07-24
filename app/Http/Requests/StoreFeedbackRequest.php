<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Atur sesuai kebutuhan autentikasi
    }

    public function rules(): array
    {
        return [
            'event_id' => ['required', 'exists:events,event_id'],
            'rating' => ['required', 'integer', 'min:0', 'max:5'],
            'comment' => ['required', 'string'],
        ];
    }
}
