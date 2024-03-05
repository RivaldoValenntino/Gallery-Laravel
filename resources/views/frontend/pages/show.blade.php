@extends('frontend.layouts.app')
@section('content')
    <section class="grid place-content-center lg:mt-24 mt-5 pb-2">
        <div class="px-4">
            <div class="flex flex-col lg:flex-row lg:space-x-6 max-w-screen-lg mx-auto p-6 bg-white rounded-lg shadow-lg">
                <!-- Column 1: Gambar -->
                {{-- Img FullScreen --}}
                <div id="img-viewer">
                    <span class="close" onclick="close_modal()">&times;</span>
                    <img class="modal-content" id="full-image">
                </div>
                {{-- End Img FullScreen --}}
                <div class="lg:w-1/2 relative group">
                    <img src="{{ asset('storage/' . $photo->gambar . '') }}" alt="{{ $photo->judul }}"
                        class="w-full h-full object-cover rounded-lg img-source group-hover:brightness-[0.3] transition duration-300">
                    <div class="btn absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col gap-4">
                        <button
                            class="hidden bg-transparent bg-white px-3 py-2 rounded-lg group-hover:block btn-zoom shadow-md cursor-pointer">
                            <i class="bi bi-zoom-in text-lg"></i>
                            <span class="text-sm">Zoom</span>
                        </button>
                        <button
                            class="hidden bg-transparent bg-white px-3 py-2 rounded-lg group-hover:block shadow-md cursor-pointer">
                            <a href="{{ asset('storage/' . $photo->gambar . '') }}" download="{{ $photo->judul }}">
                                <i class="bi bi-download text-xl"></i>
                                <span class="text-sm">Download</span>
                            </a>
                        </button>
                    </div>
                </div>

                <!-- Column 2: Informasi -->
                <div class="lg:w-1/2 mt-6 lg:mt-0">
                    <h2 class="text-2xl font-bold mb-2">{{ $photo->judul }}</h2>
                    <p class="text-gray-700 mb-4">{{ $photo->deskripsi }}</p>
                    <div class="tags mt-4">
                        @foreach ($photo->tags as $tag)
                            <a class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2 hover:underline hover:font-bold"
                                href="{{ route('photos.tag', $tag) }}">#{{ $tag }}</a>
                        @endforeach
                    </div>
                    <div class="flex items-center justify-between pb-12 pt-6">
                        <div class="author flex">
                            @if ($photo->user->avatar !== '/storage/')
                                <img class="w-10 h-10 rounded-full mr-4" src="{{ asset($photo->user->avatar) }}">
                            @else
                                <img class="w-10 h-10 rounded-full mr-4" src="{{ asset('img/default-avatar.png') }}">
                            @endif

                            <div class="text-sm">
                                <a href="/photos?author={{ $photo->user->username }}"
                                    class="text-gray-900 font-semibold leading-none hover:text-indigo-600">{{ $photo->user->name }}</a>
                                <p class="text-gray-600">
                                    @if ($photo->created_at->diffInDays() > 0)
                                        {{ $photo->created_at->format('F j, Y | g:i A') }}
                                    @else
                                        {{ $photo->created_at->diffForHumans() }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-2 px-6 justify-center items-center">
                            {{-- <span class="text-black">
                                <i class="bi bi-eye"></i> {{ $photo->views }}
                            </span> --}}
                            <livewire:like-button :photo="$photo" :key="$photo->id" />
                        </div>
                    </div>

                    <!-- Comment Section -->
                   <livewire:comment :photo="$photo" :key="$photo->id" :id="$photo->id"/>
                    <!-- End Form Komentar -->

                    <!-- Tombol Lainnya -->
                   
                </div>
            </div>
            <h1 class="text-2xl font-bold text-center mt-4 mb-6">You may also like</h1>
            <div class="px-2 mr-2 md:px-4 md:mr-4 lg:px-4 lg:mr-4 xl:mr-4 xl:px-4">
                <div
                    class="columns-2 gap-2 md:columns-3 lg:columns-3 xl:columns-6 [&>img:not(:first-child)]:mt-5 lg:[&>img:not(:first-child)]:mt-8">
                    @foreach ($allPhoto as $suggestedPhoto)
                        <div>
                            <img class="max-w-full rounded-lg m-2"
                                src="{{ asset('storage/' . $suggestedPhoto->gambar . '') }}" alt="">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <script>
        // Memanggil fungsi saat dokumen telah dimuat sepenuhnya
        $(document).ready(function() {
            // Fungsi untuk tampilan penuh
            function full_view(element) {
                const src = $(element).closest('.relative').find(".img-source").attr("src");
                $("#full-image").attr("src", src);
                $("#img-viewer").show();
                $("body").addClass("full-screen");
                disableScroll();
            }

            // Fungsi untuk menutup modal
            function close_modal() {
                $("#img-viewer").hide();
                $("body").removeClass("full-screen");
                enableScroll();
            }

            // Fungsi untuk menonaktifkan scroll
            function disableScroll() {
                $(window).on("scroll.disableScroll", function() {
                    $(window).scrollTop(0);
                });
            }

            // Fungsi untuk mengaktifkan scroll
            function enableScroll() {
                $(window).off("scroll.disableScroll");
            }

            // Memanggil fungsi full_view ketika tombol di klik
            $(".btn-zoom").on("click", function() {
                full_view(this);
            });

            // Memanggil fungsi close_modal ketika tombol close di klik
            $(".close").on("click", function() {
                close_modal();
            });
        });


        async function downloadImage(imageSrc) {
            const image = await fetch(imageSrc)
            const imageBlog = await image.blob()
            const imageURL = URL.createObjectURL(imageBlog)

            const link = document.createElement('a')
            link.href = imageURL
            document.body.appendChild(link)
            link.click()
            document.body.removeChild(link)
        }
        
    </script>

@endsection
