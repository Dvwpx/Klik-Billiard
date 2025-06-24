<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'poster_image',
        'start_date',
        'end_date',
        'status',
        'location_id',
        'winner_id',
    ];

    /**
     * Relasi: Turnamen ini berlokasi di satu tempat.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Relasi: Turnamen ini memiliki satu pemenang (seorang pemain).
     */
    public function winner()
    {
        return $this->belongsTo(Player::class, 'winner_id');
    }
}
