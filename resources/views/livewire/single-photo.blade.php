<div>
    <section class="grid pb-2 mt-20 place-content-center lg:mt-28">
        <div class="px-4">
            <div
                class="flex flex-col max-w-screen-lg p-6 mx-auto bg-white rounded-lg shadow-lg lg:flex-row lg:space-x-6">
                <div id="img-viewer">
                    <span class="close" onclick="close_modal()">&times;</span>
                    <img class="modal-content" id="full-image">
                </div>
                <div class="relative lg:w-1/2 group font-nunito">
                    <img src="{{ asset('storage/' . $photo->gambar . '') }}" alt="{{ $photo->judul }}"
                        class="w-full h-full object-cover rounded-lg img-source group-hover:brightness-[0.3] transition duration-300">
                    <div class="absolute flex flex-col gap-4 -translate-x-1/2 -translate-y-1/2 btn top-1/2 left-1/2">
                        <button
                            class="hidden px-4 py-2 font-bold text-gray-800 bg-gray-300 rounded hover:bg-gray-400 group-hover:flex btn-zoom">
                            <div class="flex items-center justify-center text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 50 50">
                                    <path
                                        d="M 21 3 C 11.601563 3 4 10.601563 4 20 C 4 29.398438 11.601563 37 21 37 C 24.355469 37 27.460938 36.015625 30.09375 34.34375 L 42.375 46.625 L 46.625 42.375 L 34.5 30.28125 C 36.679688 27.421875 38 23.878906 38 20 C 38 10.601563 30.398438 3 21 3 Z M 21 7 C 28.199219 7 34 12.800781 34 20 C 34 27.199219 28.199219 33 21 33 C 13.800781 33 8 27.199219 8 20 C 8 12.800781 13.800781 7 21 7 Z">
                                    </path>
                                </svg>
                                <span class="text-center">Zoom</span>
                            </div>
                        </button>
                        <button
                            class="hidden px-4 py-2 font-bold text-gray-800 bg-gray-300 rounded hover:bg-gray-400 group-hover:flex">
                            <a href="{{ asset('storage/' . $photo->gambar . '') }}" download="{{ $photo->judul }}"
                                class="flex items-center justify-center text-center">
                                <svg class="w-4 h-4 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                                </svg>
                                <span>Download</span>
                            </a>
                        </button>
                    </div>
                </div>

                {{-- Informasi Foto --}}
                <div class="mt-6 lg:w-1/2 lg:mt-0">
                    <h2 class="mb-2 text-2xl font-bold">{{ $photo->judul }}</h2>
                    <p class="mb-4 text-gray-700">{{ $photo->deskripsi }}</p>
                    <div class="mt-4 tags">
                        @foreach ($photo->tags as $tag)
                            <a class="inline-block px-3 py-1 mb-2 mr-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-full hover:underline hover:font-bold"
                                href="/photos?tag={{ $tag }}">#{{ $tag }}</a>
                        @endforeach
                    </div>
                    <div class="flex items-center justify-between pt-6 pb-12">
                        <div class="flex author">
                            @if ($photo->user->avatar !== '/storage/')
                                <img class="w-10 h-10 mr-4 rounded-full" src="{{ asset($photo->user->avatar) }}">
                            @else
                                <img class="w-10 h-10 mr-4 rounded-full" src="{{ asset('img/default-avatar.png') }}">
                            @endif

                            <div class="text-sm">
                                <a href="/photos?author={{ $photo->user->username }}"
                                    class="font-semibold leading-none text-gray-900 hover:text-indigo-600">{{ $photo->user->name }}</a>
                                <a href="/photos?author={{ $photo->user->username }}" class="block text-gray-600">
                                    {{ '@' . $photo->user->username }}
                                </a>
                                <p class="text-gray-600">
                                    @if ($photo->created_at->diffInDays() > 0)
                                        {{ $photo->created_at->format('F j, Y | g:i A') }}
                                    @else
                                        {{ $photo->created_at->diffForHumans() }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center justify-center gap-2 px-6">
                            <span class="flex gap-1 text-black">
                                <i class="bi bi-eye"></i> {{ $photo->views }}
                            </span>
                            <livewire:like-button :photo="$photo" :key="$photo->id" />
                        </div>
                    </div>

                    {{-- Komentar --}}
                    <livewire:comment :photo="$photo" :key="$photo->id" :id="$photo->id" />

                </div>
            </div>
            <h1 class="mt-4 mb-2 text-xl font-bold text-center lg:text-2xl">
                {{ $allPhoto->count() > 0 ? 'Photos You May Like' : 'No suggested photos are available' }}</h1>
            <div class="w-full px-2 pb-12 mr-2 md:px-4 md:mr-4 lg:px-4 lg:mr-4 xl:mr-4 xl:px-4">
                <div
                    class="columns-2 gap-2 md:columns-3 lg:columns-3 xl:columns-6 [&>img:not(:first-child)]:mt-5 lg:[&>img:not(:first-child)]:mt-8">
                    @foreach ($allPhoto as $suggestedPhoto)
                        <a href="/photos/{{ $suggestedPhoto->slug }}">
                            <div>
                                <img class="max-w-full m-2 transition duration-300 rounded-lg hover:scale-90 hover:brightness-75"
                                    src="{{ asset('storage/' . $suggestedPhoto->gambar . '') }}" alt="">
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>
