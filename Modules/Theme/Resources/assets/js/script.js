$(document).ready(function () {

    // Gets the video src from the data-src on each button

    var $videoSrc;
    $('.video_play').click(function () {
        $videoSrc = $(this).data('src');
    });

    // when the modal is opened autoplay it  
    $('#myModal').on('shown.bs.modal', function (e) {

        // set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
        $("#video").attr('src', $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
    })

    // stop playing the youtube video when I close the modal
    $('#myModal').on('hide.bs.modal', function (e) {
        // a poor man's stop video
        $("#video").attr('src', $videoSrc);
    })

    $("#overlay").click(function (e) {
        if ($('.sidebar').hasClass('active') && !$('.dropdown-btn').hasClass('active')) {
            $('.sidebar').removeClass('active');
            $('.sidebarBtn').show();
        }
        else if (!$('.sidebar').hasClass('active') && $('.dropdown-btn').hasClass('active')) {

        }
        document.getElementById("overlay").style.display = "none";
        $('.sidebar').css('box-shadow', 'none');
    });

    $(".sidebarBtn").click(function (e) {
        e.stopPropagation();
        $('.sidebar').toggleClass('active');
        $('.sidebarBtn').hide();
        document.getElementById("overlay").style.display = "block";
        $('.sidebar').css('box-shadow', '0 0 10px rgba(255, 255, 255, 0.9)');
    });

    $('[data-toggle="tooltip"]').tooltip();

    $("body").click(function (e) {
        if ($(e.target).hasClass("fa-search")) {
            $('.search-bar-input').show();
        }
        else {
            $('.search-bar-input').hide();
        }
    })
    // document ready  
});

var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
    dropdown[i].addEventListener("click", function () {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
            dropdownContent.style.display = "none";
        } else {
            dropdownContent.style.display = "block";
        }
    });
}

function showButton() {


    var button = $('.backtop'), //button that scrolls user to top
        view = $(window),
        timeoutKey = -1;

    $(document).on('scroll', function () {
        if (timeoutKey) {
            window.clearTimeout(timeoutKey);
        }
        timeoutKey = window.setTimeout(function () {

            if (view.scrollTop() < 100) {
                button.fadeOut();
            }
            else {
                button.fadeIn();
            }
        }, 100);
    });
}

$('.backtop').on('click', function () {
    $('html, body').stop().animate({
        scrollTop: 0
    }, 500, 'linear');
    return false;
});

//call function on document ready
$(function () {
    showButton();
});

$('.panel-icon').on('click', function () {
    $(this).toggleClass('fas fa-plus fas fa-minus');
    $(this).closest('div').next().toggleClass('d-none d-block');
});

$('.image-slider').owlCarousel({
    items: 1,
    loop: true,
    lazyLoad: true,
    autoplay: true,
    autoplayTimeout: 4000,
    nav: false,
    responsiveClass: true,
    autoplayHoverPause: true,
    responsive: {
        0: {
            items: 1
        },
        576: {
            items: 1
        },
        768: {
            items: 1
        },
        992: {
            items: 1
        }
    }
});

$('.about-slider').owlCarousel({
    items: 4,
    loop: true,
    lazyLoad: true,
    autoplay: true,
    autoplayTimeout: 4000,
    margin: 10,
    nav: false,
    dots: false,
    responsiveClass: true,
    responsive: {
        0: {
            items: 1,
            dots: true
        },
        576: {
            items: 2,
        },
        768: {
            items: 2,
        },
        992: {
            items: 3,
        },
        1199: {
            items: 4,
        }
    }
});