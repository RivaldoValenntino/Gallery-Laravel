<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Category;
use App\Models\Photo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $searchTerm = [
            'search' => request('search'),
            'category' => request('category'),
        ];

        $posts = Photo::with(['categories', 'user'])
            ->search($searchTerm)
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $title = 'All Posts';

        if (request('search')) {
            $title = 'Search results for : ' . request('search');
        }

        if (request('category')) {
            $category = Category::firstWhere('slug', request('category'));
            $title = 'Category : ' . $category->name;
        }

        return view('frontend.pages.index', [
            "title" => $title,
            "posts" => $posts
        ]);
    }
    public function show(Photo $photo){
        $photo = Photo::where('slug', $photo->slug)->first();
        $photo->increment('views');
        $title = $photo->judul;
        // return $photo->user->avatar;
        // return $photo->gambar;
        $allPhoto = Photo::where('category_id', $photo->category_id)->whereNotIn('id', [$photo->id])
        ->get();
        // return $allPhoto;
        return view('frontend.pages.show', compact('photo','title','allPhoto'));
    }

    public function albumPage(){
        $albums = Album::where('status',1)->get();
        $title = "Album";
        return view('frontend.pages.albums', compact('albums', 'title'));
    }
}