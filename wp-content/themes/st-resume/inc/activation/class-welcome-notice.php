<?php
/**
 * Welcome Notice class.
 */
class ST_Resume_Welcome_Notice {

	/**
	** Constructor.
	*/
	public function __construct() {
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		// Render Notice
		add_action( 'admin_notices', [$this, 'st_resume_render_notice'] );

		// Enque AJAX Script
		add_action( 'admin_enqueue_scripts', [$this, 'st_resume_admin_enqueue_scripts'], 5 );

		// Dismiss
		add_action( 'admin_enqueue_scripts', [$this, 'st_resume_notice_enqueue_scripts'], 5 );
		add_action( 'wp_ajax_sb_st_resume_dismissed_handler', [$this, 'st_resume_dismissed_handler'] );

		// Reset
		add_action( 'switch_theme', [$this, 'st_resume_reset_notices'] );
		add_action( 'after_switch_theme', [$this, 'st_resume_reset_notices'] );

		// Install Plugins
		add_action( 'wp_ajax_stresume_install_activate_elementor', [$this, 'st_resume_install_activate_elementor'] );
		add_action( 'wp_ajax_nopriv_stresume_install_activate_elementor', [$this, 'st_resume_install_activate_elementor'] );
		add_action( 'wp_ajax_stresume_install_activate_st_demo_importer', [$this, 'st_resume_install_activate_st_demo_importer'] );
		add_action( 'wp_ajax_nopriv_stresume_install_activate_st_demo_importer', [$this, 'st_resume_install_activate_st_demo_importer'] );

		add_action( 'wp_ajax_st_resume_cancel_elementor_redirect', [$this, 'st_resume_cancel_elementor_redirect'] );
	}

	public function st_resume_cancel_elementor_redirect() {
		exit;
	}

	/**
	** Get plugin status.
	*/
	public function st_resume_get_plugin_status( $plugin_path ) {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}
	
		if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin_path ) ) {
			return 'not_installed';
		} else {
			$plugin_updates = get_site_transient( 'update_plugins' );
			$plugin_needs_update = is_object($plugin_updates) && isset($plugin_updates->response) && is_array($plugin_updates->response) 
				? array_key_exists($plugin_path, $plugin_updates->response) 
				: false;
	
			if ( in_array( $plugin_path, (array) get_option( 'active_plugins', array() ), true ) || is_plugin_active_for_network( $plugin_path ) ) {
				return $plugin_needs_update ? 'active_update' : 'active';
			} else {
				return $plugin_needs_update ? 'inactive_update' : 'inactive';
			}    
		}
	}
	

	/**
	** Install a plugin.
	*/
	public function st_resume_install_plugin( $plugin_slug ) {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		if ( ! function_exists( 'plugins_api' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		}
		if ( ! class_exists( 'WP_Upgrader' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}

		if ( false === filter_var( $plugin_slug, FILTER_VALIDATE_URL ) ) {
			$api = plugins_api(
				'plugin_information',
				[
					'slug'   => $plugin_slug,
					'fields' => [
						'short_description' => false,
						'sections'          => false,
						'requires'          => false,
						'rating'            => false,
						'ratings'           => false,
						'downloaded'        => false,
						'last_updated'      => false,
						'added'             => false,
						'tags'              => false,
						'compatibility'     => false,
						'homepage'          => false,
						'donate_link'       => false,
					],
				]
			);

			$download_link = $api->download_link;
		} else {
			$download_link = $plugin_slug;
		}

		// Use AJAX upgrader skin instead of plugin installer skin.
		// ref: function wp_ajax_install_plugin().
		$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );

		$install = $upgrader->install( $download_link );

		if ( false === $install ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	** Update a plugin.
	*/
	public function st_resume_update_plugin( $plugin_path ) {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		if ( ! function_exists( 'plugins_api' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		}
		if ( ! class_exists( 'WP_Upgrader' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}

		// Use AJAX upgrader skin instead of plugin installer skin.
		// ref: function wp_ajax_install_plugin().
		$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );

		$upgrade = $upgrader->upgrade( $plugin_path );

		if ( false === $upgrade ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	** Update all plugins.
	*/
	public function st_resume_update_all_plugins() {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		if ( ! function_exists( 'plugins_api' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
		}
		if ( ! class_exists( 'WP_Upgrader' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		}

		// Use AJAX upgrader skin instead of plugin installer skin.
		// ref: function wp_ajax_install_plugin().
		$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );

		$upgrade = $upgrader->bulk_upgrade([
			'elementor/elementor.php',
			'st-demo-importer/st-demo-importer.php'
		]);

		if ( false === $upgrade ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	** Activate a plugin.
	*/
	public function st_resume_activate_plugin( $plugin_path ) {

		if ( ! current_user_can( 'install_plugins' ) ) {
			return false;
		}

		$activate = activate_plugin( $plugin_path, '', false, false ); // TODO: last argument changed to false instead of true

		if ( is_wp_error( $activate ) ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	** Install Elementor.
	*/
	public function st_resume_install_activate_elementor() {
		check_ajax_referer( 'nonce', 'nonce' );

		if ( ! current_user_can( 'install_plugins' ) ) {
			wp_send_json_error( esc_html__( 'Insufficient permissions to install the plugin.', 'st-resume' ) );
			wp_die();
		}

		$elementor_status = $this->st_resume_get_plugin_status( 'elementor/elementor.php' );
		$actions_data = [];

		if ( 'not_installed' === $elementor_status ) {
			$this->st_resume_install_plugin( 'elementor' );
			$this->st_resume_activate_plugin( 'elementor/elementor.php' );
		} else {
			if ( 'inactive' === $elementor_status ) {
				$this->st_resume_activate_plugin( 'elementor/elementor.php' );
			} elseif ( 'inactive_update' === $elementor_status || 'active_update' === $elementor_status ) {
				$st_resume_demo_impoter_status = $this->st_resume_get_plugin_status( 'st-demo-importer/st-demo-importer.php' );
				
				if ( 'inactive_update' === $st_resume_demo_impoter_status || 'active_update' === $st_resume_demo_impoter_status ) {
					$this->st_resume_update_all_plugins();
					$this->st_resume_activate_plugin( 'elementor/elementor.php' );
					$this->st_resume_activate_plugin( 'st-demo-importer/st-demo-importer.php' );
					$actions_data['plugins_updated'] = true;
				} else {
					$this->st_resume_update_plugin( 'elementor/elementor.php' );
					$this->st_resume_activate_plugin( 'elementor/elementor.php' );
				}
			}
		}

		if ( 'active' === $this->st_resume_get_plugin_status( 'elementor/elementor.php' ) ) {
			wp_send_json_success( $actions_data );
		}

		wp_send_json_error( esc_html__( 'Failed to initialize or activate importer plugin.', 'st-resume' ) );

		wp_die();
	}

	/**
	** Install ST Demo Impoter.
	*/
	public function st_resume_install_activate_st_demo_importer() {
		check_ajax_referer( 'nonce', 'nonce' );

		if ( ! current_user_can( 'install_plugins' ) ) {
			wp_send_json_error( esc_html__( 'Insufficient permissions to install the plugin.', 'st-resume' ) );
			wp_die();
		}

		$plugin_status = $this->st_resume_get_plugin_status( 'st-demo-importer/st-demo-importer.php' );

		if ( 'not_installed' === $plugin_status ) {
			$this->st_resume_install_plugin( 'st-demo-importer' );
			$this->st_resume_activate_plugin( 'st-demo-importer/st-demo-importer.php' );

		} else {
			if ( 'inactive' === $plugin_status ) {
				$this->st_resume_activate_plugin( 'st-demo-importer/st-demo-importer.php' );
			} elseif ( 'inactive_update' === $plugin_status || 'active_update' === $plugin_status ) {
				$this->st_resume_update_plugin( 'st-demo-importer/st-demo-importer.php' );
				$this->st_resume_activate_plugin( 'st-demo-importer/st-demo-importer.php' );
			}
		}

		if ( 'active' === $this->st_resume_get_plugin_status( 'st-demo-importer/st-demo-importer.php' ) ) {
			wp_send_json_success();
		}

		wp_send_json_error( esc_html__( 'Failed to initialize or activate importer plugin.', 'st-resume' ) );

		wp_die();
	}

	/**
	** Render Notice
	*/
	public function st_resume_render_notice() {
		global $pagenow;

		$screen = get_current_screen();
		
		if ( 'stdemoimporter-wizard' !== $screen->parent_base ) {
			$transient_name = sprintf( '%s_activation_notice', get_template() );

			if ( ! get_transient( $transient_name ) ) {
				?>
				<div class="notice notice-success is-dismissible st-resume-notice" data-notice="<?php echo esc_attr( $transient_name ); ?>">
					<button type="button" class="notice-dismiss"></button>

					<?php $this->st_resume_render_notice_content(); ?>
				</div>
				<?php
			}
		}
	}

	/**
	** Render Notice Content
	*/
	public function st_resume_render_notice_content() {
		$action = 'install-activate';
		$freemius_passed = 'false';
		$redirect_url = 'admin.php?page=stdemoimporter-wizard';
		$elementor_status = $this->st_resume_get_plugin_status( 'elementor/elementor.php' );
		$st_demo_importer_status = $this->st_resume_get_plugin_status( 'st-demo-importer/st-demo-importer.php' );
		
		if ( 'active' === $elementor_status && 'active' === $st_demo_importer_status ) {
			$action = 'default';
		}

		$screen = get_current_screen();
		$flex_attr = '';
		$display_attr = 'display: inline-block !important';
		
		if ( 'toplevel_page_stdemoimporter-wizard' === $screen->id ) {
			$flex_attr = 'display:-webkit-box;display:-ms-flexbox;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center';
			$display_attr = 'display: none !important';
		} ?>

		<div class="st-resume-welcome-message" style="<?php echo esc_attr($flex_attr); ?>">
			<h1 style="<?php echo esc_attr($display_attr); ?>"><?php esc_html_e('Welcome to ST Resume', 'st-resume'); ?></h1>
			<p>
			The ST Resume WordPress theme is ideal for developers, designers, and programmers. It offers creative portfolio layouts, personalization options, a testimonial section, banner, and social media integration. Designed for job seekers, it's elegant, mobile-friendly, and responsive on any device. With Elementor's drag-and-drop builder, anyone can create pages or blogs without coding. Extra features include Google Fonts, cross-browser compatibility, clean code, and widgets, making it a modern and professional choice for any profession.
			</p>
			<div class="st-resume-action-buttons">
				<a href="<?php echo esc_url(admin_url($redirect_url)); ?>" class="button button-primary" data-action="<?php echo esc_attr($action); ?>" data-freemius="<?php echo esc_attr($freemius_passed); ?>">
					<?php echo sprintf( esc_html__( 'Get Started with St Demo Importer %s', 'st-resume' ), '<span class="dashicons dashicons-arrow-right-alt"></span>' ); ?>
				</a>
				<a href="<?php echo esc_url('https://striviothemes.com/themes/resume-wordpress-theme/'); ?>" class="button button-primary st-resume-buy-now" target="_blank">
					<?php echo sprintf( esc_html__( 'Buy Now', 'st-resume' ), '<span class="dashicons dashicons-arrow-right-alt"></span>' ); ?>
				</a>
				<a href="<?php echo esc_url('https://striviothemes.com/demo/st-resume-pro'); ?>" class="button button-primary st-resume-view-demo" target="_blank">
					<?php echo sprintf( esc_html__( 'Demo', 'st-resume' ), '<span class="dashicons dashicons-arrow-right-alt"></span>' ); ?>
				</a>
			</div>
		</div>

		<div class="image-wrap admin-banner-img">
			<img src="<?php echo esc_url(get_template_directory_uri()) . '/inc/activation/img/welcome-banner.webp'; ?>" alt="">
		</div>
		<?php
	}

	/**
	** Reset Notice.
	*/
	public function st_resume_reset_notices() {
		delete_transient( sprintf( '%s_activation_notice', get_template() ) );
	}

	/**
	** Dismissed handler
	*/
	public function st_resume_dismissed_handler() {
        check_ajax_referer('sb_dismiss_notice_nonce', 'nonce');

        if ( ! current_user_can('administrator') ) {
            return;
        }

		if ( isset( $_POST['notice'] ) ) {
			set_transient( sanitize_text_field( wp_unslash( $_POST['notice'] ) ), true, 0 );
		}
	}

	/**
	** Notice Enqunue Scripts
	*/
	public function st_resume_notice_enqueue_scripts( $page ) {
		
		wp_enqueue_script( 'jquery' );

        // Generate a nonce
        $nonce = wp_create_nonce('sb_dismiss_notice_nonce');

		ob_start();
		?>
		<script>
			jQuery(function($) {
				$( document ).on( 'click', '.st-resume-notice .notice-dismiss', function () {
					jQuery.post( 'ajax_url', {
						action: 'sb_st_resume_dismissed_handler',
						notice: $( this ).closest( '.st-resume-notice' ).data( 'notice' ),
                        nonce: '<?php echo $nonce; ?>', // Pass the nonce here
					});
					$( '.st-resume-notice' ).hide();
				} );
			});
		</script>
		<?php
		$script = str_replace( 'ajax_url', admin_url( 'admin-ajax.php' ), ob_get_clean() );

		wp_add_inline_script( 'jquery', str_replace( ['<script>', '</script>'], '', $script ) );
	}

	/**
	** Register scripts and styles for welcome notice.
	*/
	public function st_resume_admin_enqueue_scripts( $page ) {
		// Enqueue Scripts
		wp_enqueue_script( 'st-resume-welcome-notic-js', get_template_directory_uri() . '/inc/activation/js/welcome-notice.js', ['jquery'], false, true );

		wp_localize_script( 'st-resume-welcome-notic-js', 'st_resume_localize', [
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'elementor_nonce' => wp_create_nonce( 'nonce' ),
			'st_demo_importer_nonce' => wp_create_nonce( 'nonce' ),
			'failed_message' => esc_html__( 'Something went wrong, contact support.', 'st-resume' ),
		] );

		// Enqueue Styles.
		wp_enqueue_style( 'st-resume-welcome-notic-css', get_template_directory_uri() . '/inc/activation/css/welcome-notice.css' );
	}

}

new ST_Resume_Welcome_Notice();