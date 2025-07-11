<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'nickname',
        'profile_image',
        'bio',
        'achievements',
        'status',
    ];

    public function wonTournaments()
    {
        return $this->hasMany(Tournament::class, 'winner_id');
    }
}
