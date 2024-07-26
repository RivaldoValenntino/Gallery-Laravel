<?php

namespace App\Livewire;

use App\Models\Photo;
use Livewire\Attributes\Title;
use Livewire\Component;

class PhotoList extends Component
{
    #[Title('Photos')]
    public $search = '';
    public $category = '';
    public $author = '';
    public $tag = '';
    public $count = 10;
    public $sort_by = 'latest';


    protected $queryString = ['search', 'category', 'author', 'tag', 'sort_by'];
    public function render()
    {
        $query = Photo::search([
            'search' => $this->search,
            'category' => $this->category,
            'author' => $this->author,
            'tag' => $this->tag,
        ]);

        // Apply sorting based on sort_by property
        switch ($this->sort_by) {
            case 'likes':
                $query->mostLiked();
                break;
            case 'comments':
                $query->mostCommented();
                break;
            case 'views':
                $query->orderByDesc('views');
                break;
            case 'latest':
            default:
                $query->latestPhotos();
                break;
        }

        $photos = $query->take($this->count)->get();
        $title = $this->generateTitle();
        $maxData = Photo::count();

        return view('livewire.photo-list', [
            'photos' => $photos,
            'title' => $title,
            'maxData' => $maxData,
        ]);
    }


    public function performSearch()
    {
        $this->render();
    }

    public function generateTitle()
    {
        $title = 'All Photos';

        if ($this->search) {
            $title .= ' matching "' . $this->search . '"';
        }

        if ($this->category) {
            $title .= ' in category "' . $this->category . '"';
        }

        if ($this->author) {
            $title .= ' by author "' . $this->author . '"';
        }

        if ($this->tag) {
            $title .= ' with tag "' . $this->tag . '"';
        }

        return $title;
    }
    public function loadMore()
    {
        $this->count += 10;
    }
}
