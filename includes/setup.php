<?php
/**
 * Sets up theme defaults
 */
function happy_theme_setup(){

	update_option( 'medium_size_w', 300 );
	update_option( 'medium_size_h', 400 );
	update_option( 'medium_crop', 1 );

	update_option('thumbnail_size_w', 320);
    update_option('thumbnail_size_h', 200);
    update_option('thumbnail_crop', 1);

}
add_action( 'after_setup_theme', 'happy_theme_setup' );