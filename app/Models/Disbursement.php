<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disbursement extends Model
{
    use HasFactory;

    protected $primaryKey = 'disbursement_id';

    protected $fillable = [
        'event_id',
        'user_id',
        'amount',
        'platform_fee',
        'status',
        'external_disbursement_id',
        'disbursed_at',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    // Relasi ke User (sebagai Organizer)
    public function organizer()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
