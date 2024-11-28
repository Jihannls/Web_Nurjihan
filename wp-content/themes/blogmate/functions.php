<?php //phpcs:ignore
/**
 * Theme functions and definitions.
 *
 * @package Blogmate
 * @author  Peregrine Themes
 * @since   1.0.0
 */

/**
 * Main Blogmate class.
 *
 * @since 1.0.0
 */
final class Blogmate {

	/**
	 * Singleton instance of the class.
	 *
	 * @since 1.0.0
	 * @var object
	 */
	private static $instance;

	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Blogmate ) ) {
			self::$instance = new Blogmate();
			self::$instance->includes();
			// Hook now that all of the Blogmate stuff is loaded.
			do_action( 'blogmate_loaded' );
		}
		return self::$instance;
	}

	/**
	 * Primary class constructor.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'blogmate_styles' ) );
	}

	/**
	 * Include files.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function includes() {
		require get_stylesheet_directory() . '/inc/customizer/default.php';
		require get_stylesheet_directory() . '/inc/customizer/customizer.php';
	}

	/**
	 * Recommended way to include parent theme styles.
	 * (Please see http://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme)
	 */
	function blogmate_styles() {
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'parent-style' ) );
	}
}

/**
 * The function which returns the one Blogmate instance.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $blogmate = blogmate(); ?>
 *
 * @since 1.0.0
 * @return object
 */
function blogmate() {
	return Blogmate::instance();
}

blogmate();
