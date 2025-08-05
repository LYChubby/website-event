<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrganizerInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Atur sesuai kebutuhan autentikasi
    }

    public function rules(): array
    {
        $organizerInfoId = $this->route('organizer_info'); // Ambil ID dari route parameter

        return [
            // 'user_id' => [
            //     'required',
            //     'exists:users,user_id',
            //     Rule::unique('organizers_infos', 'user_id')->ignore($organizerInfoId, 'organizer_info_id'),
            // ],
            'bank_account_name' => 'required|string|max:100',
            'bank_account_number' => 'required|string|max:30',
            'bank_code' => 'required|string|max:10',
            'is_verified' => 'boolean',
            'disbursement_ready' => 'boolean',
        ];
    }
}
