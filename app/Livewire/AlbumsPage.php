<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Album;
use App\Models\Photo;

class AlbumsPage extends Component
{
    #[Title('Albums')]
    public $albums;
    public $maxData;
    public $photos;
    public function mount()
    {
        $this->photos = Photo::where('status', 1)->get();
        $this->albums = Album::where('status', 1)->get();
        $this->maxData = $this->albums->count();
    }
    public function render()
    {
        return view('livewire.albums-page');
    }
}
