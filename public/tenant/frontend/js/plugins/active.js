(function ($) {
  "use strict";
  $(document).on("ready", function () {
    /*==============================================================================
		  Header Sticky JS
	  ===============================================================================*/
    var activeSticky = $("#active-sticky"),
      winDow = $(window);
    winDow.on("scroll", function () {
      var scroll = $(window).scrollTop(),
        isSticky = activeSticky;
      if (scroll < 150) {
        isSticky.removeClass("is-sticky");
      } else {
        isSticky.addClass("is-sticky");
      }
    });

    /*==============================================================================
		 	Mobile Menu JS
	  ===============================================================================*/
    var $offcanvasNav = $("#offcanvas-menu a");
    $offcanvasNav.on("click", function () {
      var link = $(this);
      var closestUl = link.closest("ul");
      var activeLinks = closestUl.find(".active");
      var closestLi = link.closest("li");
      var linkStatus = closestLi.hasClass("active");
      var count = 0;

      closestUl.find("ul").slideUp(function () {
        if (++count == closestUl.find("ul").length)
          activeLinks.removeClass("active");
      });
      if (!linkStatus) {
        closestLi.children("ul").slideDown();
        closestLi.addClass("active");
      }
    });

    /*==============================================================================
			CounterUp JS
		================================================================================*/
    $(".counter").counterUp({
      time: 1500,
    });

    /*=============================================================================
			Nice Select JS
  	===============================================================================*/
    $("select").niceSelect();

    /*==============================================================================
		  Wow JS
	  ================================================================================*/
    var window_width = $(window).width();
    if (window_width > 767) {
      new WOW().init();
    }

    /*=============================================================================
      Video Popup JS
    ===============================================================================*/
    $(".popup-video").magnificPopup({
      type: "iframe",
    });

    /*=============================================================================
      Active InActive Toggle JS
    ===============================================================================*/
    $(".sidebar-trigger").click(function () {
      $(".user-d-row, .user-d-sidebar, .user-d-content").toggleClass(
        "inactive"
      );
    });

    // Filter Bar
    function toggleFilterBar() {
      if ($(".biodata-sidebar").hasClass("filter-open")) {
        // Filter is open, so close it
        $(".biodata-sidebar").removeClass("filter-open");
        // Re-enable body scrolling
        $("body").css("overflow", "auto");
        // Remove overlay if it exists
        $(".filter-overlay").remove();
      } else {
        // Filter is closed, so open it
        $(".biodata-sidebar").addClass("filter-open");
        // Disable body scrolling and add overlay
        $("body").css("overflow", "hidden");
        $("body").append('<div class="filter-overlay"></div>');
      }
    }

    // Click event for the filter open button
    $(".filter-open-btn").click(toggleFilterBar);

    // Click event for the close button
    $(".close-btn").click(toggleFilterBar);

    /*=============================================================================
      Age Range Slider JS
    ===============================================================================*/
    $(function () {
      $("#slider-range-one").slider({
        range: true,
        min: 18,
        max: 60,
        values: [18, 60],
        slide: function (event, ui) {
          $("#amount-one").val("" + ui.values[0] + " - " + ui.values[1]);
        },
      });
      $("#amount-one").val(
        "" +
          $("#slider-range-one").slider("values", 0) +
          " - " +
          $("#slider-range-one").slider("values", 1)
      );
    });

    /*=============================================================================
      Height Range Slider JS
    ===============================================================================*/
    $(function () {
      $("#slider-range-two").slider({
        range: true,
        min: 4,
        max: 7,
        values: [4, 7],
        slide: function (event, ui) {
          $("#amount-two").val(
            "" + ui.values[0] + "Ft - " + ui.values[1] + "Ft"
          );
        },
      });
      $("#amount-two").val(
        "" +
          $("#slider-range-two").slider("values", 0) +
          "Ft - " +
          $("#slider-range-two").slider("values", 1) +
          "Ft"
      );
    });

    /*==============================================================================
		  About Us Image Slider
	  ================================================================================*/
    $(".about-us-image-slider").owlCarousel({
      items: 1,
      autoplay: true,
      loop: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: false,
      smartSpeed: 500,
      merge: true,
      nav: true,
      dots: false,
      margin: 12,
      navText: [
        "<i class='fi-rr-angle-small-left'></i>",
        "<i class='fi-rr-angle-small-right'></i>",
      ],
    });
  });
  /*==============================================================================
		Preloader JS
	================================================================================*/
  $(window).on("load", function (event) {
    $("#preloader").delay(800).fadeOut(500);
  });
})(jQuery);

/*==============================================================================
		Language Change Switch JS
================================================================================*/

function languageToggle() {
  let element = document.body;
  element.classList.toggle("language-change");

  let systemChange = localStorage.getItem("systemChange");
  if (systemChange && systemChange === "language-change") {
    localStorage.setItem("systemChange", "");
  } else {
    localStorage.setItem("systemChange", "language-change");
  }
}

(function () {
  let onpageLoad = localStorage.getItem("systemChange");
  if (onpageLoad && onpageLoad === "language-change") {
    document.body.classList.toggle("language-change");
  }
})();

(function ($) {
  "use strict";
  $(document).on("ready", function () {
    // Nice Select JS
    $("select").niceSelect();
  });
})(jQuery);
