<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ← Tambahkan ini


class Category extends Model
{
    use HasFactory;
    protected $primaryKey = 'category_id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'created_at',
    ];

    public function events()
    {
        return $this->hasMany(Event::class, 'category_id');
    }
}
