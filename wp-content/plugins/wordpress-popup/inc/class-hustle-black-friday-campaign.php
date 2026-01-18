<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * File for the Hustle_Black_Friday_Campaign class.
 *
 * @package Hustle
 */
class Hustle_Black_Friday_Campaign {

	/**
	 * Constructor to initiate the Black Friday Campaign sub module
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_black_friday_campaign_module' ) );
	}

	/**
	 * Register the Black Friday Campaign module
	 */
	public function register_black_friday_campaign_module() {
		$black_friday_path = Opt_In::$plugin_path . 'lib/wpmudev-black-friday/campaign.php';
		if ( ! file_exists( $black_friday_path ) ) {
			return;
		}

		if ( ! class_exists( 'WPMUDEV\Modules\BlackFriday\Campaign' ) ) {
			require_once $black_friday_path;
			new \WPMUDEV\Modules\BlackFriday\Campaign();
		}
	}
}
