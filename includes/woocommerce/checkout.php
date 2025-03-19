<?php

defined( 'ABSPATH' ) || exit;
// Remove billing fields
function wc_remove_checkout_fields($fields)
{
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_email']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    // Remove order fields
    unset($fields['order']['order_comments']);
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'wc_remove_checkout_fields', 20);


// make required fields flase
add_filter('woocommerce_billing_fields', 'wc_unrequire_wc_phone_field');
function wc_unrequire_wc_phone_field($fields)
{
    $fields['billing_email']['required'] = false;
    return $fields;
}

// checkout fields placeholder
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
function custom_override_checkout_fields($fields)
{
    $fields['billing']['billing_first_name']['placeholder'] = 'Enter First Name';
    $fields['billing']['billing_last_name']['placeholder'] = 'Enter Last Name';
    $fields['billing']['billing_phone']['placeholder'] = 'Enter Phone Number';
    return $fields;
}


function woocommerce_thankyour_text_message(){
    ?>
    <h2> Payment Received – Course Access Pending Approval </h2>
    <?php 
}
add_action('woocommerce_before_thankyou', 'woocommerce_thankyour_text_message');
