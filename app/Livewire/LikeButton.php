<?php

namespace App\Livewire;

use App\Models\Photo;
use Livewire\Component;
use Livewire\Attributes\Reactive;

class LikeButton extends Component
{
    #[Reactive]
    public Photo $photo;
    protected $refresh = ['photo'];

    public function toggleLike()
    {
        if (auth()->guest()) {
            return redirect('/login')->with('status', true);
        }
        $user = auth()->user();
        if ($user->hasLiked($this->photo)) {
            // User has already liked, so unlike
            $user->likes()->detach($this->photo);
        } else {
            // User hasn't liked, so like
            $user->likes()->attach($this->photo);
        }

        // Reload the photo to get the updated like count
        $this->photo->refresh();
    }
    public function render()
    {
        return view('livewire.like-button');
    }
}
