<?php
/**
 * Define the CMB2 metabox for the review form.
 */
add_action('cmb2_admin_init', 'happy_register_notice_form');

function happy_register_notice_form()
{
    $cmb = new_cmb2_box(array(
        'id' => 'happy_notices_metabox',
        'title' => esc_html__('Reviews Management', 'happy'),
        'object_types' => array('options-page'),
        'option_key' => 'happy_notice_options',
        'icon_url' => 'dashicons-megaphone',
        'menu_title' => esc_html__('Add Reviews', 'happy'),
        'capability' => 'manage_options',
        'position' => 20,
    ));

    // Add Group Field for Notices
    $group_field_id = $cmb->add_field(array(
        'id' => 'happy_review_group',
        'type' => 'group',
        'options' => array(
            'group_title' => __('review {#}', 'happy'),
            'add_button' => __('Add review', 'happy'),
            'remove_button' => __('Remove review', 'happy'),
            'sortable' => true,
        ),
    ));
    $cmb->add_group_field($group_field_id, array(
        'name' => 'Product ID',
        'id' => 'review_product_id',
        'type' => 'text',
    ));
    $cmb->add_group_field($group_field_id, array(
        'name' => 'Image',
        'id' => 'review_image',
        'type' => 'file',
    ));
    return $cmb;
}