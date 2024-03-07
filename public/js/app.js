$(function () {
    setTimeout(() => {
        $(".loader").fadeOut(1000);
    }, 3000);
});
$(document).ready(function () {
    // Fungsi untuk tampilan penuh
    function full_view(element) {
        const src = $(element)
            .closest(".relative")
            .find(".img-source")
            .attr("src");
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
        $(window).on("scroll.disableScroll", function () {
            $(window).scrollTop(0);
        });
    }

    // Fungsi untuk mengaktifkan scroll
    function enableScroll() {
        $(window).off("scroll.disableScroll");
    }

    // Memanggil fungsi full_view ketika tombol di klik
    $(".btn-zoom").on("click", function () {
        full_view(this);
    });

    // Memanggil fungsi close_modal ketika tombol close di klik
    $(".close").on("click", function () {
        close_modal();
    });
});

async function downloadImage(imageSrc) {
    const image = await fetch(imageSrc);
    const imageBlog = await image.blob();
    const imageURL = URL.createObjectURL(imageBlog);

    const link = document.createElement("a");
    link.href = imageURL;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

$(document).ready(function () {
    $(".skeleton-loading img").each(function () {
        let img = $(this);
        img.on("load", function () {
            img.parent().removeClass("skeleton-loading");
        });
        img.attr("src", img.attr("data-src"));
    });
});
