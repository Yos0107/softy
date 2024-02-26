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

      //Category Line  Color
      if(!empty($fairy_theme_options['fairy-category-line-color'])){
          $category_line_color = esc_attr( $fairy_theme_options['fairy-category-line-color'] );
          $fairy_custom_css .= ".cat-links a {background-image: linear-gradient($category_line_color, $category_line_color)!important; }";
          }
          
      //Image Overlay Color
      $first_overlay_color = esc_attr( $fairy_theme_options['fairy-overlay-color'] );
      $second_overlay_color = esc_attr( $fairy_theme_options['fairy-overlay-second-color'] );
      $fairy_custom_css .= ".card-bg-image:after, .card-bg-image.card-promo .card_media a:after  {background-image: linear-gradient(45deg, $first_overlay_color, $second_overlay_color)!important; }";

      if(!empty($fairy_theme_options['fairy-enable-category-color']) && $fairy_theme_options['fairy-enable-category-color'] == 1){
        // $enable_category_color = $fairy_theme_options['fairy-enable-category-color'];
        $args = array(
            'orderby' => 'id',
            'hide_empty' => 0
        );
        $categories = get_categories( $args );
        $wp_category_list = array();
        $i = 1;
        foreach ($categories as $category_list ) {
            $wp_category_list[$category_list->cat_ID] = $category_list->cat_name;

            $cat_color = 'cat-'.esc_attr( get_cat_id($wp_category_list[$category_list->cat_ID]) );
            if (array_key_exists($cat_color, $fairy_theme_options)) {
                $cat_color_code = $fairy_theme_options[$cat_color];
                $fairy_custom_css .= "
            .cat-{$category_list->cat_ID} .ct-title-head,
            .ct-cat-item-{$category_list->cat_ID}{
            background: {$cat_color_code}!important; }";
            $fairy_custom_css .= " 
            .cat-{$category_list->cat_ID} .ct-title-head,
            .ct-cat-item-{$category_list->cat_ID}{
                color: #fff!important;
                background-size: 5% 100%!important;
                background-image: linear-gradient($category_line_color, $category_line_color)!important;
                background-repeat: no-repeat!important;
                transition: background 0.3s, border 0.3s, border-radius 0.3s, box-shadow 0.3s, transform var(--e-transform-transition-duration, 0.4s)!important;

            }";
            $fairy_custom_css .="
            .cat-{$category_list->cat_ID} .ct-title-head,
            .ct-cat-item-{$category_list->cat_ID}:hover{
                background-image: linear-gradient($category_line_color, $category_line_color)!important;
                background-size: 100% 100% !important;
            }";
            $fairy_custom_css .= "
            .widget_fairy_category_tabbed_widget.widget ul.ct-nav-tabs li a.ct-tab-{$category_list->cat_ID} {
            color: {$cat_color_code}!important;
            }
            ";
            }
            $i++;
        }
    }

    wp_add_inline_style('fairy-style', $fairy_custom_css);
  }
endif;

add_action('wp_enqueue_scripts', 'fairy_dynamic_css', 99);