(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/babe-item-slideshow.default', ($scope) => {
            if ($(".booking_single_gallery").length) {
                var currentImage = 0;
                var _height = 0;
                var $slideshow_layout = $('.zourney-single-slideshow').data('layout');
                var $thumbnail = $('#booking-single-gallery-thumbnail');

                if( $slideshow_layout === 'style-1' ){
                    var $gallery = $('#booking-single-gallery-thumbnail-preview .inner').slick({
                        infinite: false,
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        // vertical: true,
                        // verticalSwiping: true,
                        fade: true,
                        rtl: $('body').hasClass('rtl'),
                        arrows: true,
                    })
                        .on('afterChange', function (slick, currentSlide, nextSlide) {
                            $('.thumbnail-inner', $thumbnail).removeClass('active');
                            currentImage = nextSlide;
                            var $_wrap = $thumbnail.find('[data-slick-index="' + nextSlide + '"]');
                            $_wrap.addClass('active');
                            if (parseInt(nextSlide) > 6) {
                                $thumbnail.find('[data-slick-index="5"]').find('>img').attr('src', $_wrap.data('thumbnail'));
                            } else {
                                $thumbnail.find('[data-slick-index="5"]').find('>img').attr('src', $thumbnail.find('[data-slick-index="5"]').data('thumbnail'));
                            }

                        });
                }

                if( $slideshow_layout === 'style-2' ){
                    var $gallery = $('#booking-single-gallery-thumbnail-preview .inner').slick({
                        infinite: true,
                        slidesToShow: 3,
                        centerMode: true,
                        centerPadding: '0px',
                        variableWidth: true,
                        slidesToScroll: 1,
                        rtl: $('body').hasClass('rtl'),
                        arrows: true,
                        initialSlide: 3,
                        swipeToSlide: true,
                        touchThreshold:99,
                    });
                }

                $thumbnail.on('click', '.thumbnail-inner', function () {
                    var isPopup = $(this).hasClass('last');
                    if (isPopup) {
                        var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, {
                            history: false,
                            focus: false,
                            index: currentImage
                        });
                        gallery.init();
                    } else {
                        var index = parseInt($(this).data('slick-index'));
                        $('.thumbnail-inner', $thumbnail).removeClass('active');
                        $(this).addClass('active');
                        currentImage = index;
                        $gallery.slick('slickGoTo', index)
                    }
                });

                // Initializes and opens PhotoSwipe
                var pswpElement = document.querySelectorAll('.pswp')[0];
                var items = $gallery.data('popup-json');
                $('.js-gallery-popup').on('click', function (event) {
                    event.preventDefault();
                    var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, {
                        history: false,
                        focus: false,
                        index: currentImage
                    });
                    gallery.init();
                });
            }

            $('.js-tab-popup a').magnificPopup({
                type: 'iframe',
                removalDelay: 500,
                midClick: true,
                closeBtnInside: true,
                callbacks: {
                    beforeOpen: function() {
                        this.st.mainClass = this.st.el.attr('data-effect');
                    }
                },
            });
        });
    });
})(jQuery);
