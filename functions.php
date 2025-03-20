<?php
/**
 * Happy Care Life Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Happy Care Life
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define('HAPPY_CARE_THEME_VERSION', '1.0.0');
define('HAPPY_CARE_THEME_DIR', __DIR__);
define('HAPPY_CARE_THEME_URL', get_stylesheet_directory_uri());

/**
 * Register new Elementor widgets.
 *
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */

// Required all need files
require_once(HAPPY_CARE_THEME_DIR . '/includes/setup.php');
require_once(HAPPY_CARE_THEME_DIR . '/includes/woocommerce/single-product.php');
require_once(HAPPY_CARE_THEME_DIR . '/includes/woocommerce/woocommerce.php');
require_once(HAPPY_CARE_THEME_DIR . '/includes/woocommerce/checkout.php');


function register_new_widgets($widgets_manager)
{

    require_once(HAPPY_CARE_THEME_DIR . '/includes/widgets/products.php');
    $widgets_manager->register(new \Elementor_Products_widget());

}
add_action('elementor/widgets/register', 'register_new_widgets');

/******************
 * Enqueue styles
 ******************/
function child_enqueue_styles()
{

    wp_enqueue_style('happy-care-life-theme-css', HAPPY_CARE_THEME_URL . '/style.css', array('astra-theme-css'), HAPPY_CARE_THEME_VERSION, 'all');
    wp_register_style('happy_care_products_style', HAPPY_CARE_THEME_URL . '/assets/css/products.css');
    wp_register_style('happy_care_single_product', HAPPY_CARE_THEME_URL . '/assets/css/woocommerce/single-product.css');
    wp_register_style('happy_care_single_details_reviews', HAPPY_CARE_THEME_URL . '/assets/css/woocommerce/Product-details-reviews.css');

}
add_action('wp_enqueue_scripts', 'child_enqueue_styles', 15);



if (class_exists('WooCommerce')) {

    // Remove Single Product Page Elements
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);

}


function enqueue_custom_single_product_scripts()
{
    if (is_product()) { // Load only on the single product page
        // Enqueue jQuery (WooCommerce already includes it)
        wp_enqueue_script('jquery');

        // Enqueue LightSlider library (If you're using LightSlider, make sure it's added)
        wp_enqueue_script('lightslider', 'https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js', array('jquery'), null, true);
        wp_enqueue_style('lightslider-css', 'https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css');

        // Enqueue your custom JS file
        wp_enqueue_script('custom-single-product-gallery',
         HAPPY_CARE_THEME_URL . '/assets/css/woocommerce/single-product.css', array('jquery', 'lightslider'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_single_product_scripts');