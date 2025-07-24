<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $primaryKey = 'ticket_id';

    protected $fillable = [
        'event_id',
        'ticket_code_prefix',
        'jenis_ticket',
        'price',
        'quantity_available',
        'quantity_sold',
        'start_pesan',
        'end_pesan',
        'is_active',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'ticket_id');
    }

    public function participants()
    {
        return $this->hasMany(Participant::class, 'ticket_id');
    }
}
