<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Handles the authentication process for HubSpot integration in Hustle plugin
 * when not using the Hub (standalone authentication).
 *
 * @package Hustle
 * @subpackage Providers_HubSpot_Auth
 * @since   7.8.13
 */
class Hustle_Hubspot_Non_Hub_Auth extends Hustle_Hubspot_Base_Auth {

	const TOKEN_URL = 'https://api.hubspot.com/oauth/v3/token';

	/**
	 * OAuth application client ID.
	 *
	 * @var string
	 */
	private $client_id;

	/**
	 * OAuth application client secret.
	 *
	 * @var string
	 */
	private $client_secret;

	/**
	 * Constructor.
	 *
	 * @param string $client_id     OAuth application client ID.
	 * @param string $client_secret OAuth application client secret.
	 */
	public function __construct( $client_id, $client_secret ) {
		$this->client_id     = $client_id;
		$this->client_secret = $client_secret;
	}

	/**
	 * Get the authentication token.
	 *
	 * @param string $code  Authorization code.
	 * @param string $state State parameter.
	 *
	 * @return Hustle_Auth_Token|null
	 */
	public function get_access_token( $code, $state = '' ) {
		return $this->request_token(
			array(
				'grant_type'   => 'authorization_code',
				'code'         => $code,
				'redirect_uri' => $this->get_redirect_uri(),
			)
		);
	}

	/**
	 * Refresh the authentication token.
	 *
	 * @param string $refresh_token Refresh token.
	 *
	 * @return Hustle_Auth_Token|null
	 */
	public function refresh_access_token( $refresh_token ) {
		return $this->request_token(
			array(
				'grant_type'    => 'refresh_token',
				'refresh_token' => $refresh_token,
			)
		);
	}

	/**
	 * Send a token request to the HubSpot OAuth v3 endpoint.
	 *
	 * @param array $body Request body parameters (excluding client credentials).
	 *
	 * @return Hustle_Auth_Token|null
	 */
	private function request_token( $body ) {
		$body = array_merge(
			$body,
			array(
				'client_id'     => $this->client_id,
				'client_secret' => $this->client_secret,
			)
		);

		$response = wp_remote_post(
			self::TOKEN_URL,
			array(
				'headers' => array(
					'Content-Type' => 'application/x-www-form-urlencoded',
				),
				'body'    => $body,
			)
		);

		if ( is_wp_error( $response ) ) {
			return null;
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( empty( $data['access_token'] ) ) {
			return null;
		}

		$scope = isset( $data['scopes'] ) && is_array( $data['scopes'] )
			? implode( ' ', $data['scopes'] )
			: ( $data['scope'] ?? '' );

		$token = new Hustle_Auth_Token(
			$data['access_token'],
			$data['refresh_token'] ?? '',
			0,
			$scope
		);

		if ( ! empty( $data['expires_in'] ) ) {
			$token->set_token_lifetime( (int) $data['expires_in'] );
		}

		return $token;
	}

	/**
	 * Compose redirect_uri to use on request argument.
	 * The redirect uri must be constant and should not be change per request.
	 *
	 * @param array $args Args.
	 * @return string
	 */
	public function get_redirect_uri( $args = array() ) {
		$params = wp_parse_args(
			$args,
			array(
				'action'   => 'authorize',
				'provider' => 'hubspot',
			)
		);

		return add_query_arg( $params, site_url( '/' ) );
	}

	/**
	 * Get the client ID for the OAuth application.
	 *
	 * @return string
	 */
	public function get_client_id() {
		return $this->client_id;
	}
}
