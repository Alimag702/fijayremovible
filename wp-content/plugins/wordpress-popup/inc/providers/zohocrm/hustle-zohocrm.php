<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Hustle_ZohoCRM class
 *
 * @package Hustle
 */

if ( ! class_exists( 'Hustle_ZohoCRM' ) ) :

	/**
	 * Class Hustle_ZohoCRM
	 */
	class Hustle_ZohoCRM extends Hustle_Provider_Abstract implements Hustle_Auth_Provider {

		const SLUG = 'zohocrm';

		/**
		 * Available Zoho data centers.
		 *
		 * @var array
		 */
		const DATA_CENTERS = array(
			'com'    => 'United States (zoho.com)',
			'eu'     => 'Europe (zoho.eu)',
			'in'     => 'India (zoho.in)',
			'com.au' => 'Australia (zoho.com.au)',
			'jp'     => 'Japan (zoho.jp)',
			'com.cn' => 'China (zoho.com.cn)',
		);

		/**
		 * Provider instance.
		 *
		 * @var self|null
		 */
		protected static $instance = null;

		/**
		 * Slug
		 *
		 * @var string
		 */
		protected $slug = 'zohocrm';

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
		protected $title = 'Zoho CRM';

		/**
		 * Single global connection (no multi-account).
		 *
		 * @var bool
		 */
		protected $is_multi_on_global = false;

		/**
		 * Form settings class name.
		 *
		 * @var string
		 */
		protected $form_settings = 'Hustle_ZohoCRM_Form_Settings';

		/**
		 * Form hooks class name.
		 *
		 * @var string
		 */
		protected $form_hooks = 'Hustle_ZohoCRM_Form_Hooks';

		/**
		 * Memoized API instance. Reset to null whenever credentials are saved.
		 *
		 * @var Hustle_ZohoCRM_Api|null
		 */
		private $api_instance = null;

		/**
		 * Whether store_oauth_referer() has already fired this request.
		 *
		 * @var bool
		 */
		private $referer_stored = false;

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->icon_2x = plugin_dir_url( __FILE__ ) . 'images/icon.png';
			$this->logo_2x = plugin_dir_url( __FILE__ ) . 'images/logo.png';

			// Only register the init callback when the incoming request looks like a
			// Zoho OAuth redirect, avoiding the overhead on every other page load.
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( isset( $_GET['action'] ) && 'hustle_zohocrm_oauth_callback' === $_GET['action'] ) {
				add_action( 'init', array( $this->api(), 'process_callback_request' ) );
			}
		}

		/**
		 * Get an API instance initialised with the stored settings.
		 *
		 * @return Hustle_ZohoCRM_Api
		 */
		public function api() {
			if ( null === $this->api_instance ) {
				$settings           = $this->get_settings_values();
				$this->api_instance = new Hustle_ZohoCRM_Api(
					$settings['client_id'] ?? '',
					$settings['client_secret'] ?? '',
					$settings['data_center'] ?? 'com'
				);
			}
			return $this->api_instance;
		}

		/**
		 * Get instance.
		 *
		 * @return self
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Settings wizard steps.
		 *
		 * Returns a single "connected" step when already authorized so that
		 * opening the modal on a connected integration shows the connected view
		 * (with a Disconnect button) rather than the credentials form.
		 *
		 * When not yet connected the full two-step setup wizard is returned:
		 *   Step 0: collect Client ID, Client Secret, Data Center.
		 *   Step 1: OAuth button.
		 *
		 * @return array
		 */
		public function settings_wizards() {
			if ( $this->is_connected() ) {
				return array(
					array(
						'callback' => array( $this, 'authorize_with_zoho' ),
					),
				);
			}

			return array(
				array(
					'callback'     => array( $this, 'configure_credentials' ),
					'is_completed' => array( $this, 'credentials_are_saved' ),
				),
				array(
					'callback'     => array( $this, 'authorize_with_zoho' ),
					'is_completed' => array( $this, 'is_connected' ),
				),
			);
		}

		// -----------------------------------------------------------------------
		// Step 0 — Credentials
		// -----------------------------------------------------------------------

		/**
		 * Render / handle the credentials step.
		 *
		 * @param array  $submitted_data Submitted data.
		 * @param bool   $is_submit      Whether this is a form submission.
		 * @param string $module_id      Module ID.
		 * @return array
		 */
		public function configure_credentials( $submitted_data, $is_submit = false, $module_id = '' ) {
			$has_errors   = false;
			$error_msg    = '';
			$default_data = array(
				'client_id'     => '',
				'client_secret' => '',
				'data_center'   => 'com',
			);

			$current_data = $this->get_current_data( $default_data, $submitted_data );

			if ( $is_submit ) {
				// Validate all three fields are present.
				if ( empty( $current_data['client_id'] ) || empty( $current_data['client_secret'] ) || empty( $current_data['data_center'] ) ) {
					$has_errors = true;
					$error_msg  = __( 'Please fill in all fields.', 'hustle' );
				}

				if ( ! $has_errors && ! array_key_exists( $current_data['data_center'], self::DATA_CENTERS ) ) {
					$has_errors = true;
					$error_msg  = __( 'Please select a valid data center.', 'hustle' );
				}

				if ( ! $has_errors ) {
					$this->save_settings_values(
						array(
							'client_id'     => sanitize_text_field( $current_data['client_id'] ),
							'client_secret' => sanitize_text_field( $current_data['client_secret'] ),
							'data_center'   => sanitize_text_field( $current_data['data_center'] ),
						)
					);
					// Invalidate the memoized instance so the next api() call picks up
					// the credentials that were just written to wp_options.
					$this->api_instance = null;
					return array(
						'html'       => '',
						'has_errors' => false,
					);
				}
			}

			$html = Hustle_Provider_Utils::get_integration_modal_title_markup(
				__( 'Configure Zoho CRM', 'hustle' ),
				sprintf(
					/* translators: link to Zoho API Console */
					__( 'Enter your Zoho Connected App credentials. Create a Server-based Application at <a href="%s" target="_blank" rel="noopener noreferrer">api-console.zoho.com</a> and add the Redirect URI shown below.', 'hustle' ),
					'https://api-console.zoho.com/'
				)
			);

			$options_before = array(
				array(
					'type'     => 'wrapper',
					'elements' => array(
						'label'    => array(
							'type'  => 'label',
							'for'   => 'zohocrm_redirect_uri',
							'value' => __( 'Redirect URI', 'hustle' ),
						),
						'readonly' => array(
							'name'  => 'zohocrm_redirect_uri',
							'id'    => 'zohocrm_redirect_uri',
							'type'  => 'readonly',
							'value' => esc_url( admin_url( 'admin-ajax.php?action=hustle_zohocrm_oauth_callback' ) ),
						),
						'desc'     => array(
							'type'  => 'description',
							'value' => __( 'Copy this URL and add it as the Authorized Redirect URI in your Zoho Connected App settings.', 'hustle' ),
						),
					),
				),
			);

			$html .= Hustle_Provider_Utils::get_html_for_options( $options_before );

			if ( $has_errors ) {
				$html .= Hustle_Provider_Utils::get_html_for_options(
					array(
						array(
							'type'  => 'notice',
							'icon'  => 'warning-alt',
							'value' => esc_html( $error_msg ),
							'class' => 'sui-notice-red',
						),
					)
				);
			}

			$html .= Hustle_Provider_Utils::get_html_for_options(
				array(
					array(
						'type'     => 'wrapper',
						'elements' => array(
							'label'     => array(
								'type'  => 'label',
								'for'   => 'zohocrm_client_id',
								'value' => __( 'Client ID', 'hustle' ),
							),
							'client_id' => array(
								'type'        => 'text',
								'name'        => 'client_id',
								'id'          => 'zohocrm_client_id',
								'value'       => $current_data['client_id'],
								'placeholder' => __( 'Enter Client ID', 'hustle' ),
							),
						),
					),
					array(
						'type'     => 'wrapper',
						'elements' => array(
							'label'         => array(
								'type'  => 'label',
								'for'   => 'zohocrm_client_secret',
								'value' => __( 'Client Secret', 'hustle' ),
							),
							'client_secret' => array(
								'type'        => 'password',
								'name'        => 'client_secret',
								'id'          => 'zohocrm_client_secret',
								'value'       => $current_data['client_secret'],
								'placeholder' => __( 'Enter Client Secret', 'hustle' ),
							),
						),
					),
					array(
						'type'     => 'wrapper',
						'style'    => 'margin-bottom: 0;',
						'elements' => array(
							'label'       => array(
								'type'  => 'label',
								'for'   => 'zohocrm_data_center',
								'value' => __( 'Data Center / Region', 'hustle' ),
							),
							'data_center' => array(
								'type'     => 'select',
								'name'     => 'data_center',
								'id'       => 'zohocrm_data_center',
								'class'    => 'sui-select',
								'value'    => $current_data['data_center'],
								'selected' => $current_data['data_center'],
								'options'  => self::DATA_CENTERS,
							),
						),
					),
				)
			);

			return array(
				'html'       => $html,
				'has_errors' => $has_errors,
				'buttons'    => array(
					'submit' => array(
						'markup' => Hustle_Provider_Utils::get_provider_button_markup(
							__( 'Next', 'hustle' ),
							'sui-button-right',
							'next',
							true
						),
					),
				),
			);
		}

		/**
		 * Check whether credentials have been stored (Step 0 is_completed).
		 *
		 * @param array $submitted_data Submitted data (unused).
		 * @return bool
		 */
		public function credentials_are_saved( $submitted_data = array() ) {
			$settings = $this->get_settings_values();
			return ! empty( $settings['client_id'] )
				&& ! empty( $settings['client_secret'] )
				&& ! empty( $settings['data_center'] );
		}

		// -----------------------------------------------------------------------
		// Step 1 — OAuth
		// -----------------------------------------------------------------------

		/**
		 * OAuth authorization step.
		 *
		 * Shows a "Connect" button when not yet authorized, or a connected notice
		 * with a "Disconnect" button when an active token already exists.
		 *
		 * @param array  $submitted_data Submitted data.
		 * @param bool   $is_submit      Whether this is a form submission.
		 * @param string $module_id      Module ID.
		 * @return array
		 */
		public function authorize_with_zoho( $submitted_data, $is_submit = false, $module_id = '' ) {
			$module_id = (int) $module_id;
			$api       = $this->api();

			if ( $api->is_authorized() ) {
				$settings    = $this->get_settings_values();
				$data_center = $settings['data_center'] ?? 'com';
				$region      = self::DATA_CENTERS[ $data_center ] ?? $data_center;

				$html = Hustle_Provider_Utils::get_integration_modal_title_markup(
					__( 'Configure Zoho CRM', 'hustle' ),
					__( 'You are connected to Zoho CRM. To disconnect, use the button below.', 'hustle' )
				);

				$html .= Hustle_Provider_Utils::get_html_for_options(
					array(
						array(
							'type'  => 'notice',
							'icon'  => 'info',
							/* translators: data center / region label */
							'value' => sprintf( esc_html__( 'You are connected via %s', 'hustle' ), '<strong>' . esc_html( $region ) . '</strong>' ),
							'class' => 'sui-notice-success',
						),
					)
				);

				return array(
					'html'    => $html,
					'buttons' => array(
						'disconnect' => array(
							'markup' => Hustle_Provider_Utils::get_provider_button_markup(
								__( 'Disconnect', 'hustle' ),
								'sui-button-ghost sui-button-center',
								'disconnect',
								true
							),
						),
					),
				);
			}

			if ( $module_id > 0 ) {
				$module = Hustle_Module_Model::new_instance( $module_id );
				$page   = is_wp_error( $module ) ? Hustle_Data::INTEGRATIONS_PAGE : $module->get_wizard_page();
			} else {
				$page = Hustle_Data::INTEGRATIONS_PAGE;
			}

			// Store the post-OAuth referer once per request. The change-guard inside
			// store_oauth_referer() prevents redundant DB writes across requests;
			// this flag prevents even the DB read on repeated renders within one request.
			if ( ! $this->referer_stored ) {
				$api->store_oauth_referer( $module_id, $page );
				$this->referer_stored = true;
			}
			$auth_url = $api->get_authorization_url();

			$html = Hustle_Provider_Utils::get_integration_modal_title_markup(
				__( 'Authenticate with Zoho CRM', 'hustle' ),
				__( 'Authorize Hustle to access your Zoho CRM account to complete the integration.', 'hustle' )
			);

			return array(
				'html'    => $html,
				'buttons' => array(
					'auth' => array(
						'markup' => Hustle_Provider_Utils::get_provider_button_markup(
							__( 'Authorize', 'hustle' ),
							'sui-button-center',
							'connect',
							true,
							false,
							$auth_url
						),
					),
				),
			);
		}

		/**
		 * Provider is considered globally connected when a valid token is stored.
		 *
		 * Overrides the default key-based check in Hustle_Provider_Abstract.
		 *
		 * @param string $multi_id Unused (no multi-account support).
		 * @return bool
		 */
		protected function settings_are_completed( $multi_id = '' ) {
			return $this->api()->is_authorized();
		}

		/**
		 * Remove all stored wp_options rows for this provider.
		 *
		 * Called by the framework when the provider is deactivated / disconnected.
		 */
		public function remove_wp_options() {
			$this->api()->remove_token();
			delete_option( $this->get_settings_options_name() );
		}

		/**
		 * Handle the redirect back from Zoho after OAuth.
		 *
		 * Called by the framework when action=external-redirect and slug=zohocrm
		 * are present in the admin URL (set by store_oauth_referer()).
		 *
		 * @return array Response with 'action', 'status', and 'message' keys.
		 */
		public function process_external_redirect() {
			$status   = filter_input( INPUT_GET, 'status', FILTER_SANITIZE_SPECIAL_CHARS );
			$api      = $this->api();
			$response = array();

			if ( 'success' === $status ) {
				// Zoho reported success, but the token may still be absent if the
				// exchange request failed silently (e.g. a network error inside
				// process_callback_request). Check explicitly before activating.
				if ( ! $api->is_authorized() ) {
					return array(
						'action'  => 'notification',
						'status'  => 'error',
						'message' => esc_html__( 'Zoho returned a success response but no access token was saved. Please try connecting again.', 'hustle' ),
					);
				}

				if ( ! $this->is_active() ) {
					$activated = Hustle_Providers::get_instance()->activate_addon( $this->slug );

					if ( $activated ) {
						$response = array(
							'action'  => 'notification',
							'status'  => 'success',
							/* translators: integration name */
							'message' => sprintf( esc_html__( '%s successfully connected.', 'hustle' ), '<strong>' . esc_html( $this->title ) . '</strong>' ),
						);
					} else {
						$response = array(
							'action'  => 'notification',
							'status'  => 'error',
							'message' => Hustle_Providers::get_instance()->get_last_error_message(),
						);
					}
				}
			} else {
				$response = array(
					'action'  => 'notification',
					'status'  => 'error',
					/* translators: integration name */
					'message' => sprintf( esc_html__( 'Authentication failed! Please check your %s credentials and try again.', 'hustle' ), esc_html( $this->title ) ),
				);
			}

			return $response;
		}

		// -----------------------------------------------------------------------
		// Hustle_Auth_Provider interface
		// -----------------------------------------------------------------------

		/**
		 * Exchange an authorization code for a token (delegates to API).
		 *
		 * @param string $code Authorization code.
		 * @return Hustle_Auth_Token|null
		 */
		public function get_access_token( $code ) {
			return $this->api()->get_access_token( $code );
		}

		/**
		 * Refresh the access token (delegates to API).
		 *
		 * @param string $refresh_token Refresh token.
		 * @return Hustle_Auth_Token|null
		 */
		public function refresh_access_token( $refresh_token ) {
			return $this->api()->refresh_access_token( $refresh_token );
		}

		/**
		 * No legacy 3.0 provider mappings.
		 *
		 * @return array
		 */
		public function get_30_provider_mappings() {
			return array();
		}
	}

endif;
