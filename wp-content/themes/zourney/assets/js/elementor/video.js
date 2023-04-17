(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/zourney-video-popup.default', ( $scope ) => {
            if($('body').hasClass('elementor-editor-active')){
                return;
            }
            $scope.find('.zourney-video-popup a.elementor-video-popup').magnificPopup({
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
        } );
    });
})(jQuery);
