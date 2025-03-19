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
define('CHILD_THEME_HAPPY_CARE_LIFE_VERSION', '1.0.0');


/**
 * Register new Elementor widgets.
 *
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */

require_once(__DIR__ . '/includes/setup.php');
function register_new_widgets($widgets_manager)
{

	require_once(__DIR__ . '/includes/widgets/products.php');
	$widgets_manager->register(new \Elementor_Products_widget());

}
add_action('elementor/widgets/register', 'register_new_widgets');

/**
 * Enqueue styles
 */
function child_enqueue_styles()
{

	wp_enqueue_style('happy-care-life-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_HAPPY_CARE_LIFE_VERSION, 'all');
	wp_register_style('happy_care_products_style', get_stylesheet_directory_uri() . '/assets/css/products.css');

}

add_action('wp_enqueue_scripts', 'child_enqueue_styles', 15);



// After Add to cart its redirect checkout page
function redirect_to_checkout()
{
	global $woocommerce;
	$checkout_url = $woocommerce->cart->get_checkout_url();
	return $checkout_url;
}
add_filter('add_to_cart_redirect', 'redirect_to_checkout');


// in the single page add buy now button
function single_product_add_buy_btn()
{
	global $product;
	$pid = $product->get_id();
	?>
	<a href="<?php
	echo do_shortcode('[add_to_cart_url id=' . $pid . ']') ?>"
	>
		অর্ডার করুন
	</a>
	<?php
}
add_action('woocommerce_after_main_content', 'single_product_add_buy_btn',);