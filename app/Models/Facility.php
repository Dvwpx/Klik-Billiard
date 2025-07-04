<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'image',
    ];

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'facility_location', 'facility_id', 'location_id');
    }
}
