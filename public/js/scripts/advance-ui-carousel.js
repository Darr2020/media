/*
 * Carousel - Advanced UI 
 */
$(function () {
    // Carousel
    $('.carousel').carousel();
    // Full Width Slider
    $('.carousel.carousel-slider').carousel({
        fullWidth: true
    });
    // Special Options
    $('.carousel.carousel-slider').carousel({
        fullWidth: true,
        fullHeight: true,
        transition: 500,
        interval: 6000
    });
});
