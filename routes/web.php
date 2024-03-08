<?php

use App\Filament\Pages\AlbumDetail;
use App\Filament\Pages\ViewAlbumDetail;
use App\Models\User;
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

Route::get('/photos', [\App\Http\Controllers\HomeController::class, 'index'])->name('home'); // all photos page
Route::get('/photos/{photo:slug}', [\App\Http\Controllers\HomeController::class, 'show'])->name('show'); // single photo detail page
Route::get('/categories', [\App\Http\Controllers\HomeController::class, 'categoriesPage'])->name('categories'); // list of categories page
Route::get('/', function (){
    $title = 'Home';
    return view('frontend.pages.home', compact('title'));
}); // home landing page
Route::get('/home', function (){
    $title = 'Home';
    return view('frontend.pages.home', compact('title')); // home landing page
});
Route::get('/login', function () {
    return redirect(route('filament.admin.auth.login'));
})->name('login'); // fix filament route login

Route::fallback(function () {
    return view('frontend.pages.403');
}); // if no route found show error page