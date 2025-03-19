<?php 
// After Add to cart its redirect checkout page
function redirect_to_checkout()
{
	global $woocommerce;
	$checkout_url = $woocommerce->cart->get_checkout_url();
	return $checkout_url;
}
add_filter('add_to_cart_redirect', 'redirect_to_checkout');