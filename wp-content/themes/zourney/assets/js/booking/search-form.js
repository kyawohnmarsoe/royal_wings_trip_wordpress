(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/babe-search-form.default', ($scope) => {

            $('.add_input_field .add_ids_title').on('click', function (event) {
                event.preventDefault();
                $('.add_ids_list').removeClass('active');
                if ($(this).parent().find('.add_ids_list').hasClass('zourney-active')) {
                    $(this).parent().find('.add_ids_list').removeClass('zourney-active');
                    search_add_list_close(this);
                } else {
                    $('.add_ids_list').removeClass('zourney-active');
                    search_add_list_close('.add_ids_title');
                    $(this).parent().find('.add_ids_list').addClass('zourney-active');
                    search_add_list_open(this);
                }
            });


            $('.add_input_field .add_ids_list .term_item').on('click', function (event) {
                var parent = $(this).closest('.add_ids_title');
                search_add_input_toggle(parent);
            });

            $(document).on('click', function (event) {
                var par = $(event.target).closest('.add_input_field');
                if (par.length) {
                    $(par).siblings().each(function (ind, elm) {
                        search_add_input_close(this);
                    });
                } else {
                    $(document).find('.add_input_field .add_ids_list.zourney-active').parents().eq(1).each(function (ind, elm) {
                        search_add_input_close(this);
                    });
                }
            });

            function search_add_input_toggle(item) {
                $(item).parent().find('.add_ids_list').toggleClass('zourney-active');
                $(item).parent().find('.add_ids_title .js-zourney-icon').toggleClass('active');
            }

            function search_add_input_close(item) {
                $(item).find('.add_ids_list').removeClass('zourney-active');
                $(item).parent().find('.add_ids_title .js-zourney-icon').toggleClass('active');
            }

            function search_add_list_open(item) {
                $(item).parent().find('.add_ids_title .js-zourney-icon').toggleClass('active');
            }

            function search_add_list_close(item) {
                $(item).parent().find('.add_ids_title .js-zourney-icon').toggleClass('active');
            }

            $('#date_from.search_date').on('show.daterangepicker', function () {
                console.log('test');
                let $parret = $(this).closest('.field-search-group');
                if ($parret) {
                    $('.daterangepicker').css({
                        width: $parret.width() + 2,
                        marginLeft: - ($(this).offset().left - $parret.offset().left + 1)
                    })
                }

            });

        });
    });

})(jQuery);
