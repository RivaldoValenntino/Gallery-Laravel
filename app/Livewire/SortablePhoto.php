<?php

namespace App\Livewire;

use App\Models\Photo;
use Livewire\Component;

class SortablePhoto extends Component
{
    public $sortBy = 'likes';
    public $searchTerm;

    public function mount(array $searchTerm)
    {
        $this->searchTerm = $searchTerm;
    }

    public function render()
    {
        $photos = Photo::with(['categories', 'user'])
            ->search($this->searchTerm)
            ->orderBy($this->sortBy, 'desc')
            ->latest()
            ->where('status', 1)
            ->get();

        return view('livewire.sortable-photos', [
            'photos' => $photos,
        ]);
    }

    public function updatedSortBy($value)
    {
        $this->sortBy = $value;
    }

    public function searchTerm()
    {
        $searchTerm = [
            'search' => request('search'),
            'category' => request('category'),
            'author' => request('author'),
            'tag' => request('tag'),
        ];

        return $searchTerm;
    }
}
