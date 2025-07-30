<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizersInfo extends Model
{
    protected $primaryKey = 'organizer_info_id';

    protected $fillable = [
        'user_id',
        'bank_account_name',
        'bank_account_number',
        'bank_code',
        'is_verified',
        'disbursement_ready',
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
