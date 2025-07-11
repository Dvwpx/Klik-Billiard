<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Facility;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    public function index()
    {
        $locations = Location::where('status', 'open')->latest()->paginate(9);

        return view('public.locations.index', compact('locations'));
    }


    public function show($slug)
    {
        $location = Location::where('slug', $slug)->where('status', 'open')->firstOrFail();
        $showcaseFacilities = Facility::latest()->take(4)->get();

        return view('public.locations.show', compact('location', 'showcaseFacilities'));
    }
}
