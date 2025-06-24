<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemsController extends Controller
{
    public function index()
    {
        // Ambil semua item menu yang statusnya 'Tersedia'
        $menuItems = MenuItem::where('status', 'Tersedia')->get();

        // Kelompokkan item berdasarkan kategori
        $groupedMenuItems = $menuItems->groupBy('category');

        return view('public.menu.index', compact('groupedMenuItems'));
    }
}
