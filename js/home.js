$(document).ready(function () {
  var animation1 = lottie.loadAnimation({
    container: document.getElementById("lottie-animation"),
    renderer: "svg",
    loop: false,
    autoplay: true,
    path: "../assets/homeAnim1.json",
  });

  var animation2 = lottie.loadAnimation({
    container: document.getElementById("lottie-animation2"),
    renderer: "svg",
    loop: true,
    autoplay: true,
    path: "../assets/homeAnim2.json",
  });

  animation2.setSpeed(0.1);

  var previousScroll = 0;
  $(window).scroll(function () {
    var currentScroll = $(this).scrollTop();
    if (currentScroll > 0) {
      $("#mainNavbar").css("top", "0");
    } else {
      $("#mainNavbar").css("top", "-100px");
    }
    previousScroll = currentScroll;
  });
});
