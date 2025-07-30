<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizerInfo extends Model
{
    use HasFactory;

    protected $table = 'organizers_infos'; // ✅ Tambahkan baris ini
    protected $primaryKey = 'organizer_info_id';

    protected $fillable = [
        'user_id',
        'bank_account_name',
        'bank_account_number',
        'bank_code',
        'is_verified',
        'disbursement_ready',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
