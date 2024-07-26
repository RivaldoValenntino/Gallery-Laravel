<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\SocialiteController;
use App\Livewire\AlbumsPage;
use App\Livewire\CategoriesPage;
use App\Livewire\HomePage;
use App\Livewire\PhotoDisplay;
use App\Livewire\PhotoGallery;
use App\Livewire\PhotoList;
use App\Livewire\SinglePhoto;
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

Route::get('/', PhotoList::class);
Route::get('/photos', PhotoList::class)->name('allPhotos');
// all photos page
Route::get('/photos/{slug}', SinglePhoto::class)->name('showPhoto');
// single photo detail page
Route::get('/albums', AlbumsPage::class)->name('albumsPage');
Route::get('/categories', CategoriesPage::class)->name('categoriesPages'); // list of categories page
// Route::get('/home', HomePage::class)->name('homepage');
Route::get('/login', function () {
    return redirect(route('filament.admin.auth.login'));
})->name('login'); // fix filament route login

Route::fallback(fn () => view('errors.404')); // if no route found show error page