<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Hustle HubSpot Base Auth.
 *
 * @package Hustle
 * @subpackage Providers_HubSpot_Auth
 * @since 7.8.13
 */
abstract class Hustle_Hubspot_Base_Auth implements Hustle_Auth_Provider {
	/**
	 * Compose redirect_uri to use on request argument.
	 * The redirect uri must be constant and should not be change per request.
	 *
	 * @param array $args Args.
	 * @return string
	 */
	abstract public function get_redirect_uri( $args = array() );

	/**
	 * Get the client ID for the OAuth application.
	 *
	 * @return string
	 */
	abstract public function get_client_id();
}
