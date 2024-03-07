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
Route::get('/photos', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/photos/author/{photo:user_id}', [\App\Http\Controllers\HomeController::class, 'author'])->name('author');
Route::get('/photos/{photo:slug}', [\App\Http\Controllers\HomeController::class, 'show'])->name('show');
Route::get('/albums', [\App\Http\Controllers\HomeController::class, 'albumsPage'])->name('album');
Route::get('/categories', [\App\Http\Controllers\HomeController::class, 'categoriesPage'])->name('categories');
Route::get('/photos/tag/{tag}', [App\Http\Controllers\HomeController::class, 'showByTag'])->name('photos.tag');
Route::get('/photos/authors/{user:username}', function (User $user) {
    $photos = $user->posts()->with('category')->paginate(9);
    return view('frontend.pages.author', [
        'title' => 'Author Posts',
        'user' => $user,
        'photos' => $photos,
    ]);
});

Route::get('/', function (){
    $title = 'Home';
    return view('frontend.pages.home', compact('title'));
});
Route::get('/home', function (){
    $title = 'Home';
    return view('frontend.pages.home', compact('title'));
});
Route::get('/login', function () {
    return redirect(route('filament.admin.auth.login'));
})->name('login');

Route::fallback(function () {
    return view('frontend.pages.403');
});