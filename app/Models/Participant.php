<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $primaryKey = 'participant_id';

    protected $fillable = [
        'transaction_id',
        'nama',
        'user_id',
        'ticket_id',
        'event_id',
        'name_event',
        'jenis_ticket',
        'jumlah',
        'checkin_at',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relasi ke Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'ticket_id');
    }

    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'transaction_id');
    }

}
