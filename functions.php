<?php
/**
 * Loads the child theme textdomain.
 */
function celestia_load_language() {
    load_child_theme_textdomain( 'celestia' );
}
add_action( 'after_setup_theme', 'celestia_load_language' );

if ( ! defined( 'CELESTIA_S_VERSION' ) ) {
    // Replace the version number of the theme on each release.
    define( 'CELESTIA_S_VERSION', '1.0.0' );
}

/**
 * Fairy Theme Customizer default values and infer from Fairy
 *
 * @package Fairy
 */
if ( !function_exists('fairy_default_theme_options_values') ) :
    function fairy_default_theme_options_values() {
        $default_theme_options = array(
           /*Top Header*/
           'fairy-enable-top-header'=> true,
           'fairy-enable-top-header-social'=> true,
           'fairy-enable-top-header-menu'=> true,
           'fairy-enable-top-header-search'=> true,

           /*Slider Settings Option*/
           'fairy-enable-slider'=> false,
           'fairy-select-category'=> 0,
           'fairy-image-size-slider'=> 'cropped-image',

           /*Category Boxes*/
           'fairy-enable-category-boxes'=> false,
           'fairy-single-cat-posts-select-1'=> 0,

            //Category color
           'fairy-enable-category-color'=> true,
           'fairy-category-line-color' => '#3D3B40',

           /*Sidebar Options*/
           'fairy-sidebar-blog-page'=>'right-sidebar',
           'fairy-sidebar-single-page' =>'right-sidebar',
           'fairy-enable-sticky-sidebar'=> true,

           /*Blog Page Default Value*/
           'fairy-column-blog-page'=> 'one-column',
           'fairy-content-show-from'=>'excerpt',
           'fairy-excerpt-length'=>14,
           'fairy-pagination-options'=>'numeric',
           'fairy-read-more-text'=> esc_html__('Read More','fairy'),
           'fairy-blog-page-masonry-normal'=> 'normal',
           'fairy-blog-page-image-position'=> 'left-image',
           'fairy-image-size-blog-page'=> 'original-image',

           /*Blog Layout Overlay*/
           'fairy-site-layout-blog-overlay'=> 1,

           /*Site Layout Options*/
           'fairy-dark-light-layout-options'=> true,

           /*Single Page Default Value*/
           'fairy-single-page-featured-image'=> true,
           'fairy-single-page-tags'=> false,
           'fairy-enable-underline-link' => true,
           'fairy-single-page-related-posts'=> true,
           'fairy-single-page-related-posts-title'=> esc_html__('Related Posts','fairy'),

           /*Breadcrumb Settings*/
           'fairy-blog-site-breadcrumb'=> true,
           'fairy-breadcrumb-display-from-option'=> 'theme-default',
           'fairy-breadcrumb-text'=> '',

        /*General Colors*/
           'fairy-primary-color' => '#cd3636',
           'fairy-header-description-color'=>'#404040',

           'fairy-overlay-color' => 'rgba(0, 0, 0, 0.5)',
           'fairy-overlay-second-color'=> 'rgb(150 150 150 / 34%)',

           /*Footer Options*/
           'fairy-footer-copyright'=> esc_html__('All Rights Reserved 2024.','fairy'),
           'fairy-go-to-top'=> true,
           'fairy-go-to-top-icon'=> esc_html__('fa-solid fa-arrow-up','fairy'),
           'fairy-go-to-top-icon-new'=> esc_html__('fa-long-arrow-alt-up','fairy'),
           'fairy-footer-social-icons'=> false,
           'fairy-footer-mailchimp-subscribe'=> false,
           'fairy-footer-mailchimp-form-id'=> '',
           'fairy-footer-mailchimp-form-title'=>  esc_html__('Subscribe to my Newsletter','fairy'),
           'fairy-footer-mailchimp-form-subtitle'=> esc_html__('Be the first to receive the latest buzz on upcoming contests & more!','fairy'),

           /*Font Options*/
           'fairy-font-family-url'=> 'Muli:400,300italic,300',
           'fairy-font-heading-family-url'=> 'Poppins:400,500,600,700',

           /*Extra Options*/
           'fairy-post-published-updated-date'=> 'post-published',
           'fairy-font-awesome-version-loading'=> 'version-6',
        );
        return apply_filters( 'fairy_default_theme_options_values', $default_theme_options );
    }
endif;


/**
* Enqueue Style
*/
add_action( 'wp_enqueue_scripts', 'celestia_style');
function celestia_style() {
	wp_enqueue_style( 'fairy-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'celestia-style',get_stylesheet_directory_uri() . '/style.css',array('fairy-style'));

}


if (!function_exists('fairy_footer_theme_info')) {
    /**
     * Add Powered by texts on footer
     *
     * @since 1.0.0
     */
    function fairy_footer_theme_info()
    {
        ?>
        <div class="site-info text-center">
            <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'celestia' ) ); ?>">
                <?php
                /* translators: %s: CMS name, i.e. WordPress. */
                printf( esc_html__( 'Proudly powered by %s', 'celestia' ), 'WordPress' );
                ?>
            </a>
            <span class="sep"> | </span>
            <?php
            /* translators: 1: Theme name, 2: Theme author. */
            printf( esc_html__( 'Theme: %1$s by %2$s.', 'celestia' ), 'Celestia', '<a href="http://www.candidthemes.com/">Candid Themes</a>' );
            ?>
        </div><!-- .site-info -->
        <?php
    }
}
add_action('fairy_footer_info_texts', 'fairy_footer_theme_info', 20);


function celestia_customize_register( $wp_customize ) {

    $default = fairy_default_theme_options_values();

    
/**
 *  Celestia Dark Layout Option
 *
 * @since Fairy 1.0.0
 *
 */
/*Site dark and light Layout settings*/
/*Blog Section Box Shadow*/
$wp_customize->add_setting( 'fairy_options[fairy-dark-light-layout-options]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['fairy-dark-light-layout-options'],
    'sanitize_callback' => 'fairy_sanitize_checkbox'
) );
$wp_customize->add_control( 'fairy_options[fairy-dark-light-layout-options]', array(
    'label'     => __( 'Dark and Light Layout Option', 'fairy' ),
    'description' => __('Make the overall layout of site dark and light.', 'fairy'),
    'section'   => 'fairy_site_layout_section',
    'settings'  => 'fairy_options[fairy-dark-light-layout-options]',
    'type'      => 'checkbox',
    'priority'  => 15,
) );


/**
 *  Fairy Category Color Option
 *
 * @since Fairy 1.0.0
 *
 */
/*Category Color Options*/
$wp_customize->add_section('fairy_category_color_setting', array(
    'priority'      => 72,
    'title'         => __('Category Color', 'fairy'),
    'description'   => __('You can select the different color for each category.', 'fairy'),
    'panel'          => 'fairy_panel'
));

/*Enable Category Color*/
$wp_customize->add_setting( 'fairy_options[fairy-enable-category-color]', array(
    'capability'        => 'edit_theme_options',
    'transport' => 'refresh',
    'default'           => $default['fairy-enable-category-color'],
    'sanitize_callback' => 'fairy_sanitize_checkbox'
) );
$wp_customize->add_control( 'fairy_options[fairy-enable-category-color]', array(
    'label'     => __( 'Enable Category Color', 'fairy' ),
    'description' => __('Checked to enable the category color and select the required color for each category.', 'fairy'),
    'section'   => 'fairy_category_color_setting',
    'settings'  => 'fairy_options[fairy-enable-category-color]',
    'type'      => 'checkbox',
    'priority'  => 1,
) );

/*callback functions header section*/
if ( !function_exists('fairy_colors_active_callback') ) :
    function fairy_colors_active_callback(){
        global $fairy_theme_options;
        $fairy_theme_options = fairy_get_options_value();
        $enable_color = absint($fairy_theme_options['fairy-enable-category-color']);
        if( 1 == $enable_color ){
            return true;
        }
        else{
            return false;
        }
    }
endif;

$i = 1;
$args = array(
    'orderby' => 'id',
    'hide_empty' => 0
);
$categories = get_categories( $args );
$wp_category_list = array();
foreach ($categories as $category_list ) {
    $wp_category_list[$category_list->cat_ID] = $category_list->cat_name;

    $wp_customize->add_setting('fairy_options[cat-'.get_cat_id($wp_category_list[$category_list->cat_ID]).']', array(
        'default'           => $default['fairy-primary-color'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'fairy_options[cat-'.get_cat_id($wp_category_list[$category_list->cat_ID]).']',
            array(
                'label'     => sprintf(__('"%s" Color', 'fairy'), $wp_category_list[$category_list->cat_ID] ),
                'section'   => 'fairy_category_color_setting',
                'settings'  => 'fairy_options[cat-'.get_cat_id($wp_category_list[$category_list->cat_ID]).']',
                'priority'  => $i,
                'active_callback'   => 'fairy_colors_active_callback'
            )
        )
    );
    $i++;
}
}
add_action( 'customize_register', 'celestia_customize_register');


function celestia_remove_font_awesome_version_option($wp_customize) {
    // Remove Font Awesome version loading control
    $wp_customize->remove_control('fairy_options[fairy-font-awesome-version-loading]');
}
add_action( 'customize_register', 'celestia_remove_font_awesome_version_option', 99);

/**
 * Celestia Header.
 */

if (!function_exists('fairy_construct_header')) {
    /**
     * Add header
     *
     * @since 1.0.0
     */
    function fairy_construct_header()
    {
        global $fairy_theme_options;
        $fairy_enable_top_header = absint($fairy_theme_options['fairy-enable-top-header']);
        $fairy_enable_top_social = absint($fairy_theme_options['fairy-enable-top-header-social']);
        $fairy_enable_top_menu = absint($fairy_theme_options['fairy-enable-top-header-menu']);
        $fairy_enable_top_search = absint($fairy_theme_options['fairy-enable-top-header-search']);
    ?>
        <header id="masthead" class="site-header text-center site-header-left-logo">
            <?php
            if (($fairy_enable_top_header == 1) && (($fairy_enable_top_menu == 1) || ($fairy_enable_top_search == 1) || ($fairy_enable_top_social == 1))) {
            ?>
                <section class="site-header-topbar">
                    <a href="#" class="top-header-toggle-btn">
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </a>
                    <div class="container">
                        <div class="row">
                            <div class="col col-sm-2-3 col-md-2-3 col-lg-2-4">
                                <?php
                                /**
                                 * fairy_top_left hook.
                                 *
                                 * @since 1.0.0
                                 *
                                 * @hooked fairy_top_menu - 10
                                 *
                                 */
                                do_action('fairy_top_left');
                                ?>
                            </div>
                            <div class="col col-sm-1-3 col-md-1-3 col-lg-1-4">
                                <div class="fairy-menu-social topbar-flex-grid">
                                    <?php
                                    /**
                                     * fairy_top_right hook.
                                     *
                                     * @since 1.0.0
                                     *
                                     * @hooked fairy_top_search - 10
                                     * @hooked fairy_top_social - 20
                                     *
                                     */
                                    do_action('fairy_top_right');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php
            }

            /**
             * fairy_main_header hook.
             *
             * @since 1.0.0
             *
             * @hooked fairy_construct_main_header - 10
             */
            do_action('fairy_main_header');
            ?>

        </header><!-- #masthead -->
    <?php

    }
}
add_action('fairy_header', 'fairy_construct_header', 20);

if (!function_exists('fairy_default_header')) {
    /**
     * Add Default header
     *
     * @since 1.0.0
     */
    function fairy_default_header()
    {
        //has header image
        $has_header_image = has_header_image();
    ?>

        <div id="site-nav-wrap">
            <div class="container">
                <div class="row">
                    <section id="site-navigation" class="site-header-top header-main-bar" <?php if (!empty($has_header_image)) { ?> style="background-image: url(<?php echo header_image(); ?>);" <?php } ?>>
                        <div class="container">
                            <div class="row">
                                <div class="col-1-1">
                                    <?php
                                    /**
                                     * fairy_branding hook.
                                     *
                                     * @since 1.0.0
                                     *
                                     * @hooked fairy_construct_branding - 10
                                     */
                                    do_action('fairy_branding');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="site-header-bottom">

                        <div class="container">
                            <?php
                            /**
                             * fairy_main_menu hook.
                             *
                             * @since 1.0.0
                             *
                             * @hooked fairy_construct_main_menu - 10
                             */
                            do_action('fairy_main_menu');
                            ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    <?php
    }
}
add_action('fairy_header_default', 'fairy_default_header', 10);

/**
 * Load Dynamic CSS from Customizer
 */
require get_stylesheet_directory() . '/inc/custom-css.php';
