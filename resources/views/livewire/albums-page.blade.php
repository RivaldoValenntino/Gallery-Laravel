<div class="flex flex-col items-center justify-center px-12 py-8 mt-12">
    <div class="flex flex-col items-center justify-center py-8">
        <p class="text-xl font-semibold">{{ date('M d, Y') }}</p>
        <h1 class="text-3xl font-bold">Stay Inspired</h1>
    </div>
    <div class="grid grid-cols-3 gap-4">
        @foreach (range(1, 6) as $data)
            <div class="relative max-w-xl mx-auto">
                <img class="object-cover w-full h-64 rounded-lg"
                    src="https://images.unsplash.com/photo-1680725779155-456faadefa26" alt="Random image">
                <div class="absolute inset-0 bg-gray-700 rounded-md opacity-60"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <h2 class="text-3xl font-bold text-white">Get Lost in Mountains</h2>
                </div>
            </div>
        @endforeach
    </div>
</div>
