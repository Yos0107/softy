<?php

/**
 * Dynamic CSS elements.
 *
 * @package Fairy
 */
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}


if (!function_exists('across_dynamic_css')) :

function fairy_dynamic_css()
  {
    global $fairy_theme_options;
    $fairy_custom_css = '';

    $enable_category_color = !empty($fairy_theme_options['fairy-enable-category-color']) && ($fairy_theme_options['fairy-enable-category-color'] == 1);
    if ($enable_category_color == 1) {
        $args = array(
            'orderby' => 'id',
            'hide_empty' => 0
        );
        $categories = get_categories($args);
        $wp_category_list = array();
        $i = 1;
        foreach ($categories as $category_list) {
            $wp_category_list[$category_list->cat_ID] = $category_list->cat_name;

            $cat_color = 'cat-' . esc_attr(get_cat_id($wp_category_list[$category_list->cat_ID]));

            if (array_key_exists($cat_color, $fairy_theme_options)) {
                $cat_color_code = $fairy_theme_options[$cat_color];
                $fairy_custom_css .= "
                .category-label-group .ct-cat-item-{$category_list->cat_ID}{
                background-color: {$cat_color_code}; }";
            $i++;
            }
        }
    }

    wp_add_inline_style('fairy-style', $fairy_custom_css);
  }
endif;

add_action('wp_enqueue_scripts', 'fairy_dynamic_css', 99);