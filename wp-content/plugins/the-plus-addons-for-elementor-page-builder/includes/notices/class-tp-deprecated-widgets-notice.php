<?php
/**
 * Exit if accessed directly.
 *
 * @link       https://posimyth.com/
 * @since      6.4.16
 *
 * @package    Theplus
 * @subpackage ThePlus/Notices
 * */

namespace Tp\Notices\DeprecatedWidgets;

/**
 * Exit if accessed directly.
 * */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Tp_Deprecated_Widgets_Notice' ) ) {

	/**
	 * This class is used to notify users that deprecated widgets will be
	 * removed in the next release.
	 *
	 * @since 6.4.16
	 */
	class Tp_Deprecated_Widgets_Notice {

		/**
		 * Instance
		 *
		 * @since 6.4.16
		 * @static
		 * @var instance of the class.
		 */
		private static $instance = null;

		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 *
		 * @since 6.4.16
		 *
		 * @return instance of the class.
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @since 6.4.16
		 */
		public function __construct() {
			add_action( 'wp_ajax_theplus_deprecated_widgets_notice_dismiss', array( $this, 'theplus_deprecated_widgets_notice_dismiss' ) );

			if ( ! get_option( 'tpae_deprecated_widgets_notice' ) ) {
				add_action( 'admin_notices', array( $this, 'theplus_deprecated_widgets_notice' ) );
			}
		}

		/**
		 * Deprecated Widgets Removal Notice
		 *
		 * @since 6.4.16
		 */
		public function theplus_deprecated_widgets_notice() {

			$nonce  = wp_create_nonce( 'tpae-deprecated-widgets' );
			$screen = get_current_screen();

			$allowed_parents = array( 'index', 'elementor', 'themes', 'edit', 'plugins', 'theplus_welcome_page' );

			$parent_base = ! empty( $screen->parent_base ) && in_array( $screen->parent_base, $allowed_parents, true );

			if ( ! $parent_base ) {
				return;
			}

			if ( ! function_exists( 'is_plugin_active' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$pro_slug  = 'theplus_elementor_addon/theplus_elementor_addon.php';
			$is_pro_on = is_plugin_active( $pro_slug );

			$pro_item = '';
			if ( $is_pro_on ) {
				$pro_item = '<li>' . esc_html__( 'Design Tool', 'tpebl' ) . ' &mdash; ' . esc_html__( 'Use Elementor\'s native styling controls.', 'tpebl' ) . '</li>';
			}

			echo '<div class="notice notice-warning is-dismissible tpae-notice-show tpae-deprecated-widgets" style="border-left-color: #6660EF;">
					<div class="tp-nexter-werp" style="display: flex; column-gap: 12px; align-items: flex-start; padding: 15px 10px; position: relative; margin-left: 0;">

						<div class="tp-notice-wrap" style="display: flex; padding-top: 14px;">
							<img style="max-width: 28px; max-height: 28px; border-radius: 5px;" src="' . esc_url( L_THEPLUS_URL . 'assets/images/products/theplus-product.png' ) . '" alt="' . esc_attr__( 'The Plus Addons for Elementor', 'tpebl' ) . '" />
						</div>
						<div style="margin: 0 10px; color: #000;">
							<h3 style="margin: 10px 0 7px;">' . esc_html__( 'Heads up: Deprecated Widgets will be Removed in the Next Release', 'tpebl' ) . '</h3>

							<p style="color: #1e1e1e; margin-bottom: 6px;">' . esc_html__( 'The following widgets are marked as DEPRECATED and will be permanently removed in the next release of The Plus Addons for Elementor:', 'tpebl' ) . '</p>

							<ul style="color: #1e1e1e; margin: 6px 0 10px 18px; list-style: disc;">
								<li>' . esc_html__( 'Post Search', 'tpebl' ) . ' &mdash; ' . esc_html__( 'Use the new Search Bar widget instead.', 'tpebl' ) . '</li>
								<li>' . esc_html__( 'Caldera Forms', 'tpebl' ) . ' &mdash; ' . esc_html__( 'The Caldera Forms plugin is no longer maintained.', 'tpebl' ) . '</li>
								' . $pro_item . '
							</ul>

							<p style="color: #1e1e1e;">' . esc_html__( 'If you are still using these widgets on any page, please switch to the suggested replacement before updating to avoid layout or functionality issues.', 'tpebl' ) . '</p>

							<div class="tp-tpae-button" style="margin-top: 10px;">
								<button type="button" class="button got-it" style="margin-right: 10px; color: #6660EF; background: #fff; border: #6660EF 1px solid">' . esc_html__( 'Got it, dismiss', 'tpebl' ) . '</button>
							</div>
						</div>
					</div>
				</div>';

			?>
			<script>
				jQuery(document).on('click', '.tpae-deprecated-widgets .notice-dismiss,.tpae-deprecated-widgets .button.got-it', function(e) {
					e.preventDefault();

					var $notice = jQuery(this).closest('.tpae-deprecated-widgets');

					$notice.fadeTo(100, 0, function () {
						$notice.slideUp(100, function () {
							$notice.remove();
						});
					});

					jQuery.ajax({
						url: ajaxurl,
						type: 'POST',
						data: {
							action: 'theplus_deprecated_widgets_notice_dismiss',
							security: "<?php echo esc_html( $nonce ); ?>",
						},
						success: function(response) {
							jQuery('.tpae-deprecated-widgets').hide();
						}
					});
				});
			</script>
			<?php
		}

		/**
		 * Save dismiss state in database
		 *
		 * @since 6.4.16
		 */
		public function theplus_deprecated_widgets_notice_dismiss() {
			$get_security = ! empty( $_POST['security'] ) ? sanitize_text_field( wp_unslash( $_POST['security'] ) ) : '';

			if ( ! isset( $get_security ) || empty( $get_security ) || ! wp_verify_nonce( $get_security, 'tpae-deprecated-widgets' ) ) {
				die( esc_html__( 'Security checked!', 'tpebl' ) );
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_send_json_error( __( 'You are not allowed to do this action', 'tpebl' ) );
			}

			update_option( 'tpae_deprecated_widgets_notice', true );

			wp_send_json_success();
		}
	}

	Tp_Deprecated_Widgets_Notice::instance();
}
