<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Hustle_Hubspot_Hub_OAuth
 *
 * @package Hustle
 */
/**
 * Class Hustle_Hubspot_Hub_OAuth
 *
 * This class is used to retrieve tokens for Hub-connected HubSpot accounts.
 *
 * @since 4.3.1
 */
class Hustle_Hubspot_Hub_OAuth extends Hustle_Hubspot_Base_Auth {

	/**
	 * Get the authentication token.
	 *
	 * @param string $code         Authorization code.
	 * @param string $state        State parameter.
	 *
	 * @return Hustle_Auth_Token|null
	 */
	public function get_access_token( $code, $state = '' ) {
		$redirect_uri = $this->get_redirect_uri();

		return $this->fetch_token(
			array( 'code' => $code ),
			$redirect_uri,
			$state
		);
	}

	/**
	 * Fetch the token from the API.
	 *
	 * @param array  $args         The arguments to use for fetching the token.
	 * @param string $redirect_uri The redirect URI to use for oAuth.
	 * @param string $state        State parameter.
	 * @return Hustle_Auth_Token|null
	 */
	private function fetch_token( $args, $redirect_uri, $state ) {
		$args = wp_parse_args(
			$args,
			array(
				'redirect_uri' => rawurlencode( $redirect_uri ),
				'grant_type'   => 'authorization_code',
				'action'       => 'get_access_token',
				'state'        => $state,
				'provider'     => 'hubspot',
				'client_id'    => Hustle_HubSpot_Api::CLIENT_ID,
			)
		);

		$url      = add_query_arg( $args, Hustle_HubSpot_Api::get_remote_api_url() );
		$res      = wp_remote_get( $url );
		$body     = is_wp_error( $res ) || ! $res ? '' : wp_remote_retrieve_body( $res );
		$response = $body ? json_decode( $body ) : '';

		if ( ! empty( $response->refresh_token ) ) {
			$token_data = get_object_vars( $response );

			return Hustle_Auth_Token::from_array( $token_data );
		}

		return null;
	}

	/**
	 * Refresh the authentication token.
	 *
	 * @param string $refresh_token Refresh token.
	 * @param string $state         State parameter.
	 * @return Hustle_Auth_Token|null
	 */
	public function refresh_access_token( $refresh_token, $state = '' ) {
		$redirect_uri = $this->get_redirect_uri();
		$args         = array(
			'grant_type'    => 'refresh_token',
			'refresh_token' => $refresh_token,
		);

		return $this->fetch_token( $args, $redirect_uri, $state );
	}

	/**
	 * Get the client ID for the OAuth application.
	 *
	 * @return string
	 */
	public function get_client_id() {
		return Hustle_HubSpot_Api::CLIENT_ID;
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
				'action'    => 'authorize',
				'provider'  => 'hubspot',
				'client_id' => $this->get_client_id(),
			)
		);

		return add_query_arg( $params, Opt_In_WPMUDEV_API::get_remote_api_url() );
	}
}
