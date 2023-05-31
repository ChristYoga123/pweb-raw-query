<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VenueCategoryController;
use App\Http\Controllers\Admin\VenueController;
use App\Http\Controllers\Admin\VenueGalleryController;
use App\Models\Venue;
use App\Models\VenueGallery;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/* Admin */
// Non Auth
Route::prefix("admin")->name("admin.")->group(function () {
    Route::get("login", [AuthController::class, "index"])->name("login.index");
    Route::post("login", [AuthController::class, "login"])->name("login");
});

// Auth
Route::prefix("admin")->name("admin.")->group(function () {
    Route::post("logout", [AuthController::class, "logout"])->name("logout");

    // Dashboard
    Route::get("/", [DashboardController::class, "index"])->name("dashboard.index");

    // Category Venue
    Route::resource('kategori_venue', VenueCategoryController::class);

    // Venue
    Route::resource('venue', VenueController::class);

    // Venue Gallery
    Route::resource("galeri_venue", VenueGalleryController::class);
});
