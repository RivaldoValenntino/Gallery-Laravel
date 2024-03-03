@extends('frontend.layouts.app')
@section('content')
    <section class="grid place-content-center lg:mt-24 mt-5 pb-2">
        <div class="grid gap-4 place-content-center lg:px-8 md:px-4 md:ml-4 px-4 place-items-center">
            <div
                class="grid lg:grid-cols-2 sm:grid-cols-1 md:grid-cols-2 grid-cols-1 gap-4 place-content-center border p-4 rounded-lg lg:w-3/4">
                <img src="{{ asset('storage/' . $photo->gambar . '') }}" alt="" class="rounded-lg shadow-lg">
                <div class="items flex flex-col">
                    <h1 class="text-2xl font-bold opacity-50 text-[#1b1b1b]">{{ $photo->categories->name }}</h1>
                    <h1 class="text-5xl font-bold">{{ $photo->judul }}</h1>
                    <div class="tags mt-4">
                        @foreach ($photo->tags as $tag)
                            <a class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 hover:underline hover:font-bold"
                                href="#">#{{ $tag }}</a>
                        @endforeach
                    </div>
                    <div class="keterangan py-2">
                        <p class="text-lg">{{ $photo->deskripsi }}</p>
                        {{-- <h1 class="text-lg">Published at : {{ $photo->created_at->format('d F Y') }}</h1> --}}
                        <div class="flex items-center justify-between mt-2 ">
                            <div class="author flex">
                                @if ($photo->user->avatar)
                                    <img class="w-10 h-10 rounded-full mr-4" src="{{ asset($photo->user->avatar) }}">
                                @else
                                    <img class="w-10 h-10 rounded-full mr-4"
                                        src="https://cdn.vectorstock.com/i/preview-1x/08/19/gray-photo-placeholder-icon-design-ui-vector-35850819.jpg">
                                @endif
                                <div class="text-sm">
                                    <a href="/posts?author={{ $photo->user->username }}"
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
                                <span class="text-black">
                                <i class="bi bi-eye"></i> {{ $photo->views }}
                            </span>
                            <livewire:like-button :photo="$photo" :key="$photo->id" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h1 class="text-2xl font-bold">You may also like</h1>
            <div class="columns-2 gap-2 md:columns-3 lg:columns-3 xl:columns-4 [&>img:not(:first-child)]:mt-5 lg:[&>img:not(:first-child)]:mt-8">
                @foreach ($allPhoto as $suggestedPhoto)
                    <div>
                        <img class="max-w-full rounded-lg m-2"
                            src="{{ asset('storage/' . $suggestedPhoto->gambar . '') }}" alt="">
                    </div>
                @endforeach
            </div>
    </section>
@endsection
