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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewirestyles
</head>
<style>
    ::-webkit-scrollbar {
        display: none;
    }
</style>

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
    <div class="container flex flex-col justify-between font-noto-sans">
        <div>
            @livewire('partials.header')
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
    @livewireScripts
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/solid.js"
        integrity="sha384-/BxOvRagtVDn9dJ+JGCtcofNXgQO/CCCVKdMfL115s3gOgQxWaX/tSq5V8dRgsbc" crossorigin="anonymous">
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/fontawesome.js"
        integrity="sha384-dPBGbj4Uoy1OOpM4+aRGfAOc0W37JkROT+3uynUgTHZCHZNMHfGXsmmvYTffZjYO" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>

</html>
