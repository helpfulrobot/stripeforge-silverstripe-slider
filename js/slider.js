$(document).ready(function() {
  // - init bxSlider
  $('.page__slider .slider__slides').bxSlider({
    mode: 'fade',
    auto: true,
    autoControls: false,
    speed: 500,
    pause: 5000,
    randomStart: false,
    useCSS: true,
    pager: true,
    controls: true
  });
});