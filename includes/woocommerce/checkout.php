<?php

defined( 'ABSPATH' ) || exit;
// Remove billing fields
function wc_remove_checkout_fields($fields)
{
    unset( $fields['billing']['billing_email'] );
    unset( $fields['billing']['billing_state'] );
    unset( $fields['billing']['billing_last_name'] );
    unset( $fields['billing']['billing_address_2'] );
    unset( $fields['billing']['billing_city'] );
    unset( $fields['billing']['billing_postcode'] );
    unset( $fields['billing']['billing_country'] );
    // Remove order fields
    unset($fields['order']['order_comments']);
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'wc_remove_checkout_fields', 20);

// remove woocommerce checkout different shipping
add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false');


// make required fields flase
function wc_unrequire_wc_phone_field($fields)
{
    $fields['billing_email']['required'] = false;
    $fields['billing_phone']['required'] = true;
    return $fields;
}
add_filter('woocommerce_billing_fields', 'wc_unrequire_wc_phone_field');

// checkout fields Edit
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
function custom_override_checkout_fields($fields)
{
    $fields['billing']['billing_first_name']['label'] = 'আপনার নাম লিখুন';
    $fields['billing']['billing_first_name']['placeholder'] = 'আপনার নাম লিখুন';
    $fields['billing']['billing_address_1']['label'] = 'আপনার সম্পূর্ণ ঠিকানা লিখুন';
    $fields['billing']['billing_address_1']['placeholder'] = 'আপনার সম্পূর্ণ ঠিকানা লিখুন';
    $fields['billing']['billing_phone']['placeholder'] = 'আপনার ফোন নাম্বার লিখুন';
    $fields['billing']['billing_phone']['label'] = 'আপনার ফোন নাম্বার লিখুন';
    return $fields;
}