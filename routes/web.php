<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\LocationsController;
use App\Http\Controllers\Frontend\TournamentsController;
use App\Http\Controllers\Frontend\FacilitysController;
use App\Http\Controllers\Frontend\MenuItemsController;
use App\Http\Controllers\Frontend\PlayersController;




/*
|--------------------------------------------------------------------------
| Rute untuk Pengunjung (Frontend)
|--------------------------------------------------------------------------
*/

// RUTE HOMEPAGE
Route::get('/', [HomeController::class, 'index'])->name('home');

// RUTE UNTUK ABOUTT
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');

// Halaman untuk menampilkan semua artikel
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');

// Halaman untuk menampilkan satu artikel berdasarkan slug-nya
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// RUTE UNTUK MENAMPILKAN SEMUA LOKASI
Route::get('/lokasi', [LocationsController::class, 'index'])->name('locations.public.index');
Route::get('/lokasi/{slug}', [LocationsController::class, 'show'])->name('locations.public.show');

// RUTE BARU PEMAIN
Route::get('/pemain', [PlayerController::class, 'index'])->name('players.public.index');
Route::get('/pemain/{slug}', [PlayerController::class, 'show'])->name('players.public.show');

// RUTE UNTUK MENAMPILKAN TURNAMEN
Route::get('/turnamen', [TournamentsController::class, 'index'])->name('tournaments.public.index');
Route::get('/turnamen/{slug}', [TournamentsController::class, 'show'])->name('tournaments.public.show');

// RUTE UNTUK MENAMPILKAN FASILITAS
Route::get('/fasilitas', [FacilitysController::class, 'index'])->name('facilities.public.index');
Route::get('/fasilitas/kategori/{category}', [FacilitysController::class, 'byCategory'])->name('facilities.public.byCategory');

// RUTE UNTUK MENAMPILKAN MENU
Route::get('/menu', [MenuItemsController::class, 'index'])->name('menu.public.index');






/*
|--------------------------------------------------------------------------
| Rute untuk Admin (Backend)
|--------------------------------------------------------------------------
*/

// Rute untuk menampilkan halaman login
Route::get('/login', [LoginController::class, 'index'])->name('login');

// Rute untuk memproses data login
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

// Rute untuk logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Grup rute yang hanya bisa diakses setelah login
Route::middleware(['auth'])->group(function () {


    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    // Rute resource untuk User
    Route::resource('users', UserController::class);

    // RUTE UNTUK ARTIKEL
    Route::resource('articles', ArticleController::class);

    // RUTE UNTUK LOKASI
    Route::resource('locations', LocationController::class);

    // RUTE UNTUK PEMAIN
    Route::resource('players', PlayerController::class);

    // RUTE UNTUK TURNAMEN
    Route::resource('tournaments', TournamentController::class);

    // RUTE UNTUK FASILITAS
    Route::resource('facilities', FacilityController::class);

    // RUTE UNTUK MENU ITEM    
    Route::resource('menu-items', MenuItemController::class);
});
