<?php

use App\Livewire\Backend\Dashboard;
use App\Livewire\Backend\Portfolio\Create;
use App\Livewire\Backend\Portfolio\Edit;
use App\Livewire\Backend\Portfolio\Index;
use App\Livewire\Backend\Portfolio\View;
use App\Livewire\Backend\Post\Create as PostCreate;
use App\Livewire\Backend\Post\Edit as PostEdit;
use App\Livewire\Backend\Post\Index as PostIndex;
use App\Livewire\Backend\Post\View as PostView;
use App\Livewire\Backend\Profile\Info;
use App\Livewire\Frontend\Index as FrontendIndex;
use App\Livewire\Frontend\Post\Index as FrontendPostIndex;
use Illuminate\Support\Facades\Route;

Route::get('/', FrontendIndex::class)->name('index');

Route::prefix('posts')->name('posts.')->group(function() {
    Route::get('/{tag?}', FrontendPostIndex::class)->name('index');
});

/*
* Admin Routes
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', Info::class)->name('info');
    });

    //Portfolio Routes
    Route::prefix('portfolios')->name('portfolios.')->group(function () {
        Route::get('/', Index::class)->name('index');
        Route::get('create', Create::class)->name('create');
        Route::get('edit/{id}', Edit::class)->name('edit');
        Route::get('view/{id}', View::class)->name('view');
    });

    //Post Routes
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', PostIndex::class)->name('index');
        Route::get('create', PostCreate::class)->name('create');
        Route::get('edit/{id}', PostEdit::class)->name('edit');
        Route::get('view/{id}', PostView::class)->name('view');
    });
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
