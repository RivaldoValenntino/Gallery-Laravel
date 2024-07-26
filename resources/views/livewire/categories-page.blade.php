<div class="flex flex-col items-center justify-center px-12 pb-8 mt-16">
    <div class="flex flex-col items-center justify-center pb-4">
        <p class="text-xl font-semibold">{{ date('M d, Y') }}</p>
        <h1 class="text-3xl font-bold">Browse All Categories</h1>
    </div>
    <div class="grid grid-cols-4 gap-4">
        @foreach ($photos as $photo)
            <a href="/photos?category={{ $photo->categories->name }}">
                <div class="relative max-w-xl mx-auto overflow-hidden rounded-xl group">
                    <img class="object-cover h-64 transition duration-300 rounded-xl brightness-50 w-96 group-hover:scale-125"
                        src="{{ asset('storage/' . $photo->gambar . '') }}" alt="Random image">
                    <div class="absolute inset-0 bg-gray-700 rounded-md opacity-60"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <h2 class="text-3xl font-bold text-white">{{ $photo->categories->name }}</h2>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
