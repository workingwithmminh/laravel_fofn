
$(function() {
    $('.news-slider').owlCarousel({
        items: 1,
        loop: true,
        lazyLoad: true,
        autoplay: true,
        autoplayTimeout: 4000,
        margin: 15,
        nav: true,
        responsiveClass: true,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
                nav: false,
                dots: true,
            },
            576: {
                items: 1,
                nav: false,
                dots: true,
            },
            768: {
                items: 1,
                nav: false,
                dots: true,
                loop: false,
            },
            992: {
                items: 1,
                nav: true,
                loop: false,
            }
        }
    });
});

