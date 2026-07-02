<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Hustle_HubSpot class
 *
 * @package Hustle
 */

if ( ! class_exists( 'Hustle_HubSpot' ) ) :

	require_once 'hustle-hubspot-api.php';

	/**
	 * Class Hustle_HubSpot
	 */
	class Hustle_HubSpot extends Hustle_Provider_Abstract {
		const SLUG = 'hubspot';

		/**
		 * Provider Instance
		 *
		 * @since 3.0.5
		 *
		 * @var self|null
		 */
		protected static $instance = null;

		/**
		 * Slug
		 *
		 * @since 3.0.5
		 * @var string
		 */
		protected $slug = 'hubspot';

		/**
		 * Version
		 *
		 * @since 3.0.5
		 * @var string
		 */
		protected $version = '2.0';

		/**
		 * Class
		 *
		 * @since 3.0.5
		 * @var string
		 */
		protected $class = __CLASS__;

		/**
		 * Title
		 *
		 * @since 3.0.5
		 * @var string
		 */
		protected $title = 'HubSpot';

		/**
		 * Is multi on global
		 *
		 * @since 4.0
		 * @var boolean
		 */
		protected $is_multi_on_global = false;

		/**
		 * Class name of form settings
		 *
		 * @var string
		 */
		protected $form_settings = 'Hustle_HubSpot_Form_Settings';

		/**
		 * Class name of form hooks
		 *
		 * @since 4.0
		 * @var string
		 */
		protected $form_hooks = 'Hustle_HubSpot_Form_Hooks';

		/**
		 * API instance
		 *
		 * @var Hustle_HubSpot_Api|Hustle_Hubspot_API_V3|null
		 */
		private $api;

		/**
		 * Provider constructor.
		 */
		public function __construct() {
			$this->icon_2x = plugin_dir_url( __FILE__ ) . 'images/icon.png';
			$this->logo_2x = plugin_dir_url( __FILE__ ) . 'images/logo.png';

			// Instantiate API when instantiating because it's used after getting the authorization.
			$this->init_api();
		}

		/**
		 * Initialize the API instance based on the installed version.
		 * For new installations, it will initialize the v3 API directly,
		 * while for existing users, it will keep the v1 API to avoid any potential issues
		 * until they go through the migration process.
		 *
		 * @return void
		 */
		private function init_api() {
			$auth_provider     = self::resolve_auth_provider( $this->get_settings_values() );
			$installed_version = $this->get_installed_version();
			// TODO: Remove the version check and always return v3 API once we are ready to fully switch to v3.
			// For now, we want to keep using v1 for existing users to avoid any potential issues, while new users will get v3 directly.
			if ( version_compare( $installed_version, '2.0', '<' ) ) {
				$this->api = self::static_api( $auth_provider );
			}

			$this->api = self::static_api_v3( $auth_provider );
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
		 * Check if the settings are completed
		 *
		 * @since 4.0
		 * @param string $multi_id Multi ID.
		 * @return boolean
		 */
		protected function settings_are_completed( $multi_id = '' ) {
			$api          = $this->api();
			$is_authorize = $api && ! $api->is_error && $api->is_authorized();

			return $is_authorize;
		}

		/**
		 * Get API
		 *
		 * @return bool|Hustle_Hubspot_API_V3
		 */
		public function api() {
			if ( $this->api && ! $this->api->is_error ) {
				return $this->api;
			}

			return false;
		}

		/**
		 * Resolve the correct auth provider based on whether a Hub API key is present.
		 * When no Hub key is available, uses the standalone OAuth provider with the
		 * public (api_key) and private (private_key) keys stored in provider settings.
		 *
		 * @param array $settings Settings.
		 * @return Hustle_Auth_Provider
		 */
		private static function resolve_auth_provider( $settings ) {
			if ( Opt_In_Utils::get_hub_api_key() ) {
				return new Hustle_Hubspot_Hub_OAuth();
			}

			$client_id     = ! empty( $settings['api_key'] ) ? $settings['api_key'] : '';
			$client_secret = ! empty( $settings['private_key'] ) ? $settings['private_key'] : '';

			return new Hustle_Hubspot_Non_Hub_Auth( $client_id, $client_secret );
		}

		/**
		 * Get API by static method
		 *
		 * @param Hustle_Auth_Provider $auth_provider Authentication provider to use for the API instance.
		 * @return \Hustle_HubSpot_Api
		 */
		public static function static_api( $auth_provider ) {
			if ( ! class_exists( 'Hustle_HubSpot_Api' ) ) {
				require_once 'opt-in-hubspot-api.php'; }

			$api = new Hustle_HubSpot_Api( $auth_provider );

			return $api;
		}

		/**
		 * Get API v3 by static method
		 *
		 * @param Hustle_Auth_Provider $auth_provider Authentication provider to use for the API instance.
		 * @return \Hustle_Hubspot_API_V3
		 */
		public static function static_api_v3( $auth_provider ) {
			if ( ! class_exists( 'Hustle_Hubspot_API_V3' ) ) {
				require_once 'hustle-hubspot-api-v3.php';
			}

			$api = new Hustle_Hubspot_API_V3( $auth_provider );

			return $api;
		}

		/**
		 * Get the wizard callbacks for the global settings.
		 *
		 * @since 4.0
		 *
		 * @return array
		 */
		public function settings_wizards() {
			if ( ! Opt_In_Utils::get_hub_api_key() ) {

				if ( ! $this->has_api_keys() ) {
					return array(
						array(
							'callback'     => array( $this, 'get_non_hub_connected_integration_modal' ),
							'is_completed' => array( $this, 'has_api_keys' ),
						),
						array(
							'callback'     => array( $this, 'get_hub_connected_integration_modal' ),
							'is_completed' => array( $this, 'is_connected' ),
						),
					);
				}
			}

			return array(
				array(
					'callback'     => array( $this, 'get_hub_connected_integration_modal' ),
					'is_completed' => array( $this, 'is_connected' ),
				),
			);
		}

		/**
		 * Get the connected integration modal content.
		 *
		 * @since 7.8.13
		 *
		 * @return array
		 */
		public function get_connected_integration_modal() {
			$description = __( 'You are already connected to Hubspot. You can disconnect your Hubspot Integration (if you need to) using the button below.', 'hustle' );

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

			$step_html = Hustle_Provider_Utils::get_integration_modal_title_markup( __( 'Connect Hubspot', 'hustle' ), $description );

			$account_details = $this->get_settings_values();

			// Integrations coming from before 4.0.2 don't have this data.
			if ( ! isset( $account_details['user'] ) ) {
				$account_details = $this->save_account_details();
			}

			$account = ! empty( $account_details['hub_domain'] ) ? $account_details['user'] . ' - ' . $account_details['hub_domain'] : $account_details['user'];
			$account = '<b>' . esc_html( $account ) . '</b>';

			$step_html .= Hustle_Provider_Utils::get_html_for_options(
				array(
					array(
						'type'  => 'notice',
						'icon'  => 'info',
						/* translators: account the provider is connected to */
						'value' => sprintf( esc_html__( 'You are connected to %s', 'hustle' ), $account ),
						'class' => 'sui-notice-success',
					),
				)
			);

			$response = array(
				'html'    => $step_html,
				'buttons' => $buttons,
			);

			return $response;
		}

		/**
		 * Get the hub connected integration modal content.
		 *
		 * @since 7.8.13
		 *
		 * @param int $module_id Module ID.
		 * @return array
		 */
		public function get_hub_connected_integration_modal( $module_id ) {
			$is_connected = $this->is_connected();

			if ( $is_connected ) {
				return $this->get_connected_integration_modal();
			}

			$api = $this->api();

			if ( ! $module_id ) {
				$auth_url = $api->get_authorization_uri( 0, true, Hustle_Data::INTEGRATIONS_PAGE );

			} else {

				$module = Hustle_Module_Model::new_instance( $module_id );
				if ( ! is_wp_error( $module ) ) {
					$auth_url = $api->get_authorization_uri( $module_id, true, $module->get_wizard_page() );
				}
			}

			/* translators: Plugin name */
			$description = sprintf( __( 'Connect the Hubspot integration by authenticating it using the button below. Note that you’ll be taken to the Hubspot website to grant access to %s and then redirected back.', 'hustle' ), Opt_In_Utils::get_plugin_name() );

			$buttons = array(
				'auth' => array(
					'markup' => Hustle_Provider_Utils::get_provider_button_markup(
						__( 'Authenticate', 'hustle' ),
						'sui-button-center',
						'',
						true,
						false,
						$auth_url
					),
				),
			);

			$step_html = Hustle_Provider_Utils::get_integration_modal_title_markup( __( 'Connect Hubspot', 'hustle' ), $description );

			$response = array(
				'html'    => $step_html,
				'buttons' => $buttons,
			);

			return $response;
		}

		/**
		 * Get the non-hub connected integration modal content.
		 *
		 * @since 7.8.13
		 *
		 * @param array $submitted_data Submitted data.
		 * @param bool  $is_submit Whether the form is submitted.
		 * @param int   $module_id Module ID.
		 * @return array
		 */
		public function get_non_hub_connected_integration_modal( $submitted_data, $is_submit, $module_id ) {
			if ( $this->is_connected() ) {
				return $this->get_connected_integration_modal();
			}

			if ( $is_submit ) {
				$api_key    = isset( $submitted_data['api_key'] ) ? sanitize_text_field( $submitted_data['api_key'] ) : '';
				$secret_key = isset( $submitted_data['private_key'] ) ? sanitize_text_field( $submitted_data['private_key'] ) : '';

				$this->update_api_keys( $api_key, $secret_key );

				$this->init_api();

				return $this->get_hub_connected_integration_modal( $module_id );
			}

			$documentation_link = '<a href="https://developers.hubspot.com/docs/apps/legacy-apps/private-apps/overview" target="_blank">' . __( 'Hubspot documentation', 'hustle' ) . '</a>';
			/* translators: Plugin name */
			$description = sprintf( __( 'Please enter your HubSpot Client ID and Client Secret. You can retrieve them from your HubSpot account. Check %s', 'hustle' ), $documentation_link );

			$buttons = array(
				'auth' => array(
					'markup' => Hustle_Provider_Utils::get_provider_button_markup(
						__( 'Next', 'hustle' ),
						'sui-button-right',
						'next',
						true,
						false,
						''
					),
				),
			);

			$step_html = Hustle_Provider_Utils::get_integration_modal_title_markup( __( 'Connect Hubspot', 'hustle' ), $description );

			$settings    = $this->get_settings_values();
			$api_key     = ! empty( $settings['api_key'] ) ? $settings['api_key'] : '';
			$private_key = ! empty( $settings['private_key'] ) ? $settings['private_key'] : '';

			$api_instance = $this->api();
			$redirect_uri = method_exists( $api_instance, 'get_redirect_uri' ) ? $api_instance->get_redirect_uri() : '';

			$option = array(
				array(
					'type'     => 'wrapper',
					'elements' => array(
						'label'    => array(
							'type'  => 'label',
							'for'   => 'hubspot_redirect_uri',
							'value' => __( 'Redirect URI', 'hustle' ),
						),
						'readonly' => array(
							'name'  => 'hubspot_redirect_uri',
							'id'    => 'hubspot_redirect_uri',
							'type'  => 'readonly',
							'value' => esc_url( $redirect_uri ),
						),
						'desc'     => array(
							'type'  => 'description',
							'value' => __( 'Add this URL as the redirect / callback URL in your HubSpot app settings.', 'hustle' ),
						),
					),
				),
				array(
					'type'     => 'wrapper',
					'class'    => '',
					'elements' => array(
						'label'   => array(
							'type'  => 'label',
							'for'   => 'api_key',
							'value' => __( 'Client ID', 'hustle' ),
						),
						'api_key' => array(
							'type'        => 'text',
							'name'        => 'api_key',
							'placeholder' => 'e.g. 123abc456def789ghi',
							'value'       => esc_attr( $api_key ),
							'required'    => true,
							'id'          => 'api_key',
						),
					),
				),
				array(
					'type'     => 'wrapper',
					'class'    => '',
					'elements' => array(
						'label'       => array(
							'type'  => 'label',
							'for'   => 'private_key',
							'value' => __( 'Client Secret', 'hustle' ),
						),
						'private_key' => array(
							'type'        => 'text',
							'name'        => 'private_key',
							'placeholder' => 'e.g. 123abc456def789ghi',
							'value'       => esc_attr( $private_key ),
							'required'    => true,
							'id'          => 'private_key',
						),
					),
				),
			);

			$step_html .= Hustle_Provider_Utils::get_html_for_options( $option );

			$response = array(
				'html'    => $step_html,
				'buttons' => $buttons,
			);

			return $response;
		}

		/**
		 * Configure migrated api keys
		 *
		 * @param array $data Data.
		 * @return void
		 */
		public function configure_migrated_api_keys( $data ) {
			if ( ! is_array( $data ) ) {
				return;
			}

			// Activate the provider if not active.
			if (
				$this->is_active() ||
				Hustle_Providers::get_instance()->activate_addon( $this->slug )
			) {

				$api_key    = isset( $data['api_key'] ) ? sanitize_text_field( $data['api_key'] ) : '';
				$secret_key = isset( $data['private_key'] ) ? sanitize_text_field( $data['private_key'] ) : '';
				// Save the keys.
				$this->update_api_keys( $api_key, $secret_key );
			}
		}

		/**
		 * Update api key and secret key.
		 *
		 * @param string $api_key Api key.
		 * @param string $secret_key Secret key.
		 * @return void
		 */
		public function update_api_keys( $api_key, $secret_key ) {
			$settings = $this->get_settings_values();
			if ( ! is_array( $settings ) ) {
				$settings = array();
			}

			$settings['api_key']     = $api_key;
			$settings['private_key'] = $secret_key;

			$this->save_settings_values( $settings );
		}

		/**
		 * Check if API keys are present.
		 *
		 * @return boolean
		 */
		public function has_api_keys() {
			$settings = $this->get_settings_values();

			return ! empty( $settings['api_key'] ) && ! empty( $settings['private_key'] );
		}

		/**
		 * Remove wp_option rows.
		 */
		public function remove_wp_options() {
			$api = $this->api();
			$api->remove_wp_options();
		}

		/**
		 * Migrate 3.0
		 *
		 * @param object $module Module.
		 * @param object $old_module Old Module.
		 * @return boolean
		 */
		public function migrate_30( $module, $old_module ) {
			$migrated = parent::migrate_30( $module, $old_module );
			if ( ! $migrated ) {
				return false;
			}

			/*
			 * Our regular migration would've saved the provider settings in a format that's incorrect for HubSpot
			 *
			 * Let's fix that now.
			 */
			$module_provider_settings = $module->get_provider_settings( $this->get_slug() );
			if ( ! empty( $module_provider_settings ) ) {
				// At provider level don't store anything (at least not in the regular option).
				delete_option( $this->get_settings_options_name() );

				// selected_global_multi_id not needed at module level.
				unset( $module_provider_settings['selected_global_multi_id'] );
				$module->set_provider_settings( $this->get_slug(), $module_provider_settings );
			}

			return $migrated;
		}

		/**
		 * Get 3.0 provider mappings
		 *
		 * @return type
		 */
		public function get_30_provider_mappings() {
			return array();
		}

		/**
		 * Add custom fields
		 *
		 * @param array $fields Fields.
		 * @return type
		 */
		public function add_custom_fields( $fields ) {
			$api   = $this->api();
			$error = false;

			if ( $api && ! $api->is_error ) {
				// Get the existing fields.
				$props = $api->get_properties();

				$new_fields = array();
				foreach ( $fields as $field ) {
					if ( ! isset( $props[ $field['name'] ] ) ) {
						$new_fields[] = $field;
					}
				}

				foreach ( $new_fields as $field ) {
					// Add the new field as property.
					$property = array(
						'name'      => $field['name'],
						'label'     => $field['label'],
						'type'      => 'text' === $field['type'] ? 'string' : $field['type'],
						'fieldType' => $field['type'],
						'groupName' => 'contactinformation',
					);

					if ( ! $api->add_property( $property ) ) {
						$error = true;
					}
				}
			}

			if ( ! $error ) {
				return array(
					'success' => true,
					'field'   => $fields,
				);
			} else {
				return array(
					'error' => true,
					'code'  => 'cannot_create_custom_field',
				);
			}
		}

		/**
		 * Check if migration is required.
		 *
		 * @return boolean
		 */
		public function migration_required() {
			$installed_version = $this->get_installed_version();

			return version_compare( $installed_version, '2.0', '<' );
		}

		/**
		 * Save the account details.
		 *
		 * @since 4.0.2
		 * @return array
		 */
		private function save_account_details() {

			$api             = $this->api();
			$account_details = $api->get_access_token_information();
			$account_data    = array();

			if ( isset( $account_details->response ) && 400 <= $account_details->response['code'] ) {
				Hustle_Providers_Utils::maybe_log( $this->title, __METHOD__, $account_details->response['code'], $account_details['response']['message'] );

			} else {
				$settings = $this->get_settings_values();

				$account_data = array(
					'user'       => $account_details->user,
					'hub_domain' => $account_details->hub_domain,
				);

				// Save api keys in the account details for non-hub users,
				// so we can use them later to re-authenticate when needed.
				$settings = array_merge( $settings, $account_data );

				$this->save_settings_values( $settings );
			}

			return $account_data;
		}

		/**
		 * Process the request after coming from authentication.
		 *
		 * @since 4.0.2
		 * @return array
		 */
		public function process_external_redirect() {

			$status   = filter_input( INPUT_GET, 'status', FILTER_SANITIZE_SPECIAL_CHARS );
			$response = array();

			$api           = $this->api();
			$is_authorized = $api && ! $api->is_error && $api->is_authorized();

			// API Auth was successful.
			if ( 'success' === $status && $is_authorized ) {

				$providers_instance = Hustle_Providers::get_instance();

				if ( ! $this->is_active() ) {

					$activated = $providers_instance->activate_addon( $this->slug );

					// Provider successfully activated.
					if ( $activated ) {

						$response = array(
							'action'  => 'notification',
							'status'  => 'success',
							'message' => /* translators: integration name */ sprintf( esc_html__( '%s successfully connected.', 'hustle' ), '<strong>' . esc_html( $this->title ) . '</strong>' ),
						);

						$this->save_account_details();

					} else { // Provider couldn't be activated.

						$response = array(
							'action'  => 'notification',
							'status'  => 'error',
							'message' => $providers_instance->get_last_error_message(),
						);
					}
				}
			} else { // API Auth failed.

				$response = array(
					'action'  => 'notification',
					'status'  => 'error',
					/* translators: integration name */
					'message' => sprintf( esc_html__( 'Authentication failed! Please check your %s credentials and try again.', 'hustle' ), esc_html( $this->title ) ),
				);

			}

			return $response;
		}

		/**
		 * Process data migration.
		 *
		 * @return bool|WP_Error
		 */
		public function process_data_migration() {
			$settings = $this->get_settings_values();

			if ( empty( $settings['lists'] ) ) {
				return false;
			}

			$auth_provider = self::resolve_auth_provider( $settings );
			$api           = $this->static_api_v3( $auth_provider );
			$new_list      = array();

			$legacy_lists = array_keys( $settings['lists'] );
			$mappings     = $api->get_legacy_list_mappings( $legacy_lists );

			$missing_lists = array();
			if ( is_wp_error( $mappings ) ) {
				return new WP_Error(
					'provider_error',
					esc_html__( 'Invalid response received while migrating HubSpot lists.', 'hustle' )
				);
			} else {
				$missing_lists = $mappings->{'missingLegacyListIds'};
			}

			foreach ( $mappings->{'legacyListIdsToIdsMapping'} as $mapping ) {
				$list   = $settings['lists'][ $mapping->{'legacyListId'} ];
				$new_id = $mapping->{'listId'};

				$new_list[ $new_id ] = $list;
			}

			foreach ( $missing_lists as $missing_list ) {
				// Keep the old list ID for the missing lists, so at least the existing subscribers in those lists can be migrated to the new API version.
				$new_list[ $missing_list ] = $settings['lists'][ $missing_list ];
			}

			$settings['lists'] = $new_list;

			$this->save_settings_values( $settings );
			update_option( $this->get_version_options_name(), $this->version );

			if ( ! empty( $missing_lists ) ) {

				$list_names     = array_intersect_key( $settings['lists'], array_flip( $missing_lists ) );
				$invalid_fields = implode( ', ', $list_names );

				return new WP_Error(
					'provider_error',
					esc_html(
						sprintf(
							/* translators: %s: List of missed lists */
							esc_html__( 'These lists were not found in your HubSpot account: %s', 'hustle' ),
							esc_html( $invalid_fields )
						)
					)
				);
			}

			return true;
		}
	}

endif;
