$(function () {
  // Handle window scroll event
  let lastScrollTop = 0;
  $(window).on("scroll", function (e) {
    let position = $(this).scrollTop();
    if (position > lastScrollTop) {
      // Downscroll code
      $("#" + HEADER_ID).css("top", "-100px");
      if (position > 120) {
        $("#" + SCROLL_TOP_BUTTON_ID).css("right", "24px");
      }
    } else {
      // Upscroll code
      $("#" + HEADER_ID).css("top", "0px");
      if (position < 120) {
        $("#" + SCROLL_TOP_BUTTON_ID).css("right", "-100px");
      }
    }
    lastScrollTop = position;
  });

  // Handle click scroll to top button
  $("#" + SCROLL_TOP_BUTTON_ID).on("click", function (e) {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
});
