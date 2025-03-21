<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */
defined('ABSPATH') || exit;
do_action('woocommerce_before_cart'); ?>
<?php wp_enqueue_style('happy-woocommerce-cart-style'); ?>


<div class="woocommerce_cart_product_summery_price_wrapper">
    <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
        <div class="cart-summary">
            <h2>পণ্যের তালিকা</h2>
        </div>
        <?php do_action('woocommerce_before_cart_table'); ?>
        <div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents">
            <?php
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                /**
                 * Filter the product name.
                 *
                 * @since 2.1.0
                 * @param string $product_name Name of the product in the cart.
                 * @param array $cart_item The product in the cart.
                 * @param string $cart_item_key Key for the product in the cart.
                 */
                $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    ?>
                    <!-- Product Single item -->
                    <div class="woocommerce-cart-form__cart-item">
                        <div class="woocommerce-cart-form__cart-item_info">
                            <!-- Product thumbnail -->
                            <div class="product-thumbnail">
                                <?php
                                $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                                if (!$product_permalink) {
                                    echo $thumbnail; // PHPCS: XSS ok.
                                } else {
                                    printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                                } ?>
                            </div>
                            <!-- Product title and price -->
                            <div class="woocommerce_cart_items_title_price">
                                <!-- Procut Title -->
                                <div class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                                    <?php
                                    if (!$product_permalink) {
                                        echo wp_kses_post($product_name . '&nbsp;');
                                    } else {
                                        /**
                                         * This filter is documented above.
                                         *
                                         * @since 2.1.0
                                         */
                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                    }

                                    do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                                    // Meta data.
                                    echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.
                            
                                    // Backorder notification.
                                    if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                        echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                    }
                                    ?>
                                </div>

                                <!-- Product Price -->
                                <div class="product-price__remove" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                                    <div>
                                        <?php
                                        echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                        ?>

                                    </div>

                                    <!-- Product remove function -->
                                    <div class="product-remove">
                                        <?php
                                        echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                            'woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"></a>',
                                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                /* translators: %s is the product name */
                                                esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
                                                esc_attr($product_id),
                                                esc_attr($_product->get_sku())
                                            ),
                                            $cart_item_key
                                        );
                                        ?>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                <?php }
            } ?>
            <div class="actions woocommerce_cart__action">
                <?php if (wc_coupons_enabled()) { ?>
                    <div class="coupon">
                        <label for="coupon_code"
                            class="screen-reader-text"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label> <input
                            type="text" name="coupon_code" class="input-text" id="coupon_code" value=""
                            placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" /> <button type="submit"
                            class="button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"
                            name="apply_coupon"
                            value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_html_e('Apply coupon', 'woocommerce'); ?></button>
                        <?php do_action('woocommerce_cart_coupon'); ?>
                    </div>
                <?php } ?>

                <button type="submit"
                    class="button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"
                    name="update_cart"
                    value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?>
                </button>
                <?php do_action('woocommerce_cart_actions'); ?>
                <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
            </div>
        </div>
        <!-- </div> -->
    </form>

    <!-- Cart Summary -->
    <div class="cart-collaterals_total">
        <div class="cart-summary">
            <h2>কার্টের মোট পরিমাণ</h2>
        </div>
        <div class="cart_totals">
            <?php do_action('woocommerce_cart_collaterals'); ?>
        </div>
    </div>
</div>