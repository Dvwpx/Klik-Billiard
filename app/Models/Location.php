<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'address',
        'city',
        'description',
        'phone_number',
        'featured_image',
        'latitude',
        'longitude',
        'status',
        'map_url',
    ];

    public function tournaments()
    {
        return $this->hasMany(Tournament::class);
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'facility_location', 'location_id', 'facility_id');
    }
}
