<?php

/**
 * Dynamic CSS elements.
 *
 * @package Fairy
 */
if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}


if (!function_exists('celestia_dynamic_css')) :

function celestia_dynamic_css()
{
    global $fairy_theme_options;
    $celestia_custom_css = '';
    $primary_color = !empty($fairy_theme_options['fairy-primary-color']) ? esc_html($fairy_theme_options['fairy-primary-color']) : '';

    if (!empty($primary_color)) {
        $celestia_custom_css .= ".ajax-pagination .show-more { background-color: {$primary_color}; }";
        $celestia_custom_css .= ".wp-block-search .wp-block-search__button { background-color: {$primary_color}; }";
        $celestia_custom_css .= ".wp-block-search .wp-block-search__button { border: 1px solid {$primary_color}; }";
        $celestia_custom_css .= ".ajax-pagination .show-more { border-color: {$primary_color}; }";
    }

    //Image Overlay Color
    $first_overlay_color = esc_attr( $fairy_theme_options['fairy-overlay-color'] );
    $second_overlay_color = esc_attr( $fairy_theme_options['fairy-overlay-second-color'] );
    $celestia_custom_css .= ".card-bg-image:after, .card-bg-image.card-promo .card_media a:after  {background-image: linear-gradient(45deg, $first_overlay_color, $second_overlay_color); }";
    $site_description_color = !empty($fairy_theme_options['fairy-header-description-color']) ? esc_html($fairy_theme_options['fairy-header-description-color']) : '';

    if (!empty($site_description_color)) {
        $celestia_custom_css .= ".site-description { color: {$site_description_color}; }";
    }

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
                $celestia_custom_css .= "
                .category-label-group .ct-cat-item-{$category_list->cat_ID}{
                background-color: {$cat_color_code}; }";
            $i++;
            }
        }
    }

    wp_add_inline_style('fairy-style', $celestia_custom_css);
  }
endif;

add_action('wp_enqueue_scripts', 'celestia_dynamic_css', 99);