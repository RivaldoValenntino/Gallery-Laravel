@extends('frontend.layouts.app')
@section('content')
     <section class="mt-16 py-8 flex justify-center items-center">
        <div class="container overflow-hidden grid grid-cols-1 lg:grid-cols-4 gap-5 px-10">
            @foreach ($albums as $items)
            <a href="/photos?items={{ $items->slug }}">
                    <article class="relative overflow-hidden rounded-lg shadow-xl transition hover:shadow-lg">
                       <picture class="rounded-lg block overflow-hidden">
                         <img alt="Office" src="{{ asset('storage/' . $items->cover . '') }}"
                            class="absolute inset-0 h-full w-full object-cover brightness-75 hover:brightness-100 transition-all duration-500 ease-in-out shadow-lg" />
                       </picture>
                        <div class="relative bg-gradient-to-t from-gray-900/50 to-gray-900/25 pt-36 sm:pt-48 lg:pt-64">
                            <div class="p-4 sm:p-6">
                                <div class="author flex gap-4">
                                  <img src="{{ asset($items->user->avatar) }}" alt="" class="w-14 h-14 rounded-full">
                                  <div class="flex flex-col">
                                    <span class="text-white text-xl font-semibold">{{ $items->user->name }}</span>
                                  <h3 class="mt-0.5 text-white font-semibold text-md">
                                      {{ $items->nama_album }}
                                  </h3>
                                  </div>
                                </div>

                            </div>
                        </div>
                    </article>
                </a>
                @endforeach
            </div>
        </section>
@endsection
