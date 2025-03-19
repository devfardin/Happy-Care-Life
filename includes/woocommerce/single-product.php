<?php
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