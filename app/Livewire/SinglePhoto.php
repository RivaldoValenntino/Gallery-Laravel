<?php

namespace App\Livewire;

use App\Models\Photo;
use Livewire\Attributes\Title;
use Livewire\Component;

class SinglePhoto extends Component
{
    public $photo;
    public $allPhoto;
    public $slug;
    public function mount($slug)
    {
        $this->slug = $slug;
        $this->photo = Photo::where('slug', $slug)->with('user')->first();

        if (!$this->photo || $this->photo->status != 1) {
            abort(404);
        }

        $this->photo->increment('views');

        // Get other photos in the same category
        $this->allPhoto = Photo::where('category_id', $this->photo->category_id)
            ->where('id', '!=', $this->photo->id)
            ->get();
    }
    public function render()
    {
        return view('livewire.single-photo')->title($this->photo->judul);
    }
}
