@extends('frontend.layouts.app')
@section('content')
    <section class="mt-20 pb-20 h-screen"/>
        <div class="flex justify-center items-center w-full">
         @include('components.form')
        </div>
        <h1 class="text-2xl font-semibold px-6 mt-4 font-nunito">{{ $title }}</h1>
        <div class="px-2 mr-2 md:px-4 md:mr-4 lg:px-4 lg:mr-4 xl:mr-4 xl:px-4 wrapper-photos">
            <div
                class="columns-2 gap-2 pt-2 md:columns-3 lg:columns-3 xl:columns-6 [&>img:not(:first-child)]:mt-5 lg:[&>img:not(:first-child)]:mt-8">
                @if ($posts->count() > 0)
                    @foreach ($posts as $post)
                        <a href="/photos/{{ $post->slug }}" class="w-full">
                            <div class="skeleton-loading">
                                <img class="h-auto max-w-full rounded-xl dark:bg-gray-500 m-2 hover:scale-90 transition duration-300 hover:brightness-75"
                                    data-src="{{ asset('storage/' . $post->gambar . '') }}" alt="">
                            </div>
                        </a>
                    @endforeach
                @else
                    <div class="flex justify-center items-center w-full text-center absolute m-auto left-0 right-0 top-0 bottom-0">
                        <h1 class="text-center text-2xl">No Photos are available</h1>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
