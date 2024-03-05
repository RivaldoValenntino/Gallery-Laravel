<div>
    <div class="overflow-y-auto max-h-52 mb-2">
        <!-- Single Comment -->
        <h1 class="text-md mb-4">Comments ( {{ $comments->count() }} )</h1>
        @foreach ($comments as $item)
            <div class="flex items-start mb-2">
                <img src="{{ asset($item->user->avatar) }}" alt="{{ $item->user->name }}" class="w-8 h-8 rounded-full">
                <div class="ml-2 bg-gray-100 rounded-lg px-4 py-2 w-full flex flex-col gap-2">
                    <span class="text-sm text-gray-700">{{ $item->user->name }}</span>
                    <p class="text-md text-gray-700">{{ $item->isi_komentar }}</p>
                    @auth
                        @if (Auth::user()->id == $item->user_id)
                            <div class="flex gap-2 text-sm mt-2">
                                <button class="text-blue-500 text-md" wire:click="selectEdit({{ $item->id }})">Edit</button>
                                <span class="text-gray-500">|</span>
                                <button class="text-red-500 text-md" wire:click="delete({{ $item->id }})">Hapus</button>
                            </div>
                        @else
                        @endif
                        @if (isset($edit_comment_id) && $edit_comment_id == $item->id)
                            <form wire:submit.prevent="update">
                                <textarea wire:model.defer="isi_komentar_edit" class="w-full h-24 border border-gray-300 rounded-lg p-2 mb-2"
                                    placeholder="Tambahkan komentar..."></textarea>
                                <button type="submit"
                                    class="bg-blue-500 text-white rounded-lg px-4 py-2 hover:bg-blue-600">Simpan
                                    Perubahan</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        @endforeach
        <!-- End Single Comment -->

        <!-- ... -->
    </div>
    <!-- End Comment Section -->

    <!-- Form Komentar -->
    @auth
        <form wire:submit.prevent="store">
            <textarea wire:model.defer="isi_komentar" class="w-full h-24 border border-gray-300 rounded-lg p-2 mb-2"
                placeholder="Add Comments....."></textarea>
            <button type="submit" class="bg-blue-500 text-white rounded-lg px-4 py-2 hover:bg-blue-600">Add
                Comments</button>
        </form>
    @endauth
</div>
