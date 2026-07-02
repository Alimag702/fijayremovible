<?php
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'L_Theplus_Elements_Integration' ) ) {

	/**
	 * Define L_Theplus_Elements_Integration class
	 */
	class L_Theplus_Elements_Integration {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 */
		private static $instance = null;

		/**
		 * Initalize integration hooks
		 * 
		 * @since 1.0.0
		 */
		public function init() {
			// 'elementor/controls/controls_registered' is deprecated
			// since Elementor 3.1. Both old and new hooks pass the
			// Controls_Manager instance to the callback, so the existing
			// add_controls() method continues to work unchanged.
			add_action( 'elementor/controls/register', array( $this, 'add_controls' ), 10 );
		}

		/**
		 * Add new controls.
		 *
		 * @param  object $controls_manager Controls manager instance.
		 */
		public function add_controls( $controls_manager ) {

			$plus_control = array(
				'plus-query' => 'L_Theplus_Query',
				'tpae-need-help' => 'Tpae_Need_Help_Control',
				'tpae-preset-controller' => 'Tpae_Preset_Controller',
				'tpae-pro-features' => 'Tpae_Pro_Feature',
				'tpae-theme-builder' => 'Tpae_Theme_builder'
			);

			foreach ( $plus_control as $control_id => $class_name ) {
				if ( $this->include_plus_control( $control_id, true ) ) {
					// new $class_name();
					// $controls_manager->register_control( $control_id, new $class_name() );
					if ( version_compare( ELEMENTOR_VERSION, '3.5.0', '>=' ) ) {
						$controls_manager->register( new $class_name() );
					} else {
						$controls_manager->register_control( $control_id, new $class_name() );
					}
				}
			}
		}

		/**
		 * Include plus control file by class name.
		 *
		 * @param  [type] $class_name [description]
		 * @return [type]             [description]
		 */
		public function include_plus_control( $control_id, $grouped = false ) {

			$control_id = preg_replace( '/[^a-zA-Z0-9_-]/', '', (string) $control_id );
			if ( '' === $control_id ) {
				return false;
			}

			$base = wp_normalize_path( L_THEPLUS_PATH . 'modules/controls/' );
			$path = wp_normalize_path( $base . $control_id . '.php' );

			if ( 0 !== strpos( $path, $base ) || ! file_exists( $path ) ) {
				return false;
			}

			include $path;

			return true;
		}
		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 */
		public static function get_instance( $shortcodes = array() ) {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self( $shortcodes );
			}
			return self::$instance;
		}
	}
}

/**
 * Returns instance of L_Theplus_Elements_Integration
 *
 * @return object
 */
function L_Theplus_Elements_Integration() {
	return L_Theplus_Elements_Integration::get_instance();
}
