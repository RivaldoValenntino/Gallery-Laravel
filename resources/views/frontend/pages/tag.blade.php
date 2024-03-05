@extends('frontend.layouts.app')
@section('content')
    <section class="mt-24 pb-5" />
    <div class="px-2 mr-2 md:px-4 md:mr-4 lg:px-4 lg:mr-4 xl:mr-4 xl:px-4">
        <div class="flex flex-col px-4">
            <h1 class="text-md font-normal">Tag</h1>
            <span class="text-2xl font-semibold">{{ ucfirst($tagName) }}</span>
        </div>
        <div
            class="columns-2 gap-2 md:columns-3 lg:columns-3 xl:columns-6 [&>img:not(:first-child)]:mt-5 lg:[&>img:not(:first-child)]:mt-8">
            @foreach ($photos as $photo)
                <a href="/photos/{{ $photo->slug }}" class="w-full">
                    <div class="skeleton-loading">
                        <img class="h-auto max-w-full rounded-xl dark:bg-gray-500 m-2"
                            data-src="{{ asset('storage/' . $photo->gambar . '') }}" alt="">
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    </section>
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
