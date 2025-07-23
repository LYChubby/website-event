<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category_id' => 'required|exists:categories,category_id',
            'nama_event' => 'required|string|max:255',
            'description' => 'required|string',
            'event_image' => 'nullable|image',
            'venue_name' => 'required|string|max:255',
            'venue_address' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }
}
