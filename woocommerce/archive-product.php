<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined('ABSPATH') || exit;

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');

/**
 * Hook: woocommerce_shop_loop_header.
 *
 * @since 8.6.0
 *
 * @hooked woocommerce_product_taxonomy_archive_header - 10
 */
do_action('woocommerce_shop_loop_header');

if (woocommerce_product_loop()) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action('woocommerce_before_shop_loop');

	woocommerce_product_loop_start();

	if (wc_get_loop_prop('total')) {
		while (have_posts()) {
			the_post();
			$product = wc_get_product(get_the_ID());
			$regular_price = $product->get_regular_price();
			$sale_price = $product->get_sale_price();
			$stock_status = $product->get_stock_status();
			?>

			<!-- Products Information here  -->
			<div class="products_inner_wrapper">
				<a href="<?php echo get_permalink(); ?>">
					<img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>" alt="<?php the_title(); ?>">
				</a>
				<div class="products_inner__info">
					<a href="<?php echo get_permalink(); ?>" class="product_inner_title"><?php the_title(); ?></a>
					<!-- Price Wrapper -->
					<div class="products_inner_price_wrapper">

						<?php if ($regular_price && $sale_price) {
							?>
							<h3 class="offer__price"><?php echo wc_price($regular_price) ?></h3>
						<?php } else { ?>
							<h3 class="regular__price"><?php echo wc_price($regular_price) ?></h3>
						<?php } ?>

						<?php if (!empty($sale_price)) { ?>
							<h3 class="sele_price"><?php echo wc_price($sale_price) ?></h3>
						<?php }
						?>
					</div>
					<?php if (!empty($regular_price || $sale_price) & $stock_status == 'instock') { ?>
						<?php
						global $product;
						$pid = $product->get_id();
						?>
						<a href="<?php
						echo do_shortcode('[add_to_cart_url id=' . $pid . ']') ?>" class="primary_btn">
							অর্ডার করুন
						</a>
					<?php } else if ($stock_status == 'outofstock') { ?>
							<a class="primary_btn">
								স্টক আউট
							</a>
						<?php
						} else { ?>
							<a class="primary_btn">
							<?php echo $stock_status ?>
							</a>
						<?php
						} ?>
				</div>
			</div>

			<?php
			do_action('woocommerce_shop_loop');
			// wc_get_template_part( 'content', 'product' );
		}
	}
	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action('woocommerce_after_shop_loop');
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action('woocommerce_no_products_found');
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');

get_footer('shop');
