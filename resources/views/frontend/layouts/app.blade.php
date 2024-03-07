<!DOCTYPE html>
<html lang="en" class="">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>{{ $title }} | GalleryRPL </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Great+Vibes&family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="https://unpkg.com/infinite-scroll@4/dist/infinite-scroll.pkgd.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <div class="loader z-[999]">
        <div class="bg-white fixed inset-0 flex items-center justify-center h-screen z-[999] w-full">
            <div class="flex gap-2">
                <div class='flex space-x-2 justify-center items-center bg-transparent dark:invert z-[999]'>
                    <span class='sr-only'>Loading...</span>
                    <div class='h-8 w-8 bg-sky-500 rounded-full animate-bounce [animation-delay:-0.3s] z-[999]'></div>
                    <div class='h-8 w-8 bg-sky-500 rounded-full animate-bounce [animation-delay:-0.15s] z-[999]'></div>
                    <div class='h-8 w-8 bg-sky-500 rounded-full animate-bounce z-[999]'></div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex h-screen flex-col justify-between container font-noto-sans">
        <div>
            @include('frontend.partials.navbar')
            <main>
                @yield('content')
            </main>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
