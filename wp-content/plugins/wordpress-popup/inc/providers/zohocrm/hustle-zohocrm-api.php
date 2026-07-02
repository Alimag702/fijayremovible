<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Hustle_ZohoCRM_Api class
 *
 * @package Hustle
 */

if ( ! class_exists( 'Hustle_ZohoCRM_Api' ) ) :

	/**
	 * Class Hustle_ZohoCRM_Api
	 */
	class Hustle_ZohoCRM_Api {

		/**
		 * OAuth scopes required by this integration.
		 */
		const OAUTH_SCOPE = 'ZohoCRM.modules.leads.ALL,ZohoCRM.modules.contacts.ALL,ZohoCRM.settings.fields.ALL,ZohoCRM.settings.tags.ALL';

		/**
		 * Key for storing the post-OAuth referer URL.
		 */
		const REFERER_OPTION = 'hustle_zohocrm_oauth_referer';

		/**
		 * Key for storing OAuth tokens (access_token, refresh_token, expires_at).
		 */
		const TOKEN_OPTION = 'hustle_zohocrm_token';

		/**
		 * Zoho Connected App Client ID.
		 *
		 * @var string
		 */
		protected $client_id;

		/**
		 * Zoho Connected App Client Secret.
		 *
		 * @var string
		 */
		protected $client_secret;

		/**
		 * Zoho data-center TLD (e.g. "com", "eu", "in").
		 *
		 * @var string
		 */
		protected $data_center;

		/**
		 * Whether the last API call encountered an error.
		 *
		 * @var bool
		 */
		public $is_error = false;

		/**
		 * Human-readable description of the last error.
		 *
		 * @var string
		 */
		public $error_message = '';

		/**
		 * Constructor.
		 *
		 * @param string $client_id     Zoho Connected App Client ID.
		 * @param string $client_secret Zoho Connected App Client Secret.
		 * @param string $data_center   Zoho data-center TLD.
		 */
		public function __construct( $client_id = '', $client_secret = '', $data_center = 'com' ) {
			$this->client_id     = $client_id;
			$this->client_secret = $client_secret;
			$this->data_center   = $data_center;
		}

		// -----------------------------------------------------------------------
		// Helpers
		// -----------------------------------------------------------------------

		/**
		 * Returns the active data-center TLD (e.g. "com", "eu", "in").
		 *
		 * @return string
		 */
		protected function get_dc() {
			return $this->data_center ? $this->data_center : 'com';
		}

		/**
		 * Base URL of the Zoho accounts / OAuth service for the current DC.
		 *
		 * @return string
		 */
		public function get_auth_base_url() {
			return 'https://accounts.zoho.' . $this->get_dc() . '/oauth/v2/';
		}

		/**
		 * Base URL of the Zoho CRM API for the current DC.
		 *
		 * @return string
		 */
		public function get_api_base_url() {
			return 'https://www.zohoapis.' . $this->get_dc() . '/crm/v8/';
		}

		// -----------------------------------------------------------------------
		// OAuth — URL builder
		// -----------------------------------------------------------------------

		/**
		 * The redirect URI registered in the user's Zoho Connected App.
		 *
		 * @return string
		 */
		public function get_redirect_uri() {
			return admin_url( 'admin-ajax.php?action=hustle_zohocrm_oauth_callback' );
		}

		/**
		 * Build the Zoho OAuth authorization URL.
		 *
		 * @return string
		 */
		public function get_authorization_url() {
			// State doubles as CSRF nonce; verified in process_callback_request().
			$state = wp_create_nonce( 'hustle_zohocrm_oauth' );

			return add_query_arg(
				array(
					'scope'         => rawurlencode( self::OAUTH_SCOPE ),
					'client_id'     => rawurlencode( $this->client_id ),
					'response_type' => 'code',
					'access_type'   => 'offline', // Required to receive a refresh_token alongside the access_token.
					'redirect_uri'  => rawurlencode( $this->get_redirect_uri() ),
					'state'         => $state,
				),
				$this->get_auth_base_url() . 'auth'
			);
		}

		/**
		 * Store the post-OAuth redirect destination in wp_options.
		 *
		 * Writes only when the value actually changes, preventing redundant DB
		 * writes on repeated renders of the same step.
		 * Call this once just before presenting the OAuth button to the user.
		 *
		 * @param int    $module_id Module ID (0 for global integrations page).
		 * @param string $page      Hustle admin page slug to return to after OAuth.
		 */
		public function store_oauth_referer( $module_id = 0, $page = Hustle_Data::INTEGRATIONS_PAGE ) {
			$module_id      = (int) $module_id;
			$referer_params = array(
				'page'   => $page,
				'action' => 'external-redirect',
				'slug'   => Hustle_ZohoCRM::SLUG,
				'nonce'  => wp_create_nonce( 'hustle_provider_external_redirect' ),
			);
			if ( $module_id > 0 ) {
				$referer_params['id']      = $module_id;
				$referer_params['section'] = 'integrations';
			}
			$referer = add_query_arg( $referer_params, admin_url( 'admin.php' ) );

			// Avoid a DB write when nothing has changed (e.g. on repeated renders).
			if ( get_option( self::REFERER_OPTION ) !== $referer ) {
				update_option( self::REFERER_OPTION, $referer, false );
			}
		}

		// -----------------------------------------------------------------------
		// OAuth — callback handler
		// -----------------------------------------------------------------------

		/**
		 * Listen for the Zoho OAuth callback on the WordPress init hook.
		 *
		 * Called via add_action('init', ...) registered in Hustle_ZohoCRM::__construct().
		 * Validates the state nonce, exchanges the code for tokens, then redirects
		 * back to the stored admin referer with ?status=success|error.
		 */
		public function process_callback_request() {
			// phpcs:disable WordPress.Security.NonceVerification.Recommended
			// We intentionally read $_GET before verifying the nonce so we can bail early
			// on unrelated requests. The actual nonce check follows immediately after.
			if ( ! isset( $_GET['action'] ) || 'hustle_zohocrm_oauth_callback' !== $_GET['action'] ) {
				return;
			}
			// phpcs:enable

			$state = isset( $_GET['state'] ) ? sanitize_text_field( wp_unslash( $_GET['state'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( ! wp_verify_nonce( $state, 'hustle_zohocrm_oauth' ) ) {
				wp_die( esc_html__( 'Security check failed. Please try connecting again.', 'hustle' ) );
			}

			$code   = isset( $_GET['code'] ) ? sanitize_text_field( wp_unslash( $_GET['code'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$status = ( ! empty( $code ) && $this->exchange_code( $code ) ) ? 'success' : 'error';

			$referer = get_option( self::REFERER_OPTION );
			delete_option( self::REFERER_OPTION ); // Clean up regardless of outcome so a stale value can't be reused.

			if ( ! empty( $referer ) ) {
				wp_safe_redirect( add_query_arg( 'status', $status, $referer ) );
				exit; // phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
			}

			// Fallback: send back to the integrations page.
			wp_safe_redirect(
				add_query_arg(
					array(
						'page'   => Hustle_Data::INTEGRATIONS_PAGE,
						'status' => $status,
					),
					admin_url( 'admin.php' )
				)
			);
			exit; // phpcs:ignore WordPress.Security.SafeRedirect.wp_redirect_wp_redirect
		}

		// -----------------------------------------------------------------------
		// OAuth — token exchange & storage
		// -----------------------------------------------------------------------

		/**
		 * Exchange an authorization code for access + refresh tokens.
		 *
		 * Tokens are stored in wp_options under TOKEN_OPTION as an array:
		 *   [ access_token, refresh_token, expires_at (Unix timestamp) ]
		 *
		 * @param string $code Authorization code returned by Zoho.
		 * @return bool True on success, false on failure.
		 */
		public function exchange_code( $code ) {
			$data = array(
				'grant_type'    => 'authorization_code',
				'client_id'     => $this->client_id,
				'client_secret' => $this->client_secret,
				'redirect_uri'  => $this->get_redirect_uri(),
				'code'          => $code,
			);
			$body = http_build_query( $data );

			$response = wp_remote_post(
				$this->get_auth_base_url() . 'token',
				array(
					'headers' => array(
						'Content-Type' => 'application/x-www-form-urlencoded',
					),
					'body'    => $body,
				)
			);

			return $this->store_token_from_response( $response );
		}

		/**
		 * Use the stored refresh token to obtain a new access token.
		 *
		 * @return bool True on success, false on failure.
		 */
		public function do_refresh() {
			$token = $this->get_stored_token();
			if ( empty( $token['refresh_token'] ) ) {
				return false;
			}

			$data = array(
				'grant_type'    => 'refresh_token',
				'client_id'     => $this->client_id,
				'client_secret' => $this->client_secret,
				'refresh_token' => $token['refresh_token'],
			);
			$body = http_build_query( $data );

			$response = wp_remote_post(
				$this->get_auth_base_url() . 'token',
				array(
					'headers' => array(
						'Content-Type' => 'application/x-www-form-urlencoded',
					),
					'body'    => $body,
				)
			);

			return $this->store_token_from_response( $response, $token['refresh_token'] );
		}

		/**
		 * Parse a token endpoint response and persist the token data.
		 *
		 * @param array|\WP_Error $response     wp_remote_post() response.
		 * @param string          $keep_refresh Existing refresh token to keep when the
		 *                                      response does not include a new one (refresh flow).
		 * @return bool
		 */
		private function store_token_from_response( $response, $keep_refresh = '' ) {
			if ( is_wp_error( $response ) ) {
				$this->is_error      = true;
				$this->error_message = $response->get_error_message();
				return false;
			}

			$body = json_decode( wp_remote_retrieve_body( $response ), true );

			if ( empty( $body['access_token'] ) ) {
				$this->is_error      = true;
				$this->error_message = ! empty( $body['error'] ) ? sanitize_text_field( $body['error'] ) : 'Unknown error';
				return false;
			}

			// Zoho omits refresh_token on refresh responses; fall back to the one already stored.
			// expires_in is in seconds; convert to an absolute timestamp for easy comparison (3600s fallback).
			$token_data = array(
				'access_token'  => sanitize_text_field( $body['access_token'] ),
				'refresh_token' => sanitize_text_field( $body['refresh_token'] ?? $keep_refresh ),
				'expires_at'    => time() + (int) ( $body['expires_in'] ?? 3600 ),
			);

			update_option( self::TOKEN_OPTION, $token_data, false );
			return true;
		}

		// -----------------------------------------------------------------------
		// OAuth — token retrieval & authorization check
		// -----------------------------------------------------------------------

		/**
		 * Return the stored token array, or an empty array if nothing is saved.
		 *
		 * @return array
		 */
		public function get_stored_token() {
			$token = get_option( self::TOKEN_OPTION, array() );
			return is_array( $token ) ? $token : array();
		}

		/**
		 * Check whether a valid (non-expired) access token is stored.
		 *
		 * Automatically attempts a refresh if the token has expired.
		 *
		 * @return bool
		 */
		public function is_authorized() {
			$token = $this->get_stored_token();

			if ( empty( $token['access_token'] ) ) {
				return false;
			}

			// Token is still fresh.
			if ( ! empty( $token['expires_at'] ) && time() < (int) $token['expires_at'] ) {
				return true;
			}

			// Token expired — try a refresh.
			return $this->do_refresh();
		}

		/**
		 * Delete the stored token and referer from wp_options.
		 */
		public function remove_token() {
			delete_option( self::TOKEN_OPTION );
			delete_option( self::REFERER_OPTION );
		}

		// -----------------------------------------------------------------------
		// CRM API
		// -----------------------------------------------------------------------

		/**
		 * Key prefix used to cache field lists in wp_options.
		 * Full key: hustle_zohocrm_fields_{module}.
		 */
		const FIELDS_CACHE_PREFIX = 'hustle_zohocrm_fields_';

		/**
		 * Make an authenticated request to the Zoho CRM REST API.
		 *
		 * Automatically retries once after a token refresh on a 401 response.
		 *
		 * @param string $method HTTP method (GET, POST, PUT, DELETE).
		 * @param string $path   API path relative to get_api_base_url(), e.g. 'Leads'.
		 * @param array  $body   Request body (JSON-encoded for non-GET requests).
		 * @return mixed Decoded JSON body on success, WP_Error on failure.
		 */
		public function request( $method, $path, $body = array() ) {
			$token = $this->get_stored_token();

			if ( empty( $token['access_token'] ) && ! $this->do_refresh() ) {
				return new WP_Error( 'no_token', __( 'No valid Zoho CRM access token. Please reconnect.', 'hustle' ) );
			}

			$token = $this->get_stored_token();

			$args = array(
				'method'  => strtoupper( $method ),
				'headers' => array(
					'Authorization' => 'Zoho-oauthtoken ' . $token['access_token'],
					'Content-Type'  => 'application/json',
				),
				'timeout' => 30,
			);

			if ( ! empty( $body ) && 'GET' !== $args['method'] ) {
				$args['body'] = wp_json_encode( $body );
			}

			$url      = $this->get_api_base_url() . ltrim( $path, '/' );
			$response = wp_remote_request( $url, $args );

			// On 401, try a token refresh and retry once.
			if ( ! is_wp_error( $response ) && 401 === wp_remote_retrieve_response_code( $response ) ) {
				if ( $this->do_refresh() ) {
					$token                            = $this->get_stored_token();
					$args['headers']['Authorization'] = 'Zoho-oauthtoken ' . $token['access_token'];
					$response                         = wp_remote_request( $url, $args );
				}
			}

			if ( is_wp_error( $response ) ) {
				$this->is_error      = true;
				$this->error_message = $response->get_error_message();
				return $response;
			}

			$decoded = json_decode( wp_remote_retrieve_body( $response ), true );
			$code    = wp_remote_retrieve_response_code( $response );

			if ( $code >= 400 ) {
				$msg                 = ! empty( $decoded['message'] ) ? $decoded['message'] : "HTTP $code";
				$this->is_error      = true;
				$this->error_message = sanitize_text_field( $msg );
				return new WP_Error( 'zohocrm_api_error', $this->error_message );
			}

			return $decoded;
		}

		/**
		 * Retrieve field definitions for a CRM module, with a simple wp_options cache.
		 *
		 * @param string $module Zoho CRM module API name, e.g. 'Leads' or 'Contacts'.
		 * @return array Associative array of [ api_name => display_label ], empty on failure.
		 */
		public function get_fields( $module ) {
			$cache_key = self::FIELDS_CACHE_PREFIX . strtolower( $module );
			$cached    = get_option( $cache_key );

			if ( is_array( $cached ) && ! empty( $cached ) ) {
				return $cached;
			}

			$result = $this->request( 'GET', 'settings/fields?module=' . rawurlencode( $module ) );

			if ( is_wp_error( $result ) || empty( $result['fields'] ) ) {
				return array();
			}

			$fields = array();
			foreach ( $result['fields'] as $field ) {
				if ( empty( $field['api_name'] ) ) {
					continue;
				}
				$fields[ $field['api_name'] ] = $field['field_label'] ?? $field['api_name'];
			}

			update_option( $cache_key, $fields, false );
			return $fields;
		}

		/**
		 * Clear the cached field list for a given module (call after module changes).
		 *
		 * @param string $module Zoho CRM module API name.
		 */
		public function clear_fields_cache( $module ) {
			delete_option( self::FIELDS_CACHE_PREFIX . strtolower( $module ) );
		}

		/**
		 * Ensure a custom field exists in a Zoho CRM module, creating it if necessary.
		 *
		 * Checks the cached field list for a matching label first. If no match is
		 * found, the field is created via POST /settings/fields and the field cache
		 * is busted so subsequent calls see the new field.
		 *
		 * Supported data types (simple scalar fields): text, email, phone, website,
		 * integer, double, percent, bigint, boolean, date, datetime. Complex types
		 * (textarea, picklist, formula, lookup, etc.) require additional body keys
		 * and are not handled here.
		 *
		 * @param string $module    Zoho CRM module API name, e.g. 'Contacts'.
		 * @param string $label     Human-readable field label (must be unique per module).
		 * @param string $data_type Zoho data type string, e.g. 'text', 'email', 'phone'.
		 * @return string|WP_Error API name of the field on success, WP_Error on failure.
		 */
		public function ensure_custom_field( $module, $label, $data_type ) {
			// Check cached field list for an existing field with this label.
			$fields    = $this->get_fields( $module );
			$label_key = strtolower( $label );
			foreach ( $fields as $api_name => $field_label ) {
				if ( strtolower( $field_label ) === $label_key ) {
					return $api_name;
				}
			}

			// Field does not exist yet — create it.
			$result = $this->request(
				'POST',
				'settings/fields?module=' . rawurlencode( $module ),
				array(
					'fields' => array(
						array(
							'field_label' => $label,
							'data_type'   => $data_type,
						),
					),
				)
			);

			if ( is_wp_error( $result ) ) {
				return $result;
			}

			$entry = $result['fields'][0] ?? null;
			if ( empty( $entry['details']['id'] ) || 'success' !== strtolower( $entry['status'] ?? '' ) ) {
				$msg = $entry['message'] ?? 'Unknown error creating field: ' . $label;
				return new WP_Error( 'zohocrm_field_create_failed', sanitize_text_field( $msg ) );
			}

			// The create response contains only the new field ID but not its api_name.
			// Bust the cache and re-fetch the full field list, then locate by label.
			$this->clear_fields_cache( $module );
			$refreshed = $this->get_fields( $module );
			foreach ( $refreshed as $api_name => $field_label ) {
				if ( strtolower( $field_label ) === $label_key ) {
					return $api_name;
				}
			}

			return new WP_Error( 'zohocrm_field_create_failed', 'Could not determine API name for created field: ' . $label );
		}

		/**
		 * Retrieve the tags defined for the Contacts module in Zoho CRM.
		 *
		 * Calls GET /settings/tags?module=Contacts and returns [ tag_id => tag_name ].
		 * Results are cached in a transient for one hour.
		 *
		 * @return array Associative array of [ tag_id => tag_name ].
		 */
		public function get_tags() {
			$cache_key = 'hustle_zohocrm_tags';
			$cached    = get_transient( $cache_key );
			if ( false !== $cached ) {
				return $cached;
			}

			$result = $this->request( 'GET', 'settings/tags?module=Contacts' );

			if ( is_wp_error( $result ) || empty( $result['tags'] ) ) {
				return array();
			}

			$tags = array();
			foreach ( $result['tags'] as $tag ) {
				$id   = $tag['id'] ?? '';
				$name = $tag['name'] ?? '';
				if ( ! empty( $id ) && ! empty( $name ) ) {
					$tags[ $id ] = $name;
				}
			}

			set_transient( $cache_key, $tags, HOUR_IN_SECONDS );
			return $tags;
		}

		/**
		 * Add a tag to a single Contact record, replacing any existing tags.
		 *
		 * Uses POST /Contacts/{record_id}/actions/add_tags with over_write=true so
		 * any previously assigned tags are replaced in a single API call.
		 *
		 * @see https://www.zoho.com/crm/developer/docs/api/v8/add-tags.html
		 *
		 * @param string $tag_id    Zoho CRM tag ID.
		 * @param string $record_id Zoho CRM Contact record ID.
		 * @return bool|WP_Error True on success, WP_Error on failure.
		 */
		public function add_tag_to_record( $tag_id, $record_id ) {
			$body   = array(
				'tags'       => array( array( 'id' => $tag_id ) ),
				'over_write' => true,
			);
			$result = $this->request( 'POST', 'Contacts/' . rawurlencode( $record_id ) . '/actions/add_tags', $body );

			if ( is_wp_error( $result ) ) {
				return $result;
			}

			$entry = $result['data'][0] ?? null;
			return ! empty( $entry['status'] ) && 'success' === strtolower( $entry['status'] );
		}

		/**
		 * Remove all tags from a single Contact record.
		 *
		 * Fetches the contact's current Tag values then calls
		 * POST /Contacts/{record_id}/actions/remove_tags.
		 * Returns true immediately when the contact has no tags.
		 *
		 * @see https://www.zoho.com/crm/developer/docs/api/v8/remove-tags.html
		 *
		 * @param string $record_id Zoho CRM Contact record ID.
		 * @return bool|WP_Error True on success, WP_Error on failure.
		 */
		public function remove_all_tags_from_record( $record_id ) {
			$contact = $this->request( 'GET', 'Contacts/' . rawurlencode( $record_id ) . '?fields=Tag' );

			if ( is_wp_error( $contact ) ) {
				return $contact;
			}

			$existing_tags = $contact['data'][0]['Tag'] ?? array();

			if ( empty( $existing_tags ) ) {
				return true;
			}

			$tags_to_remove = array();
			foreach ( $existing_tags as $tag ) {
				if ( ! empty( $tag['name'] ) ) {
					$tags_to_remove[] = array( 'name' => $tag['name'] );
				}
			}

			if ( empty( $tags_to_remove ) ) {
				return true;
			}

			$body   = array( 'tags' => $tags_to_remove );
			$result = $this->request( 'POST', 'Contacts/' . rawurlencode( $record_id ) . '/actions/remove_tags', $body );

			if ( is_wp_error( $result ) ) {
				return $result;
			}

			$entry = $result['data'][0] ?? null;
			return ! empty( $entry['status'] ) && 'success' === strtolower( $entry['status'] );
		}

		/**
		 * Retrieve a list of records from a CRM module for use in admin dropdowns.
		 *
		 * Returns an associative array of [ record_id => display_label ].
		 * Results are cached in a transient for one hour.
		 *
		 * @param string $module Zoho CRM module API name, e.g. 'Leads'.
		 * @return array
		 */
		public function get_records( $module ) {
			$cache_key = 'hustle_zohocrm_records_' . strtolower( $module );
			$cached    = get_transient( $cache_key );
			if ( false !== $cached ) {
				return $cached;
			}

			$path     = $module . '?fields=id,Full_Name,Last_Name,First_Name,Email&per_page=200&sort_by=Modified_Time&sort_order=desc';
			$response = $this->request( 'GET', $path );

			if ( is_wp_error( $response ) || empty( $response['data'] ) ) {
				return array();
			}

			$records = array();
			foreach ( $response['data'] as $record ) {
				$id    = $record['id'] ?? '';
				$name  = $record['Full_Name'] ?? trim( ( $record['First_Name'] ?? '' ) . ' ' . ( $record['Last_Name'] ?? '' ) );
				$email = $record['Email'] ?? '';
				if ( ! empty( $id ) ) {
					$label          = ! empty( $name ) ? $name : $email;
					$records[ $id ] = ! empty( $label ) ? $label : $id;
				}
			}

			set_transient( $cache_key, $records, HOUR_IN_SECONDS );
			return $records;
		}

		/**
		 * Create a new record in a CRM module.
		 *
		 * @param string $module Zoho CRM module API name.
		 * @param array  $data   Field values keyed by Zoho API name.
		 * @return string|WP_Error Record ID on success, WP_Error on failure.
		 */
		public function create_record( $module, $data ) {
			$body   = array( 'data' => array( $data ) );
			$result = $this->request( 'POST', $module, $body );

			if ( is_wp_error( $result ) ) {
				return $result;
			}

			$entry = $result['data'][0] ?? null;
			if ( empty( $entry['details']['id'] ) || 'success' !== strtolower( $entry['status'] ?? '' ) ) {
				$msg = $entry['message'] ?? 'Unknown error creating record';
				return new WP_Error( 'zohocrm_create_failed', sanitize_text_field( $msg ) );
			}

			return $entry['details']['id'];
		}

		/**
		 * Update an existing record by its Zoho record ID.
		 *
		 * @param string $module    Zoho CRM module API name.
		 * @param string $record_id Zoho record ID.
		 * @param array  $data      Field values to update.
		 * @return bool|WP_Error True on success, WP_Error on failure.
		 */
		public function update_record( $module, $record_id, $data ) {
			$data['id'] = $record_id;
			$body       = array( 'data' => array( $data ) );
			$result     = $this->request( 'PUT', $module . '/' . $record_id, $body );

			if ( is_wp_error( $result ) ) {
				return $result;
			}

			$entry = $result['data'][0] ?? null;
			return ! empty( $entry['status'] ) && 'success' === strtolower( $entry['status'] );
		}

		/**
		 * Search for records in a module by email address.
		 *
		 * @param string $module Zoho CRM module API name.
		 * @param string $email  Email to search for.
		 * @return string|null Record ID of the first match, or null if not found.
		 */
		public function search_record_by_email( $module, $email ) {
			$path   = $module . '/search?criteria=(Email:equals:' . rawurlencode( $email ) . ')&fields=id';
			$result = $this->request( 'GET', $path );

			if ( is_wp_error( $result ) || empty( $result['data'][0]['id'] ) ) {
				return null;
			}

			return $result['data'][0]['id'];
		}

		/**
		 * Delete a record by its Zoho record ID.
		 *
		 * @param string $module    Zoho CRM module API name.
		 * @param string $record_id Zoho record ID.
		 * @return bool|WP_Error True on success, WP_Error on failure.
		 */
		public function delete_record( $module, $record_id ) {
			$result = $this->request( 'DELETE', $module . '/' . $record_id );

			if ( is_wp_error( $result ) ) {
				return $result;
			}

			$entry = $result['data'][0] ?? null;
			return ! empty( $entry['status'] ) && 'success' === strtolower( $entry['status'] );
		}

		// -----------------------------------------------------------------------
		// Hustle_Auth_Provider interface
		// -----------------------------------------------------------------------

		/**
		 * Exchange an authorization code and return a Hustle_Auth_Token.
		 *
		 * @param string $code Authorization code.
		 * @return Hustle_Auth_Token|null
		 */
		public function get_access_token( $code ) {
			if ( ! $this->exchange_code( $code ) ) {
				return null;
			}

			$token = $this->get_stored_token();
			return Hustle_Auth_Token::from_array(
				array(
					'access_token'    => $token['access_token'],
					'refresh_token'   => $token['refresh_token'] ?? '',
					'expiration_time' => $token['expires_at'] ?? 0,
				)
			);
		}

		/**
		 * Refresh the access token and return a Hustle_Auth_Token.
		 *
		 * If a refresh token is explicitly supplied it replaces the one in storage
		 * (useful when the caller has obtained a new refresh token out-of-band).
		 *
		 * @param string $refresh_token Refresh token (uses stored value when empty).
		 * @return Hustle_Auth_Token|null
		 */
		public function refresh_access_token( $refresh_token ) {
			// If the caller supplied a refresh token, persist it before refreshing.
			if ( ! empty( $refresh_token ) ) {
				$token                  = $this->get_stored_token();
				$token['refresh_token'] = sanitize_text_field( $refresh_token );
				update_option( self::TOKEN_OPTION, $token, false );
			}

			if ( ! $this->do_refresh() ) {
				return null;
			}

			$token = $this->get_stored_token();
			return Hustle_Auth_Token::from_array(
				array(
					'access_token'    => $token['access_token'],
					'refresh_token'   => $token['refresh_token'] ?? '',
					'expiration_time' => $token['expires_at'] ?? 0,
				)
			);
		}
	}

endif;
