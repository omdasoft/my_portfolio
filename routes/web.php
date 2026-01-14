<?php

use App\Http\Controllers\Admin\ImageController;
use App\Livewire\Backend\Contact\Index as ContactIndex;
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
use App\Livewire\Frontend\Portfolio\Index as PortfolioIndex;
use App\Livewire\Frontend\Portfolio\Show as PortfolioShow;
use App\Livewire\Frontend\Post\Index as FrontendPostIndex;
use App\Livewire\Frontend\Post\Show as FrontendPostShow;
use Illuminate\Support\Facades\Route;

Route::get('/', FrontendIndex::class)->name('index');

Route::prefix('posts')->name('posts.')->group(function (): void {
    Route::get('/{tag?}', FrontendPostIndex::class)->name('index');
    Route::get('/show/{slug}', FrontendPostShow::class)->name('show');
});

Route::prefix('portfolios')->name('portfolios.')->group(function (): void {
    Route::get('/', PortfolioIndex::class)->name('index');
    Route::get('{slug}', PortfolioShow::class)->name('show');
});

/*
* Admin Routes
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function (): void {
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function (): void {
        Route::get('/', Info::class)->name('info');
    });

    // Portfolio Routes
    Route::prefix('portfolios')->name('portfolios.')->group(function (): void {
        Route::get('/', Index::class)->name('index');
        Route::get('create', Create::class)->name('create');
        Route::get('edit/{id}', Edit::class)->name('edit');
        Route::get('view/{id}', View::class)->name('view');
    });

    // Post Routes
    Route::prefix('posts')->name('posts.')->group(function (): void {
        Route::get('/', PostIndex::class)->name('index');
        Route::get('create', PostCreate::class)->name('create');
        Route::get('edit/{id}', PostEdit::class)->name('edit');
        Route::get('view/{id}', PostView::class)->name('view');
    });

    // Contact routes
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', ContactIndex::class)->name('index');
    });

    Route::post('/upload-tinymce-image', [ImageController::class, 'uploadTinyMCEImage'])->name('tinymce.upload');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
