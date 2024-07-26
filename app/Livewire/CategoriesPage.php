<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Photo;
use Livewire\Attributes\Title;
use Livewire\Component;

class CategoriesPage extends Component
{
    #[Title('Categories')]
    public $categories;
    public $photos;
    public function mount()
    {
        $this->photos = Photo::where('status', 1)->get();
        $this->categories = Category::with('photos')->get();
    }
    public function render()
    {
        return view('livewire.categories-page');
    }
}
