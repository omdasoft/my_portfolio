<?php

use App\Http\Controllers\FrontendController;
use App\Livewire\Backend\Dashboard;
use App\Livewire\Backend\Portfolio;
use App\Livewire\Backend\Profile;
use Illuminate\Support\Facades\Route;


Route::get('/', [FrontendController::class, 'index']);

/*
* Admin Routes
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function(){
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    Route::get('profile', Profile::class)->name('profile');
    
    Route::prefix('portfolio')->name('portfolio.')->group(function() {
        Route::get('list', Portfolio::class)->name('list');
    });
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
