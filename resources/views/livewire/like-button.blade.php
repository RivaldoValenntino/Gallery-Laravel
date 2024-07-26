<div>
    <div class="flex">

        <button wire.loading.attr="disabled" wire:click="toggleLike()"
            class="flex items-center justify-center gap-1 text-center">
            <i wire:loading.remove
                class="bi bi-suit-heart-fill text-lg {{ Auth::user()?->hasLiked($photo) ? 'text-rose-500' : 'text-slate-400' }}"></i>
            <p class="text-lg {{ Auth::user()?->hasLiked($photo) ? 'text-rose-500' : 'text-slate-400' }} font-semibold"
                wire:loading.remove>{{ $photo->likes()->count() }}</p>
        </button>
    </div>
</div>
