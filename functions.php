<?php
/**
 * Happy Care Life Theme functions and definitions
 *
 * @package Happy Care Life
 * @since 1.0.0
 */
if( ! defined( 'ABSPATH' ) ) {
    die( 'Please do not access directly!' );
};

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
require_once(HAPPY_CARE_THEME_DIR . '/includes/admin-menu/admin-menu.php');


// Check if CMB2 is already loaded
if (!class_exists('CMB2_Bootstrap_270')) {
    // Try loading CMB2 from the bundled version
    if (file_exists(plugin_dir_path(__FILE__) . 'includes/cmb2/init.php')) {
        require_once plugin_dir_path(__FILE__) . 'includes/cmb2/init.php';
    } else {
        // Show admin notice if CMB2 is missing
        add_action('admin_notices', 'baitu_cmb2_missing_notice');
    }
}
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
    wp_register_style('happy-woocommerce-cart-style', HAPPY_CARE_THEME_URL . '/assets/css/woocommerce/woocommerce-cart.css');
    wp_enqueue_style('happy-woocommerce-checkout', HAPPY_CARE_THEME_URL . '/assets/css/woocommerce/checkout.css');
    wp_enqueue_style('happy-woocommerce-archive-product', HAPPY_CARE_THEME_URL . '/assets/css/woocommerce/archive-product.css');
}
add_action('wp_enqueue_scripts', 'child_enqueue_styles', 15);


function enqueue_custom_single_product_scripts()
{
    if (is_product()) { 
        wp_enqueue_script('jquery');
        wp_enqueue_script('lightslider', 'https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js', array('jquery'), null, true);
        wp_enqueue_style('lightslider-css', 'https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css');
        wp_enqueue_script(
            'custom-single-product-gallery',
            HAPPY_CARE_THEME_URL . '/assets/css/woocommerce/single-product.css',
            array('jquery', 'lightslider'),
            null,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_single_product_scripts');