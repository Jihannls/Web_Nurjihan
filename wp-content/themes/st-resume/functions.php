<?php

/* 
** Sets up theme defaults and registers support for various WordPress features
*/

define('IS_ST_FREEMIUM', 'st-resume');

function st_resume_demo_importer_setup() {
		
	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title for us
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages
	add_theme_support( 'post-thumbnails' );

	// Custom Logo
	add_theme_support( 'custom-logo', [
		'height'      => 100,
		'width'       => 350,
		'flex-height' => true,
		'flex-width'  => true,
	] );

	add_theme_support( 'custom-header' );

	// Add theme support for Custom Background.
	add_theme_support( 'custom-background', ['default-color' => ''] );

	// Set the default content width.
	$GLOBALS['content_width'] = 960;

	// This theme uses wp_nav_menu() in one location
	register_nav_menus( array(
		'main' => __( 'Main Menu', 'st-resume' ),
	) );

	// Switch default core markup for search form, comment form, and comments to output valid HTML5
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Gutenberg Embeds
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );

	// Gutenberg Widge Images
	add_theme_support( 'align-wide' );


	// WooCommerce in general.
	add_theme_support( 'woocommerce' );

	// zoom.
	add_theme_support( 'wc-product-gallery-zoom' );
	// lightbox.
	add_theme_support( 'wc-product-gallery-lightbox' );
	// swipe.
	add_theme_support( 'wc-product-gallery-slider' );

	add_editor_style( array( '/assets/css/editor-style.css' ) );
}

add_action( 'after_setup_theme', 'st_resume_demo_importer_setup' );

/*
** Enqueue scripts and styles
*/
function st_resume_demo_importer_scripts() {

	// Theme Stylesheet
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.css', array(),'4.5.0' );

	wp_enqueue_style(
		'st-resume-fontawesome-css',
		get_template_directory_uri() . '/assets/css/fontawesome-all.css',
		array(),'4.5.0'
	);
	
	wp_enqueue_style( 'st-resume-style', get_stylesheet_uri(), array(), '1.0' );

	// Comment reply link
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	wp_enqueue_script('st-resume-custom-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), '1.0', true);
	
	wp_enqueue_script('st-resume-navigation', get_template_directory_uri() . '/assets/js/navigation.js', FALSE, '1.0', TRUE );
}
add_action( 'wp_enqueue_scripts', 'st_resume_demo_importer_scripts' );

function st_resume_enqueue_admin_script() {
    // Enqueue the custom admin script
    wp_enqueue_script('st-resume-custom-admin-script', get_template_directory_uri() . '/assets/js/custom-admin-script.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'st_resume_enqueue_admin_script');

/*
** Notices
*/
require_once get_parent_theme_file_path( '/inc/activation/class-welcome-notice.php' );
require_once get_parent_theme_file_path( '/inc/activation/class-rating-notice.php' );

add_action( 'after_switch_theme', 'st_resume_activation_time');
add_action('after_setup_theme', 'st_resume_activation_time');
    
function st_resume_activation_time() {
	if ( false === get_option( 'st_resume_activation_time' ) ) {
		add_option( 'st_resume_activation_time', strtotime('now') );
	}
}

function st_resume_custom_loader(){
?>
    <div id="st-resume-loader-container">
        <div id="st-resume-custom-loader"></div>
    </div>
<?php
}
add_action('wp_head', 'st_resume_custom_loader');