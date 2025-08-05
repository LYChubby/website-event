<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $primaryKey = 'event_id';

    protected $fillable = [
        'user_id',
        'category_id',
        'name_event',
        'description',
        'event_image',
        'venue_name',
        'venue_address',
        'start_date',
        'end_date',
        'status_approval',
    ];

    // Relasi ke User (Organizer)
    public function organizer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Relasi ke Ticket
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'event_id');
    }

    // Relasi ke Transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'event_id');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class, 'event_id');
    }

    public function disbursement()
    {
        return $this->hasOne(Disbursement::class, 'event_id', 'event_id');
    }
    // Event.php
    public function getIsExpiredAttribute(): bool
    {
        return now()->greaterThan($this->end_date);
    }


}
