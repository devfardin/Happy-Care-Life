<?php
/**
 * Sets up theme defaults
 */
function devzet_theme_setup(){



	// update_option( 'thumbnail_size_w', 114 );
	// update_option( 'thumbnail_size_h', 114 );
	// update_option( 'thumbnail_crop', 1 );

	update_option( 'medium_size_w', 300 );
	update_option( 'medium_size_h', 400 );
	update_option( 'medium_crop', 1 );



}
add_action( 'after_setup_theme', 'devzet_theme_setup' );