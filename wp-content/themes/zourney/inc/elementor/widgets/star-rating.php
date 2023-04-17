<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


class Zourney_Elementor_Star_Rating extends Widget_Star_Rating {


    public function get_name()
    {
        return 'zourney-star-rating';
    }

    public function get_title() {
        return esc_html__( 'Zourney Star Rating', 'zourney' );
    }

    public function get_categories()
    {
        return ['zourney-addons'];
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $rating_data = $this->get_rating();
        $textual_rating = $rating_data[0] . '/' . $rating_data[1];
        $icon = '&#xE934;';

        if ( 'star_fontawesome' === $settings['star_style'] ) {
            if ( 'outline' === $settings['unmarked_star_style'] ) {
                $icon = '&#xE933;';
            }
        } elseif ( 'star_unicode' === $settings['star_style'] ) {
            $icon = '&#9733;';

            if ( 'outline' === $settings['unmarked_star_style'] ) {
                $icon = '&#9734;';
            }
        }

        $this->add_render_attribute( 'icon_wrapper', [
            'class' => 'elementor-star-rating',
            'title' => $textual_rating,
        ] );

        $schema_rating = '<span class="elementor-screen-only">' . $textual_rating . '</span>';
        $stars_element = '<div ' . $this->get_render_attribute_string( 'icon_wrapper' ) . '>' . $this->render_stars( $icon ) . ' ' . $schema_rating . '</div>';
        ?>

        <div class="elementor-star-rating__wrapper">
            <?php if ( ! Utils::is_empty( $settings['title'] ) ) : ?>
                <div class="elementor-star-rating__title"><?php echo esc_html( $settings['title'] ); ?></div>
            <?php endif;
            printf('%s',$stars_element);?>
        </div>
        <?php
    }

    protected function content_template() {
        return;
    }

}
$widgets_manager->register(new Zourney_Elementor_Star_Rating());
