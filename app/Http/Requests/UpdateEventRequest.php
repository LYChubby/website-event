<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category_id' => 'sometimes|exists:categories,category_id',
            'name_event' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'event_image' => 'nullable|image',
            'venue_name' => 'sometimes|string|max:255',
            'venue_address' => 'sometimes|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
        ];
    }
}
