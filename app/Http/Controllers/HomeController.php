<?php

namespace App\Http\Controllers;

use App\Livewire\LoadMore;
use App\Models\Album;
use App\Models\Category;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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
        $query = Photo::with(['categories', 'user'])
            ->search($searchTerm)
            ->where('status', 1);

        $title = $this->generateTitle();

        $this->applySortCriteria($query);

        $photos = $query->paginate(10);
        if ($request->ajax()) {
            $view = view('frontend.load.photos', compact('photos'))->render();
            return response()->json(['html' => $view]);
        }
        return view('frontend.pages.index', [
            "title" => $title,
            "photos" => $photos,
        ]);
    }

    private function generateTitle()
    {
        $title = 'All Photos';

        if (request('search')) {
            $title = 'Search results for : ' . request('search');
        } elseif (request('category')) {
            $category = Category::firstWhere('slug', request('category'));
            $title = 'Category : ' . optional($category)->name;
        } elseif (request('author')) {
            $author = User::firstWhere('username', request('author'));
            $title = 'Posted by @' . optional($author)->username;
        } elseif (request('tag')) {
            $title = 'Tag : ' . ucfirst(request('tag'));
        }

        return $title;
    }

    private function applySortCriteria($query)
    {
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
