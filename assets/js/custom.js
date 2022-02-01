/*========== REGISTER FORM ==========*/

//-- Hide and Show Register Login --//
$(document).ready(function () {
  //On click signup, hide login and show registration form
  $("#signup").click(function () {
    $(".login__wrapper").slideUp("slow", function () {
      $(".register__wrapper").slideDown("slow");
    });
  });

  //On click signin, hide registration and show login form
  $("#signin").click(function () {
    $(".register__wrapper").slideUp("slow", function () {
      $(".login__wrapper").slideDown("slow");
    });
  });
});

/*========== ADMIN NAVBAR TOGGLER ==========*/

$(function () {
  $("#sidebarCollapse").on("click", function () {
    $("#sidebar, #admin_content").toggleClass("active");
  });
});

/*========== CLOSE MOBILE NAV ON CLICK ==========*/

$(document).click(function (event) {
  //click anywhere
  var clickover = $(event.target); //get the target element where you clicked
  var _opened = $(".navbar-collapse").hasClass("show"); //check if element with 'navbar-collapse' class has a class called show. Returns true and false.
  if (_opened === true && !clickover.hasClass("navbar-toggler")) {
    // if _opened is true and clickover(element we clicked) doesn't have 'navbar-toggler' class
    $(".navbar-toggler").click(); //toggle the navbar; close the navbar menu in mobile.
  }
});

/*========== INTERNET NOTIFICATION POPUP MESSAGE ==========*/

const offlineConnection = document.querySelector(".offline");
const onlineConnection = document.querySelector(".online");
const closeBtn = document.querySelectorAll(".close");
const refreshBtn = document.querySelector(".refreshBtn");

function online() {
  offlineConnection.classList.remove("active");
  onlineConnection.classList.add("active");
}
function offline() {
  offlineConnection.classList.add("active");
  onlineConnection.classList.remove("active");
}

window.addEventListener("online", () => {
  online();
  setTimeout(() => {
    onlineConnection.classList.remove("active");
  }, 5000);
});
window.addEventListener("offline", () => {
  offline();
});

for (let i = 0; i < closeBtn.length; i++) {
  closeBtn[i].addEventListener("click", () => {
    closeBtn[i].parentNode.classList.remove("active");
    if (closeBtn[i].parentNode.classList.contains("offline")) {
      setTimeout(() => {
        closeBtn[i].parentNode.classList.add("active");
      }, 500);
    }
  });
}

refreshBtn.addEventListener("click", () => {
  window.location.reload();
});

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