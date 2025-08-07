<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;
    protected $primaryKey = 'activity_id';
    protected $fillable = ['type', 'title', 'description'];
}
