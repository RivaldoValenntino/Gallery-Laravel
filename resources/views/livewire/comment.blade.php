<div>
    <div class="overflow-y-auto max-h-52 mb-2">
        <!-- Single Comment -->
        <h1 class="text-md mb-4">Comments ( {{ $comments->count() }} )</h1>
        @foreach ($comments as $item)
            <div class="flex items-start mb-2" id="comment-{{ $item->id }}">
                <img src="{{ asset($item->user->avatar) }}" alt="{{ $item->user->name }}" class="w-8 h-8 rounded-full">
                <div class="ml-2 bg-gray-100 rounded-lg px-4 py-2 w-full flex flex-col">
                    <span class="text-sm text-gray-700">{{ $item->user->name }}</span>
                    <span class="text-sm text-gray-700 opacity-70">{{ '@' . $item->user->username }}</span>
                    <p class="text-sm text-gray-700 mt-2 mb-2">{{ $item->isi_komentar }}</p>
                    @auth
                        <div class="inline-flex gap-2 text-sm mt-2">
                            <button class="text-blue-500 text-md"
                                wire:click="selectReply({{ $item->id }})">Reply</button>
                        </div>
                    @endauth
                    @auth
                        @if (Auth::user()->id == $item->user_id)
                            <div class="flex gap-2 text-sm mt-2">
                                <button class="text-blue-500 text-md"
                                    wire:click="selectEdit({{ $item->id }})">Edit</button>
                                <span class="text-gray-500">|</span>
                                <button class="text-red-500 text-md" wire:click="delete({{ $item->id }})">Hapus</button>
                            </div>
                        @endif
                        @if (isset($comment_id) && $comment_id == $item->id)
                            <form wire:submit.prevent="reply" class="mt-2">
                                <textarea wire:model.defer="isi_komentar_reply" class="w-full h-24 border border-gray-300 rounded-lg p-2 mb-2"
                                    placeholder="Add Reply..."></textarea>
                                <button type="submit"
                                    class="bg-blue-500 text-white rounded-lg px-4 py-2 hover:bg-blue-600">Reply</button>
                            </form>
                        @endif
                        @if (isset($edit_comment_id) && $edit_comment_id == $item->id)
                            <form wire:submit.prevent="update" class="mt-2">
                                <textarea wire:model.defer="isi_komentar_edit" class="w-full h-24 border border-gray-300 rounded-lg p-2 mb-2"
                                    placeholder="Edit Comments...."></textarea>
                                <button type="submit"
                                    class="bg-blue-500 text-white rounded-lg px-4 py-2 hover:bg-blue-600">Save
                                    Changes</button>
                            </form>
                        @endif
                    @endauth
                    @if ($item->childrens)
                        @foreach ($item->childrens as $replies)
                            <div class="flex items-start mb-2 mt-4">
                                <img src="{{ asset($replies->user->avatar) }}" alt="{{ $replies->user->name }}"
                                    class="w-8 h-8 rounded-full mt-2">
                                <div class="ml-2 bg-gray-200 px-4 rounded-lg py-2 w-full flex flex-col">
                                    <span class="text-sm text-gray-700">{{ $replies->user->name }}</span>
                                    <span
                                        class="text-sm text-gray-700 opacity-70">{{ '@' . $replies->user->username }}</span>
                                    <p class="text-sm text-gray-700 mt-2">{{ $replies->isi_komentar }}</p>
                                    @auth
                                        @if (Auth::user()->id == $replies->user_id)
                                            <div class="flex gap-2 text-sm mt-2">
                                                {{-- <button class="text-blue-500 text-md"
                                                    wire:click="selectReply({{ $replies->id }})">Reply</button> --}}
                                                <button class="text-blue-500 text-sm"
                                                    wire:click="selectEdit({{ $replies->id }})">Edit</button>
                                                <span class="text-gray-500">|</span>
                                                <button class="text-red-500 text-sm"
                                                    wire:click="delete({{ $replies->id }})">Hapus</button>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                            @if (isset($edit_comment_id) && $edit_comment_id == $replies->id)
                                <form wire:submit.prevent="update">
                                    <textarea wire:model.defer="isi_komentar_edit" class="w-full h-24 border border-gray-300 rounded-lg p-2 mb-2"
                                        placeholder="Edit Comments...."></textarea>
                                    @error('isi_komentar_edit')
                                        <small
                                            class="text-red-500 font-bold mb-2">{{ $errors->first('isi_komentar') }}</small>
                                    @enderror
                                    <button type="submit"
                                        class="bg-blue-500 text-white rounded-lg px-4 py-2 hover:bg-blue-600">Save
                                        Changes</button>
                                </form>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
        <!-- End Single Comment -->

        <!-- ... -->
    </div>
    <!-- End Comment Section -->

    <!-- Form Komentar -->
    @auth
        <form wire:submit.prevent="store" class="flex flex-col">
            <textarea wire:model.defer="isi_komentar" class="w-full h-24 border border-gray-300 rounded-lg p-2 mb-2"
                placeholder="Add Comments....."></textarea>
            @error('isi_komentar')
                <small class="text-red-500 font-bold mb-2">{{ $errors->first('isi_komentar') }}</small>
            @enderror
            <button type="submit" class="bg-blue-500 text-white rounded-lg px-4 py-2 hover:bg-blue-600">Add
                Comments</button>
        </form>
    @endauth

    @guest
        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
            <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                    </svg></div>
                <div>
                    <p class="font-bold">Please Sign in or Sign up first to add comments</p>
                </div>
            </div>
        </div>
    @endguest

</div>
