@extends('frontend.layouts.app')
@section('content')
    <section class="grid place-content-center lg:mt-28 mt-20 pb-2">
        <div class="px-4">
            <div class="flex flex-col lg:flex-row lg:space-x-6 max-w-screen-lg mx-auto p-6 bg-white rounded-lg shadow-lg">
                <!-- Column 1: Gambar -->
                {{-- Img FullScreen --}}
                <div id="img-viewer">
                    <span class="close" onclick="close_modal()">&times;</span>
                    <img class="modal-content" id="full-image">
                </div>
                {{-- End Img FullScreen --}}
                <div class="lg:w-1/2 relative group font-nunito">
                    <img src="{{ asset('storage/' . $photo->gambar . '') }}" alt="{{ $photo->judul }}"
                        class="w-full h-full object-cover rounded-lg img-source group-hover:brightness-[0.3] transition duration-300">
                    <div class="btn absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col gap-4">
                        <button
                            class="hidden bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded group-hover:flex btn-zoom">
                            <div class="flex justify-center text-center items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 50 50">
                                    <path
                                        d="M 21 3 C 11.601563 3 4 10.601563 4 20 C 4 29.398438 11.601563 37 21 37 C 24.355469 37 27.460938 36.015625 30.09375 34.34375 L 42.375 46.625 L 46.625 42.375 L 34.5 30.28125 C 36.679688 27.421875 38 23.878906 38 20 C 38 10.601563 30.398438 3 21 3 Z M 21 7 C 28.199219 7 34 12.800781 34 20 C 34 27.199219 28.199219 33 21 33 C 13.800781 33 8 27.199219 8 20 C 8 12.800781 13.800781 7 21 7 Z">
                                    </path>
                                </svg>
                                <span class="text-center">Zoom</span>
                            </div>
                        </button>
                        <button
                            class="hidden bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded group-hover:flex">
                            <a href="{{ asset('storage/' . $photo->gambar . '') }}" download="{{ $photo->judul }}"
                                class="flex justify-center text-center items-center">
                                <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                                </svg>
                                <span>Download</span>
                            </a>
                        </button>
                    </div>
                </div>

                <!-- Column 2: Informasi -->
                <div class="lg:w-1/2 mt-6 lg:mt-0">
                    <h2 class="text-2xl font-bold mb-2">{{ $photo->judul }}</h2>
                    <p class="text-gray-700 mb-4">{{ $photo->deskripsi }}</p>
                    <div class="tags mt-4">
                        @foreach ($photo->tags as $tag)
                            <a class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 hover:underline hover:font-bold"
                                href="/photos?tag={{ $tag }}">#{{ $tag }}</a>
                        @endforeach
                    </div>
                    <div class="flex items-center justify-between pb-12 pt-6">
                        <div class="author flex">
                            @if ($photo->user->avatar !== '/storage/')
                                <img class="w-10 h-10 rounded-full mr-4" src="{{ asset($photo->user->avatar) }}">
                            @else
                                <img class="w-10 h-10 rounded-full mr-4" src="{{ asset('img/default-avatar.png') }}">
                            @endif

                            <div class="text-sm">
                                <a href="/photos?author={{ $photo->user->username }}"
                                    class="text-gray-900 font-semibold leading-none hover:text-indigo-600">{{ $photo->user->name }}</a>
                                <p class="text-gray-600">
                                    @if ($photo->created_at->diffInDays() > 0)
                                        {{ $photo->created_at->format('F j, Y | g:i A') }}
                                    @else
                                        {{ $photo->created_at->diffForHumans() }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-2 px-6 justify-center items-center">
                            {{-- <span class="text-black">
                                <i class="bi bi-eye"></i> {{ $photo->views }}
                            </span> --}}
                            <livewire:like-button :photo="$photo" :key="$photo->id" />
                        </div>
                    </div>

                    <!-- Comment Section -->
                    <livewire:comment :photo="$photo" :key="$photo->id" :id="$photo->id" />
                    <!-- End Form Komentar -->

                    <!-- Tombol Lainnya -->

                </div>
            </div>
            <h1 class="lg:text-2xl text-xl font-bold text-center mt-4 mb-2">You may also like</h1>
            <div class="px-2 mr-2 md:px-4 md:mr-4 lg:px-4 lg:mr-4 xl:mr-4 xl:px-4 pb-12">
                <div
                    class="columns-2 gap-2 md:columns-3 lg:columns-3 xl:columns-6 [&>img:not(:first-child)]:mt-5 lg:[&>img:not(:first-child)]:mt-8">
                    @foreach ($allPhoto as $suggestedPhoto)
                        <a href="/photos/{{ $suggestedPhoto->slug }}">
                            <div>
                                <img class="max-w-full rounded-lg m-2 hover:scale-90 transition duration-300 hover:brightness-75"
                                    src="{{ asset('storage/' . $suggestedPhoto->gambar . '') }}" alt="">
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
