@extends('frontend.layouts.app')
@section('content')
    <div class="px-2 mr-2 md:px-6 md:mr-4 lg:px-4 lg:mr-4">
        <div
        class="columns-2 gap-2 lg:mt-[4.5rem] md:columns-3 lg:columns-3 xl:columns-4 [&>img:not(:first-child)]:mt-5 lg:[&>img:not(:first-child)]:mt-8">
        @if ($posts->count() > 0)
            @foreach ($posts as $post)
                <a href="/photos/{{ $post->slug }}" class="w-full">
                    <div class="skeleton-loading">
                        <img class="h-auto max-w-full rounded-xl dark:bg-gray-500 m-2"
                            data-src="{{ asset('storage/' . $post->gambar . '') }}" alt="">
                    </div>
                </a>
            @endforeach
        @else
            <div class="min-h-screen flex flex-grow items-center justify-center bg-gray-50">
                <div class="rounded-lg bg-white p-8 text-center shadow-xl">
                    <h1 class="mb-4 text-4xl font-bold">404</h1>
                    <p class="text-gray-600">Oops! The page you are looking for could not be found.</p>
                    <a href="/"
                        class="mt-4 inline-block rounded bg-blue-500 px-4 py-2 font-semibold text-white hover:bg-blue-600">Go
                        back to Home</a>
                </div>
            </div>
        @endif
    </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".skeleton-loading img").each(function() {
                let img = $(this);
                img.on("load", function() {
                    img.parent().removeClass("skeleton-loading");
                });
                img.attr("src", img.attr("data-src"));
            });
        });
    </script>
@endsection
