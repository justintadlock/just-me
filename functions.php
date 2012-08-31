<?php

require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();

add_action( 'after_setup_theme', 'just_me_theme_setup' );

function just_me_theme_setup() {

	$prefix = hybrid_get_prefix();

	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-theme-settings', array( 'about', 'footer' ) );

	//add_theme_support( 'breadcrumb-trail' );
	add_theme_support( 'get-the-image' );
}

?>