<div>
    <section class="pb-6 mt-20" />
    <div class="flex items-center justify-center w-full">
        {{-- Form Search --}}
        <form class="px-4 mx-auto mt-4 lg:w-1/2 w-dvw md:w-3/4 xl:w-1/2" wire:submit="performSearch">
            <label for="default-search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" id="default-search"
                    class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg ps-10 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search Photos ....." name="search" wire:model="search" />
                <button type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
        </form>

        {{-- End Form --}}
    </div>
    <div class="flex justify-between">
        <h1 class="px-10 mt-12 text-xl font-semibold font-nunito">{{ $title }}</h1>
        @include('components.dropdown-filter')
    </div>
    <div class="aspect-[4/3]">
        <div class="px-2 mr-2 md:px-4 md:mr-4 lg:px-4 lg:mr-4 xl:mr-4 xl:px-4 wrapper-photos">
            <div class="columns-2 gap-2 pt-2 md:columns-3 lg:columns-3 xl:columns-5 [&>img:not(:first-child)]:mt-5 lg:[&>img:not(:first-child)]:mt-8"
                id="photo-container">
                @if ($photos->count() > 0)
                    @foreach ($photos as $photo)
                        <a href="/photos/{{ $photo->slug }}" class="w-full">
                            <div class="reveal">
                                <img class="h-auto max-w-full m-2 transition duration-300 rounded-xl dark:bg-gray-500 hover:scale-90 hover:brightness-75"
                                    src="{{ asset('storage/' . $photo->gambar . '') }}" alt="">
                            </div>

                        </a>
                    @endforeach
                @else
                    <div
                        class="absolute top-0 bottom-0 left-0 right-0 flex items-center justify-center w-56 m-auto text-center h-44 ">
                        <h1 class="text-2xl text-center">No Photos are available</h1>
                    </div>
                @endif
            </div>
            <div>
                @if ($count <= $maxData && $photos->count() >= 10)
                    <div
                        class="flex mt-4 items-center before:h-px before:flex-1 before:bg-gray-300 before:content-[''] after:h-px after:flex-1 after:bg-gray-300 after:content-['']">
                        <button wire:click="loadMore" wire:loading.attr="disabled"
                            class="flex items-center px-3 py-2 text-sm font-medium text-center text-gray-900 border border-gray-300 rounded-full bg-secondary-50 hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                class="w-4 h-4 mr-1">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span wire:loading.remove>Load More</span>
                            <span wire:loading>Loading...</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </section>


</div>
