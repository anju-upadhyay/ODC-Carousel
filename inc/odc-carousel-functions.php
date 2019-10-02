<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Data attribute Array to data types
 */
if (!function_exists('odc_data_attributes')) {

    function odc_data_attributes($array) {
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                echo 'data-' . $key . '="' . $value . '" ';
            }
        }
    }

}
