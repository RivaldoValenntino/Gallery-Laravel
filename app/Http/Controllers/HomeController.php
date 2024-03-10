<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Category;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = [
            'search' => request('search'),
            'category' => request('category'),
            'author' => request('author'),
            'tag' => request('tag'),
        ];

        $query = Photo::with(['categories', 'user'])->search($searchTerm)->where('status', 1);

        switch (request('sort_by')) {
            case 'likes':
                $query->withCount('likes')->orderByDesc('likes_count');
                break;
            case 'comments':
                $query->withCount('comments')->orderByDesc('comments_count');
                break;
            case 'views':
                $query->orderByDesc('views');
                break;
            default:
                $query->latest();
                break;
        }
        $photos = $query->get();
        
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
            $title = 'Posted by @'.$author->username;
        }
        if (request('tag')) {
            $title = 'Tag : ' . ucfirst(request('tag'));
        }
        return view('frontend.pages.index', [
            "title" => $title,
            "photos" => $photos
        ]);
    }
    public function show(Photo $photo)
    {
        $photo = Photo::where('slug', $photo->slug)->with('user')->first() && $photo->status == 1 ? $photo : abort(404);
        $photo->increment('views');
        $title = $photo->judul;
        $allPhoto = Photo::where('category_id', $photo->category_id)->whereNotIn('id', [$photo->id])
        ->get();
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

        $photos = Photo::whereContains('tags', $tag)->with('user');

        return view('frontend.pages.tag', compact('photos', 'title', 'tagName'));
    }
}