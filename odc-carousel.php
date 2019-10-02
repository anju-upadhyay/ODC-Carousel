<?php

/**
 * Plugin Name: ODC Carousel
 * Plugin URI: https://github.com/anju-upadhyay/odc-carousel
 * Description: A simple plugin to fetch the latest posts and display them as a rotating carousel using shortcode with option to pass category id in shortcode as cat parameter.
 * Author: Anju Upadhyay
 * Version: 1.0
 * Author URI: 
 * Text Domain: odc-carousel
 */


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Define plugin path
 */
define('ODC_PLUGIN_URI', WP_CONTENT_URL . '/plugins/odc-carousel');

/**
 * Plugin activation redirect 
 */
if (!function_exists('odc_carousel_activation_redirect')) {

    function odc_carousel_activation_redirect($plugin) {
        if ($plugin == plugin_basename(__FILE__)) {
            exit(wp_redirect(admin_url('options-general.php?page=odc-carousel')));
        }
    }
    
    add_action('activated_plugin', 'odc_carousel_activation_redirect');

}

/**
 * Add options page
 */
if (!function_exists('odc_carousel_admin_actions')) {
    
    function odc_carousel_admin_actions() {
        add_options_page(
            'ODC Carousel', 'ODC Carousel', 'manage_options', 'odc-carousel', 'odc_carousel_page_content'
        );
    }

    add_action('admin_menu', 'odc_carousel_admin_actions');
}

/**
 * Add options content
 */
function odc_carousel_page_content() {
    ?>
    <div class="container">
        <div class="row">
            <h1>ODC Carousel shortcodes (ODC- One dot com)</h1>
            <ol>
                <li><b>[odc-carousel]</b> <br>Use this shortcode in any page to display latest 12 posts in carousel.</li>
                <li><b>[odc-carousel cat='cat_id']</b> <br>Use this shortcode to display latest 12 posts from a particular category in carousel: <b>cat_id is category ID for example : [odc-carousel cat='3']</b></li>
            </ol>
        </div>
    </div>
    <?php
}

/**
 * Plugin Action Links
 */
if (!function_exists('odc_carousel_add_action_links')) {

    function odc_carousel_add_action_links($links) {

        $links[] = '<a href="' . esc_url(get_admin_url(null, 'options-general.php?page=odc-carousel')) . '">' . __('Settings') . '</a>';
        return $links;
    }
    
    add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'odc_carousel_add_action_links');
}

/**
 * Adding scripts
 */
if (!function_exists('odc_carousel_adding_scripts')) {
    
    function odc_carousel_adding_scripts() {
        wp_register_script('odc-carousel-owl-carousel-script', ODC_PLUGIN_URI . '/assets/js/owl.carousel.js', array('jquery'), '2.2.1', true);
        wp_register_style('odc-carousel-owl-carousel-style', ODC_PLUGIN_URI . '/assets/css/owl.carousel.css', '', '2.2.1', false);
        wp_register_script('odc-carousel-main-script', ODC_PLUGIN_URI . '/assets/js/main.js', array('jquery'), '1.0', true);
        wp_register_style('odc-carousel-main-style', ODC_PLUGIN_URI . '/assets/css/main.css', '', '1.0', false);
    }
    
    add_action('wp_enqueue_scripts', 'odc_carousel_adding_scripts');

}

// Include shortcode & function files
include_once( plugin_dir_path(__FILE__) . 'inc/odc-carousel-shortcodes.php' );
include_once( plugin_dir_path(__FILE__) . 'inc/odc-carousel-functions.php' );
