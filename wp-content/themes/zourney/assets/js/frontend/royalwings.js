(function ($) {
  'use strict';
  

$(window).on("scroll", function() {
  if($(window).scrollTop() > 50) {
      $("header").addClass("bg-white");
  } else {
     $("header").removeClass("bg-white");
  }
});


// function backtotop() {
//   $(window).scroll(function(){
//       if ($(this).scrollTop() > 50) {
//           $('.scrollup').addClass('activate');
//       } else {
//           $('.scrollup').removeClass('activate');
//       }
//   });
//   $('.scrollup').on('click', function () {
//       $("html, body").animate({scrollTop: 0}, 600);
//       return false;
//   });
// }


})(jQuery);
