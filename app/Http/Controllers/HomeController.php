<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Category;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $searchTerm = [
            'search' => request('search'),
            'category' => request('category'),
            'author' => request('author'),
        ];

        $posts = Photo::with(['categories', 'user'])
            ->search($searchTerm)
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $title = 'All Photos';

        if (request('search')) {
            $title = 'Search results for : ' . request('search');
        }

        if (request('category')) {
            $category = Category::firstWhere('slug', request('category'));
            $title = 'Category : ' . $category->name;
        }

        if (request('author')) {
            $author = User::firstWhere('username', request('author'));
            $title = 'Posted by ' . $author->name;
        }

        return view('frontend.pages.index', [
            "title" => $title,
            "posts" => $posts
        ]);
    }
    public function show(Photo $photo)
    {
        $photo = Photo::where('slug', $photo->slug)->with('user')->first();
        $photo->increment('views');
        $title = $photo->judul;
        // return $photo->user->avatar;
        // return $photo->gambar;
        $allPhoto = Photo::where('category_id', $photo->category_id)->whereNotIn('id', [$photo->id])
        ->get();
        // return $allPhoto;
        return view('frontend.pages.show', compact('photo', 'title', 'allPhoto'));
    }

  
    public function categoriesPage()
    {
        $categories = Category::with('photos')->get();
        $title = "Categories";
        return view('frontend.pages.categories', compact('categories', 'title'));
    }

    public function showByTag($tag)
    {
        $title = "Tag : " . $tag;
        $tagArray = explode(',', $tag);
        $tagName = implode(', ', $tagArray);

        $searchTerm = [
            'search' => request('search'),
            'tag' => $tag,
        ];

        $photos = Photo::with(['categories', 'user'])
            ->search($searchTerm)
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('frontend.pages.tag', compact('photos', 'title', 'tagName'));
    }

}