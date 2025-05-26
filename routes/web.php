<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WasteReportController;
use App\Http\Controllers\CarbonFootprintController;
use App\Http\Controllers\FoodListingController;
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

Route::middleware(['auth', 'verified'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Waste Reports routes
    Route::resource('waste-reports', WasteReportController::class);
    Route::patch('waste-reports/{wasteReport}/status', [WasteReportController::class, 'update'])->name('waste-reports.update-status');

    // Carbon Footprint routes
    Route::resource('carbon-footprints', CarbonFootprintController::class);
    Route::get('carbon-footprints/dashboard', [CarbonFootprintController::class, 'dashboard'])->name('carbon-footprints.dashboard');

    // Food Listings routes
    Route::resource('food-listings', FoodListingController::class);
    Route::patch('food-listings/{foodListing}/status', [FoodListingController::class, 'update'])->name('food-listings.update-status');
    Route::get('my-listings', [FoodListingController::class, 'myListings'])->name('food-listings.my-listings');
});

require __DIR__.'/auth.php';
