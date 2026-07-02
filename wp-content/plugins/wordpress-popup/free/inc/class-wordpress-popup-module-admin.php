<?php
/**
 * File for Hustle_Module_Admin class.
 *
 * @package Hustle
 * @since unknown
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'WordPress_Popup_Module_Admin' ) ) {
	return;
}

/**
 * Class for WordPress_Popup_Module_Admin. Adds the free-specific functionality.
 *
 * @package Hustle
 * @since unknown
 */
class WordPress_Popup_Module_Admin {

	const LISTING_PAGES = array(
		'hustle_page_' . Hustle_Data::POPUP_LISTING_PAGE,
		'hustle_page_' . Hustle_Data::SLIDEIN_LISTING_PAGE,
		'hustle_page_' . Hustle_Data::EMBEDDED_LISTING_PAGE,
		'hustle_page_' . Hustle_Data::SOCIAL_SHARING_LISTING_PAGE,
	);

	/**
	 * Constructor.
	 *
	 * @since unknown
	 */
	public function __construct() {
		add_filter( 'hustle_locate_file', array( $this, 'locate_file' ), 10, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'admin_menu', array( $this, 'add_upsell_menu_item' ), 99 );
		add_action( 'admin_print_styles', array( $this, 'print_upsell_menu_item_styles' ) );
		add_action( 'admin_print_footer_scripts', array( $this, 'print_upsell_menu_item_script' ) );
		// Initialize the cross-sell class to add the cross-sell notice in the free module.
		new Hustle_Cross_Sell();
	}

	/**
	 * Locate the file for the given layout. If the file exists in the free module, it will be returned. Otherwise, the original file will be returned.
	 *
	 * @since unknown
	 *
	 * @param string $template_file The original template file path.
	 * @param string $layout The layout name, which is used to create the file name.
	 * @return string
	 */
	public function locate_file( $template_file, $layout ) {

		$free_template_file = trailingslashit( Opt_In::$plugin_path ) . 'free/views/' . $layout . '.php';

		if ( file_exists( $free_template_file ) ) {
			return $free_template_file;
		}

		return $template_file;
	}

	/**
	 * Enqueue the admin scripts for the free module.
	 *
	 * @since unknown
	 */
	public function enqueue_admin_scripts() {
		$screen = get_current_screen();

		if ( ! $screen || ! in_array( $screen->base, self::LISTING_PAGES, true ) ) {
			return;
		}

		wp_enqueue_script(
			'wordpress-popup',
			trailingslashit( Opt_In::$plugin_url ) . '/assets/js/wordpress-popup.min.js',
			array(
				'jquery',
				'optin_admin_scripts',
				'shared-ui',
			),
			'1.0.0',
			true
		);
	}

	/**
	 * Adds Upsell menu item.
	 *
	 * @since 7.8.8
	 */
	public function add_upsell_menu_item() {
		add_submenu_page(
			'hustle',
			__( 'Get Hustle Pro', 'hustle' ),
			__( 'Get Hustle Pro', 'hustle' ),
			'hustle_menu',
			'https://wpmudev.com/project/hustle/?utm_source=hustle&utm_medium=plugin&utm_campaign=hustle_submenu_upsell',
		);
	}

	/**
	 * Prints styles for Upsell menu item.
	 *
	 * @since 7.8.8
	 */
	public function print_upsell_menu_item_styles() {
		?>
		<style id="hustle-upsell">
			#adminmenu #toplevel_page_hustle .wp-submenu li:last-child a[href^="https://wpmudev.com"] {
				background-color: #8d00b1 !important; color: #fff !important; font-weight: 500 !important; letter-spacing: -0.2px;
			}
		</style>
		<?php
	}

	/**
	 * Prints scripts for Upsell menu item.
	 *
	 * @since 7.8.8
	 */
	public function print_upsell_menu_item_script() {
		?>
		<script>
			jQuery( document ).ready( function ( $ ) {
				/**
				 * Open the upsell link in a new tab.
				 */
				$( '#toplevel_page_hustle .wp-submenu li:last-child a[href^="https://wpmudev.com"]' ).on( 'click', function ( e ) {
					e.preventDefault();
					window.open( $( this ).attr( 'href' ), '_blank' );
				} );
			} );
		</script>
		<?php
	}
}
