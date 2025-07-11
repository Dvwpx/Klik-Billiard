<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilitysController extends Controller
{
    private function getAmenities()
    {
        return [
            'Parkir Luas & Aman',
            'Koneksi WiFi Cepat',
            'Sistem Ventilasi & AC',
            'Area Bebas Asap Rokok',
            'Cafe & Resto',
            'Musholla',
        ];
    }

    public function index()
    {
        $amenities = [
            ['icon' => 'fas fa-parking', 'name' => 'Parkir Luas & Aman'],
            ['icon' => 'fas fa-wifi', 'name' => 'Koneksi WiFi Cepat'],
            ['icon' => 'fas fa-mug-hot', 'name' => 'Cafe & Resto'],
            ['icon' => 'fas fa-smoking', 'name' => 'Smoking Area'],
            ['icon' => 'fas fa-restroom', 'name' => 'Toilet Bersih'],
            ['icon' => 'fas fa-solid fa-ban-smoking', 'name' => 'Vape Only Area'],
        ];
        $categories = Facility::select('category')->distinct()->orderBy('category')->get();
        $facilities = Facility::latest()->paginate(12);

        return view('public.facilities.index', compact('facilities', 'categories', 'amenities'));
    }

    public function byCategory($category)
    {
        $amenities = $this->getAmenities();
        $categories = Facility::select('category')->distinct()->orderBy('category')->get();
        $facilities = Facility::where('category', $category)->latest()->paginate(12);

        return view('public.facilities.index', compact('facilities', 'categories', 'amenities', 'category'));
    }
}
