<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Product Slider ShortCode
 */
add_shortcode('odc-carousel', 'odc_shortcode');

if (!function_exists('odc_shortcode')):
    
    function odc_shortcode($atts) {
    
        // Enqueue script & style
        wp_enqueue_script('odc-carousel-owl-carousel-script');
        wp_enqueue_style('odc-carousel-owl-carousel-style');
        wp_enqueue_script('odc-carousel-main-script');
        wp_enqueue_style('odc-carousel-main-style');

        // Extract shortcode attributes
        extract(shortcode_atts(array(
            'cat' => ''
        ), $atts));
        
        // Slider settings
        $slider_attr = array(
            'autoplay' => TRUE,
            'loop' => TRUE,
            'navigation' => TRUE,
            'slideby' => TRUE,
            'pagination' => TRUE,
            'items' => 3,
            'desktopsmall' => 2,
            'tablet' => 2,
            'mobile' => 1,
            'direction' => ( is_rtl() ? 'true' : 'false' )
        );
        $slider_attr = apply_filters('odc_data_attributes', $slider_attr);  // Slider attributes
        
        // If cat attribute not set in shortcode display lastest 12 posts
        if (!empty($cat) && $cat > 0):
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 12,
                'cat' => $cat,
                'orderby' => 'date',
                'order' => 'DESC',
            );
        else:
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 12,
                'orderby' => 'date',
                'order' => 'DESC',
            );
        endif;

        // WP Query for posts
        $loop = new WP_Query($args);

        ob_start();

        if ($loop->have_posts()) {
            ?>
            <div class="owl_slider_area">
                <div class="odc-post-slider owl-carousel owl-theme" <?php odc_data_attributes($slider_attr); ?>>
                    <?php
                    while ($loop->have_posts()) : $loop->the_post();
                        ?>
                        <figure>
                            <a href="<?php the_permalink(); ?>">
                                <?php
                                if (has_post_thumbnail()):
                                    the_post_thumbnail('post-thumbnail');
                                endif;
                                ?>
                            </a>
                            <figcaption>
                                <a href="<?php the_permalink(); ?>" class="slider-post-title">
                                    <?php the_title('<h5>', '</h5>') ?>
                                </a>
                            </figcaption>
                        </figure>
                        <?php
                        wp_reset_postdata();
                    endwhile;
                    ?>
                </div>
            </div>
            <?php
        } else {
            printf('<div class="alert alert-danger"><b>%s</b></div>', esc_html__('No Post Found in this category'));
        }

        return ob_get_clean();
    }

endif;
