<?php
// After Add to cart its redirect checkout page
function redirect_to_checkout()
{
	global $woocommerce;
	$checkout_url = $woocommerce->cart->get_checkout_url();
	return $checkout_url;
}
add_filter('add_to_cart_redirect', 'redirect_to_checkout');

function shipping_box()
{
	 wp_enqueue_style('happy-woocommerce-cart-style'); 

	if (WC()->cart->needs_shipping()) {
        echo '<div class="checkout-shipping-info">';
        echo '<h3>📦 আপনার শিপিং অপশন বেছে নিন</h3>';
        WC()->cart->calculate_totals();
        wc_cart_totals_shipping_html();
        echo '</div>
		<div>
		<button type="submit" class="order_button primary_btn alt" name="woocommerce_checkout_place_order" id="place_order" value="অর্ডার টি জমা দিন" data-value="অর্ডার টি জমা দিন"> অর্ডার টি জমা দিন </button>
		</div>
		';
    }
}
add_action('woocommerce_checkout_shipping', 'shipping_box');

// checkout billing details text change
function wc_billing_field_strings( $translated_text, $text, $domain ) {
    switch ( $translated_text ) {
        case 'Billing details' :
            $translated_text = __( 'অর্ডার সম্পন্ন করার জন্য তথ্য প্রদান করুন', 'woocommerce' );
            break;
    }
    return $translated_text;
}
add_filter( 'gettext', 'wc_billing_field_strings', 20, 3 );