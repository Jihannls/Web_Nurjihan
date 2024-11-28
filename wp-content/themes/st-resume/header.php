<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php
	if ( function_exists( 'wp_body_open' ) ) {
	    wp_body_open();
	} else {
	    do_action( 'wp_body_open' );
	}
	?>
	<!-- Page Wrapper -->
	<div id="page-wrap">

	<a class="skip-link screen-reader-text" href="#skip-link-target"><?php _e( 'Skip to content', 'st-resume' ); ?></a>

	<header id="site-header" class="site-header header py-4 sticky-header" role="banner">
		<div class="container">

			<div class="row">
				<div class="col-lg-3 col-md-3 align-self-center text-center site-logo">
				<div class="logo text-center text-md-left mb-3 mb-md-0">

					<?php
					if ( has_custom_logo() ) :
						the_custom_logo();
					
					elseif ( get_bloginfo( 'name' ) ) :
					?>
						<h1 class="site-title">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr_e( 'Home', 'st-resume' ); ?>" rel="home">
								<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
							</a>
						</h1>
						<?php if ( get_bloginfo( 'description', 'display' ) ) : ?>
						<p class="site-description">
							<?php echo esc_html( get_bloginfo( 'description', 'display' ) ); ?>
						</p>
						<?php endif; ?>

					<?php endif; ?>
				</div>
				</div>

				<div class="col-lg-6 col-md-5 align-self-center text-center text-lg-right">
					<button class="menu-toggle my-2 py-2 px-3" aria-controls="top-menu" aria-expanded="false" type="button">
						<span aria-hidden="true"><?php esc_html_e( '☰', 'st-resume' ); ?></span>
					</button>
					<nav id="primary-menu" class="close-panal">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'main',
								'container' => 'false',
								'menu_class' => 'st-nav',
							));
						?>
						<button class="close-menu my-2 p-2" type="button">
							<span aria-hidden="true">✖</span>
						</button>
					</nav>
				</div>
			</div>
		</div> 
	</header>