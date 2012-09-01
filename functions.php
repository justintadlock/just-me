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

	add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );

	add_filter( 'the_content', 'my_link_format_make_clickable', 99 );
}

function my_link_format_make_clickable( $content ) {

	if ( has_post_format( 'link' ) )
		$content = make_clickable( $content );

	return $content;
}

/**
 * Grabs the first URL from the post content of the current post.  This is meant to be used with the link post 
 * format to easily find the link for the post. 
 *
 * @since 0.1.0
 * @return string The link if found.  Otherwise, the permalink to the post.
 *
 * @note This is a modified version of the twentyeleven_url_grabber() function in the TwentyEleven theme.
 * @author wordpressdotorg
 * @copyright Copyright (c) 2012, wordpressdotorg
 * @link http://wordpress.org/extend/themes/twentyeleven
 * @license http://wordpress.org/about/license
 */
function just_me_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', make_clickable( get_the_content() ), $matches ) )
		return get_permalink( get_the_ID() );

	return esc_url_raw( $matches[1] );
}

//add_action( 'admin_menu', 'just_me_wp_widgets_ui_fail' );

function just_me_wp_widgets_ui_fail() {
	/* Fix for the WordPress widgets UI/UX fail. */
	if ( !current_theme_supports( 'widgets' ) )
		remove_submenu_page( 'themes.php', 'widgets.php' );
}












?>