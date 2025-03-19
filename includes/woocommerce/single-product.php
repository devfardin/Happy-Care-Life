<?php
// Ensure WooCommerce is active
if (class_exists('WooCommerce')) {
    // Add custom text above product titles on the single product page
    add_action('woocommerce_single_product_summary', 'custom_single_product_text', 20);
    function custom_single_product_text()
    {
        global $product;
        echo '<div class="custom-product-info">';
        echo '<h1>' . get_the_title() . '</h1>';
        echo '<p class="price">' . $product->get_price_html() . '</p>';
        echo '<p class="description">' . get_the_content() . '</p>';
        echo '</div>';
    }

}