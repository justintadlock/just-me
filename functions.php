<?php

require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();

add_action( 'after_setup_theme', 'just_me_theme_setup' );

function just_me_theme_setup() {

	$prefix = hybrid_get_prefix();

	hybrid_set_content_width( 780 );

	//add_theme_support( 'hybrid-core-sidebars', array( 'primary' ) );
	add_theme_support( 'hybrid-core-menus', array( 'primary', 'subsidiary' ) );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-theme-settings', array( 'about', 'footer' ) );

	//add_theme_support( 'breadcrumb-trail' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'cleaner-caption' );


	$dir = trailingslashit( get_template_directory_uri() ) . 'images/backgrounds';
	add_theme_support(
		'random-custom-background', // Wrapper for 'custom-background'.
		array(
			array( 'image' => "{$dir}/bg-yellow-stripe.png" ),
			array( 'image' => "{$dir}/bg-autumnish-stripe.png" ),
			array( 'image' => "{$dir}/bg-plaid-green.png" ),
			array( 'image' => "{$dir}/bg-war-eagle-primary.png" ), // War Eagle! @link http://www.auburn.edu/template/colors.html
			array( 'image' => "{$dir}/bg-war-eagle-secondary.png" ),
			array( 'image' => "{$dir}/bg-fall-leaves-stripe.png" ),
			array( 'image' => "{$dir}/bg-candy-cane-diagonal.png", 'color' => 'fff' ),
			array( 'image' => "{$dir}/bg-by-plaid.png" )
		)
	);

	require_once( trailingslashit( THEME_DIR ) . 'random-custom-background.php' );

	add_theme_support( 'custom-header', array( 'random-default' => true, 'width' => 100, 'height' => 100 ) );

	add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );

	add_action( 'wp_enqueue_scripts', 'just_me_enqueue_scripts' );

	add_filter( 'the_content', 'my_link_format_make_clickable', 99 );

	add_filter( "{$prefix}_default_theme_settings", 'just_me_default_settings' );
}

function just_me_default_settings( $settings ) {

		/* If there is a child theme active, add the [child-link] shortcode to the $footer_insert. */
		if ( is_child_theme() )
			$settings['footer_insert'] = '<p class="credit">' . __( 'Powered by [wp-link], [theme-link], and [child-link].', 'just-me' ) . '</p>';

		/* If no child theme is active, leave out the [child-link] shortcode. */
		else
			$settings['footer_insert'] = '<p class="credit">' . __( 'Powered by [wp-link] and [theme-link].', 'just-me' ) . '</p>';

	return $settings;
}

function just_me_enqueue_scripts() {
	wp_enqueue_script( hybrid_get_prefix(), trailingslashit( THEME_URI ) . 'js/just-me.js', array( 'jquery' ), '20120901', true );
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


function just_me_get_video_embed() {
	global $wp_embed;

	/* If this is not a 'video' post, return. */
	if ( !has_post_format( 'video' ) )
		return false;

	/* Get the post content. */
	$content = get_the_content();

	/* Set the default $embed variable to false. */
	$embed = false;

	/* Use WP's built in WP_Embed class methods to handle the dirty work. */
	add_filter( 'just_me_video_shortcode_embed', array( $wp_embed, 'run_shortcode' ) );
	add_filter( 'just_me_video_auto_embed', array( $wp_embed, 'autoembed' ) );

	/* We don't want to return a link when an embed doesn't work.  Filter this to return false. */
	add_filter( 'embed_maybe_make_link', '__return_false' );

	/* Check for matches against the [embed] shortcode. */
	preg_match_all( '|\[embed.*?](.*?)\[/embed\]|i', $content, $matches, PREG_SET_ORDER );

	/* If matches were found, loop through them to see if we can hit the jackpot. */
	if ( is_array( $matches ) ) {
		foreach ( $matches  as $value ) {

			/* Apply filters (let WP handle this) to get an embedded video. */
			$embed = apply_filters( 'just_me_video_shortcode_embed', '[embed]' . $value[1]. '[/embed]' );

			/* If no embed, continue looping through the array of matches. */
			if ( empty( $embed ) )
				continue;
		}
	}

	/* If no embed at this point and the user has 'auto embeds' turned on, let's check for URLs in the post. */
	if ( empty( $embed ) && get_option( 'embed_autourls' ) ) {
		preg_match_all( '|^\s*(https?://[^\s"]+)\s*$|im', $content, $matches, PREG_SET_ORDER );

		/* If URL matches are found, loop through them to see if we can get an embed. */
		if ( is_array( $matches ) ) {
			foreach ( $matches  as $value ) {

				/* Let WP work its magic with the 'autoembed' method. */
				$embed = apply_filters( 'just_me_video_auto_embed', $value[0] );

				/* If no embed, continue looping through the array of matches. */
				if ( empty( $embed ) )
					continue;
			}
		}
	}

	/* Remove the maybe make link filter. */
	remove_filter( 'embed_maybe_make_link', '__return_false' );

	/* Return the embed. */
	return $embed;
}

add_filter( 'previous_posts_link_attributes', 'just_me_previous_posts_link_attributes' );
add_filter( 'next_posts_link_attributes', 'just_me_next_posts_link_attributes' );

function just_me_previous_posts_link_attributes( $attr ) {

	$attr .= ' rel="prev"';

	return $attr;
}

function just_me_next_posts_link_attributes( $attr ) {

	$attr .= ' rel="next"';

	return $attr;
}

?>