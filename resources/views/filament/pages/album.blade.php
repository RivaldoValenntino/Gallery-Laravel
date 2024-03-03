<x-filament-panels::page>
<div class="flex flex-wrap gap-4">
@foreach ($albums as $album)
    <div class="p-2 max-w-sm rounded-lg shadow dark:bg-transparent">
    <a href="">
        <img class="rounded-t-lg" src="{{ asset('storage/'. $album->cover) }}" alt="" />
    </a>
    <div class="p-5">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white mt-2">{{ $album->nama_album }}</h5>
        </a>
        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $album->deskripsi }}</p>
    </div> 
</div>
@endforeach
</div>

</x-filament-panels::page>
