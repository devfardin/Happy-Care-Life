<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined('ABSPATH') || exit;
?>
    <div class="cart_totals <?php echo (WC()->customer->has_calculated_shipping()) ? 'calculated_shipping' : ''; ?>">

        <!-- Top sub totle price -->
        <div class="cart-subtotal">
            <h3 class="Subtotal_price"> পণ্যের মূল্য: <span>
                    <?php wc_cart_totals_subtotal_html(); ?>
                </span>
            </h3>
        </div>

        <!-- chose Shipping box  -->
        <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()): ?>
            <?php wc_cart_totals_shipping_html(); ?>

        <?php elseif (WC()->cart->needs_shipping() && 'yes' === get_option('woocommerce_enable_shipping_calc')): ?>

            <div class="shipping">
                <th><?php esc_html_e('Shipping', 'woocommerce'); ?></th>
                <div>
                    <?php woocommerce_shipping_calculator(); ?>
                </div>
            </div>
        <?php endif; ?>


        <!-- Total Price -->
        <div class="order-total">
            <h3 class="order_total_price">মোট মূল্য: <span><?php wc_cart_totals_order_total_html(); ?></span> </h3>
        </div>

        <div class="wc-proceed-to-checkout">
            <a class="primary_btn order" href="<?php echo wc_get_checkout_url() ?>">
                অর্ডার করতে ক্লিক করুন
            </a>
        </div>
    </div>