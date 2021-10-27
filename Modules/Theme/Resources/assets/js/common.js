
$(function() {
    $('.news-slider').owlCarousel({
        loop: true,
        margin: 10,
        navigation : true,
        slideSpeed : 300,
        paginationSpeed : 400,
        items : 1,
        autoplay: true,
        itemsDesktop : false,
        itemsDesktopSmall : false,
        itemsTablet: false,
        itemsMobile : false,
        navText: [
            "<i class='fas fa-angle-left'></i>",
            "<i class='fas fa-angle-right'></i>"
        ],
    });
});

