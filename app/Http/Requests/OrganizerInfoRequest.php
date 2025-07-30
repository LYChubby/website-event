<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizerInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Sesuaikan jika perlu autentikasi khusus
    }

    public function rules(): array
{
    $organizerInfoId = $this->route('organizer_info'); // Nama parameter dari route

    return [
        'user_id' => [
            'required',
            'exists:users,user_id',
            'unique:organizers_infos,user_id' . ($organizerInfoId ? ',' . $organizerInfoId . ',organizer_info_id' : '')
        ],
        'bank_account_name' => 'required|string|max:100',
        'bank_account_number' => 'required|string|max:30',
        'bank_code' => 'required|string|max:10',
        'is_verified' => 'boolean',
        'disbursement_ready' => 'boolean',
    ];
}


    // public function rules(): array
    // {
    //     return [
    //         'user_id' => 'required|exists:users,user_id|unique:organizers_infos,user_id',
    //         'bank_account_name' => 'required|string|max:100',
    //         'bank_account_number' => 'required|string|max:30',
    //         'bank_code' => 'required|string|max:10',
    //         'is_verified' => 'boolean',
    //         'disbursement_ready' => 'boolean',
    //     ];
    // }
}
