<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Hustle_Newsletter class
 *
 * @package Hustle
 */

if ( ! class_exists( 'Hustle_Newsletter' ) ) :

	/**
	 * Class Hustle_Newsletter
	 */
	class Hustle_Newsletter extends Hustle_Provider_Abstract {

		const SLUG = 'newsletter';

		/**
		 * Provider Instance
		 *
		 * @var self|null
		 */
		protected static $instance = null;

		/**
		 * Provider slug
		 *
		 * @var string
		 */
		protected $slug = 'newsletter';

		/**
		 * Version
		 *
		 * @var string
		 */
		protected $version = '1.0';

		/**
		 * Class
		 *
		 * @var string
		 */
		protected $class = __CLASS__;

		/**
		 * Title
		 *
		 * @var string
		 */
		protected $title = 'Newsletter';

		/**
		 * Is multi on global
		 *
		 * @var bool
		 */
		protected $is_multi_on_global = false;

		/**
		 * Class name of form settings
		 *
		 * @var string
		 */
		protected $form_settings = 'Hustle_Newsletter_Form_Settings';

		/**
		 * Class name of form hooks
		 *
		 * @var string
		 */
		protected $form_hooks = 'Hustle_Newsletter_Form_Hooks';

		/**
		 * Provider constructor.
		 */
		public function __construct() {
			$this->icon_2x = plugin_dir_url( __FILE__ ) . 'images/icon.png';
			$this->logo_2x = plugin_dir_url( __FILE__ ) . 'images/logo.png';
		}

		/**
		 * Get Instance
		 *
		 * @return self|null
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Is active?
		 *
		 * @return bool
		 */
		public function active() {
			$setting_values = $this->get_settings_values();

			return ! empty( $setting_values['active'] );
		}

		/**
		 * Check if the settings are completed
		 *
		 * @param string $multi_id Multi ID.
		 * @return boolean
		 */
		protected function settings_are_completed( $multi_id = '' ) {
			return $this->active() && $this->is_plugin_active();
		}

		/**
		 * Get the wizard callbacks for the global settings.
		 *
		 * @return array
		 */
		public function settings_wizards() {
			return array(
				array(
					'callback'     => array( $this, 'configure' ),
					'is_completed' => array( $this, 'settings_are_completed' ),
				),
			);
		}

		/**
		 * Configure the global settings step.
		 *
		 * @param array $submitted_data Submitted data.
		 * @return array
		 */
		public function configure( $submitted_data ) {
			$has_errors = false;
			$active     = $this->active();
			$is_submit  = isset( $submitted_data['hustle_is_submit'] );

			if ( $is_submit ) {

				$active = ! empty( $submitted_data['active'] );

				if ( ! Hustle_Provider_Utils::is_provider_active( $this->slug ) ) {
					$activated = Hustle_Providers::get_instance()->activate_addon( $this->slug );
					if ( ! $activated ) {
						$error_message = esc_html( $this->provider_connection_falied() );
						$has_errors    = true;
					} else {
						$this->save_settings_values( array( 'active' => $active ) );
					}
				} else {
					$this->save_settings_values( array( 'active' => $active ) );
				}

				if ( ! $has_errors ) {
					return array(
						'html'         => Hustle_Provider_Utils::get_integration_modal_title_markup(
							__( 'Newsletter Added', 'hustle' ),
							__( 'You can now go to your pop-ups, slide-ins and embeds and assign them to this integration', 'hustle' )
						),
						'buttons'      => array(
							'close' => array(
								'markup' => Hustle_Provider_Utils::get_provider_button_markup( __( 'Close', 'hustle' ), 'sui-button-ghost', 'close' ),
							),
						),
						'redirect'     => false,
						'has_errors'   => false,
						'notification' => array(
							'type' => 'success',
							'text' => '<strong>' . $this->get_title() . '</strong> ' . esc_html__( 'Successfully connected', 'hustle' ),
						),
					);
				}
			}

			if ( ! $this->is_plugin_active() ) {
				$has_errors    = true;
				$error_message = sprintf(
					/* translators: 1. opening 'a' tag to the Newsletter plugin page, 2. closing 'a' tag */
					esc_html__( 'Please activate Newsletter plugin to use this integration. If you don\'t have it installed, %1$sdownload it here%2$s.', 'hustle' ),
					'<a href="https://wordpress.org/plugins/newsletter/" target="_blank">',
					'</a>'
				);
			}

			$options = array(
				array(
					'type'  => 'hidden',
					'name'  => 'active',
					'value' => 1,
				),
			);

			$is_edit = $this->is_connected();

			if ( $has_errors ) {
				$step_html = Hustle_Provider_Utils::get_integration_modal_title_markup(
					__( 'Install Newsletter', 'hustle' )
				);

				$error_notice = array(
					'type'  => 'notice',
					'icon'  => 'info',
					'class' => 'sui-notice-error',
					'value' => $error_message,
				);
				array_unshift( $options, $error_notice );
			} else {
				$step_html = Hustle_Provider_Utils::get_integration_modal_title_markup(
					__( 'Configure Newsletter', 'hustle' ),
					$is_edit
						? __( 'Your Newsletter integration is active. You can disconnect it at any time.', 'hustle' )
						: __( 'Connect your Newsletter plugin to start collecting subscribers directly from your pop-ups, slide-ins, and embeds.', 'hustle' )
				);
			}

			$step_html .= Hustle_Provider_Utils::get_html_for_options( $options );

			if ( ! $this->is_plugin_active() ) {
				$buttons = array();
			} elseif ( $is_edit ) {
				$buttons = array(
					'disconnect' => array(
						'markup' => Hustle_Provider_Utils::get_provider_button_markup(
							__( 'Disconnect', 'hustle' ),
							'sui-button-ghost sui-button-center',
							'disconnect',
							true
						),
					),
				);
			} else {
				$buttons = array(
					'connect' => array(
						'markup' => Hustle_Provider_Utils::get_provider_button_markup(
							__( 'Activate', 'hustle' ),
							'sui-button-center',
							'connect',
							true
						),
					),
				);
			}

			return array(
				'html'       => $step_html,
				'buttons'    => $buttons,
				'has_errors' => $has_errors,
			);
		}

		/**
		 * Checks if the Newsletter plugin is active and available.
		 *
		 * @return bool
		 */
		public function is_plugin_active() {
			return class_exists( 'Newsletter' ) && Newsletter::instance();
		}

		/**
		 * Returns all available lists from the Newsletter plugin.
		 *
		 * @return TNP_List[]
		 */
		public function get_lists() {
			return (array) Newsletter::instance()->get_lists();
		}

		/**
		 * Checks if a subscriber with the given email already exists.
		 *
		 * @param string $email Email.
		 * @return bool
		 */
		public function is_member( $email ) {
			$user = Newsletter::instance()->get_user_by_email( $email );
			return (bool) $user;
		}
	}
endif;
