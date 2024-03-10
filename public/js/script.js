$(function () {
    setTimeout(() => {
        $(".loader").fadeOut(1000);
    }, 3000);
});
$(document).ready(function () {
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

    function close_modal() {
        $("#img-viewer").hide();
        $("body").removeClass("full-screen");
        enableScroll();
    }

    function disableScroll() {
        $(window).on("scroll.disableScroll", function () {
            $(window).scrollTop(0);
        });
    }

    function enableScroll() {
        $(window).off("scroll.disableScroll");
    }

    $(".btn-zoom").on("click", function () {
        full_view(this);
    });

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

document.getElementById("dropdown").addEventListener("click", function (event) {
    if (event.target.tagName === "BUTTON") {
        const selectedOption = event.target.innerText.toLowerCase();
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set("sort_by", selectedOption);
        window.location.href = currentUrl.href;
    }
});

