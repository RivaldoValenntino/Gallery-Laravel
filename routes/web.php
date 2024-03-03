<?php

use App\Filament\Pages\AlbumDetail;
use App\Filament\Pages\ViewAlbumDetail;
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
Route::get('/photos', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/photos/{photo:slug}', [\App\Http\Controllers\HomeController::class, 'show'])->name('show');
Route::get('/album', [\App\Http\Controllers\HomeController::class, 'albumPage'])->name('album');
Route::get('/categories', [\App\Http\Controllers\HomeController::class, 'categoriesPage'])->name('categories');

// data - src = "{{ asset('storage/' . $post->gambar . '') }}"
// Route::get('/albums/{record}/detail', [ViewAlbumDetail::class, 'handle'])->name('view-detail');


// Route::get('/home', fn () => view('home'));


Route::get('/', function (){
    $title = 'Home';
    return view('frontend.pages.home', compact('title'));
});
Route::get('/home', function (){
    $title = 'Home';
    return view('frontend.pages.home');
});