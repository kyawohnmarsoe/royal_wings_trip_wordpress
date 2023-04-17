(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/babe-item-steps.default', ($scope) => {
            let $toggle = $scope.find('.zourney-toogle-step');
            let $toggleClass = $('.block_step_title, .block_step_content');
            $toggle.on('click', function (e) {
                e.preventDefault();
                $(this).toggleClass('active');
                if ($(this).hasClass('active')) {
                    $toggle.text(zourneyAjax.collapse)
                    $toggleClass.addClass('block_active');
                } else {
                    $toggle.text(zourneyAjax.expand)
                    $toggleClass.removeClass('block_active');
                }


            });
        });
    });

})(jQuery);