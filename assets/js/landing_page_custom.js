/*========== TOP SCROLL BUTTON ==========*/

$(document).ready(function () {
  //when document is ready
  $(window).scroll(function () {
    //when webpage is scrolled
    if ($(this).scrollTop() > 300) {
      //if scroll from top is more than 500
      $(".top-scroll").fadeIn(); //display element with class 'top-scroll'; opacity increases
    } else {
      //if not
      $(".top-scroll").fadeOut(); //hide element with class 'top-scroll'; opacity decreases
    }
  });
});

/*========== Owl Carousel ==========*/

$(document).ready(function () {
  //when document is ready
  $(".owl-carousel").owlCarousel({
    loop: true,
    autoplay: true,
    margin: 10,
    nav: false,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 1,
      },
      1000: {
        items: 1,
      },
    },
  });
});

/*========== Wow JS ==========*/

$(document).ready(function () {
		new WOW().init();
});