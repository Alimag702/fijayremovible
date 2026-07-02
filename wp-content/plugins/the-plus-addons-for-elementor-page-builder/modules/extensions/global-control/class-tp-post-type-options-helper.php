<?php
/**
 * Post Type Options Helper Trait
 *
 * Shared helper for widgets that need to read post_type_options.
 * Used by Clients, Team Member, and Testimonial listing widgets.
 *
 * @link    https://posimyth.com/
 * @since   6.4.13
 *
 * @package the-plus-addons-for-elementor-page-builder
 */

namespace ThePlusAddons\Elementor\PostTypeOptions;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! trait_exists( 'ThePlusAddons\Elementor\PostTypeOptions\TP_Post_Type_Options_Helper' ) ) {
	trait TP_Post_Type_Options_Helper {

		/**
		 * Get a field value from post_type_options (cached).
		 *
		 * @since 6.4.13
		 *
		 * @param string $field Option field key.
		 *
		 * @return string Option value or empty string.
		 */
		public function tpae_get_options( $field ) {
			static $post_type_options = null;

			if ( null === $post_type_options ) {
				$post_type_options = get_option( 'post_type_options' );
			}

			if ( isset( $post_type_options[ $field ] ) && ! empty( $post_type_options[ $field ] ) ) {
				return $post_type_options[ $field ];
			}

			return '';
		}

		/**
		 * Get taxonomy name based on post type config.
		 *
		 * @since 6.4.13
		 *
		 * @param array $config {
		 *     @type string $post_type_key    Option key for the post type (e.g. 'client_post_type').
		 *     @type string $default          Default taxonomy name (e.g. 'theplus_clients_cat').
		 *     @type string $themes_option    Option key for themes category name.
		 *     @type string $plugin_option    Option key for plugin category name.
		 *     @type string $themes_pro_value Hardcoded value for themes_pro mode.
		 * }
		 *
		 * @return string Taxonomy name.
		 */
		public function tpae_get_taxonomy_name( $config ) {
			$post_type = $this->tpae_get_options( $config['post_type_key'] );

			if ( empty( $post_type ) ) {
				return $config['default'];
			}

			if ( 'themes' === $post_type ) {
				return $this->tpae_get_options( $config['themes_option'] );
			}

			if ( 'plugin' === $post_type ) {
				$name = $this->tpae_get_options( $config['plugin_option'] );

				return ! empty( $name ) ? $name : $config['default'];
			}

			if ( 'themes_pro' === $post_type ) {
				return $config['themes_pro_value'];
			}

			return $config['default'];
		}

		/**
		 * Get categories for the current widget's post type.
		 *
		 * @since 6.4.13
		 *
		 * @return array Associative array of term_id => name.
		 */
		public function tpae_get_categories() {
			$taxonomy = $this->tpae_get_post_cat();

			if ( empty( $taxonomy ) ) {
				return array();
			}

			$categories = get_categories(
				array(
					'taxonomy'   => $taxonomy,
					'hide_empty' => 0,
				)
			);

			if ( empty( $categories ) || ! is_array( $categories ) ) {
				return array();
			}

			return wp_list_pluck( $categories, 'name', 'term_id' );
		}

		/**
		 * Get post type name based on post type config.
		 *
		 * @since 6.4.13
		 *
		 * @param array $config {
		 *     @type string $post_type_key    Option key for the post type (e.g. 'client_post_type').
		 *     @type string $default          Default post type name (e.g. 'theplus_clients').
		 *     @type string $themes_option    Option key for themes post type name.
		 *     @type string $plugin_option    Option key for plugin post type name.
		 *     @type string $themes_pro_value Hardcoded value for themes_pro mode.
		 * }
		 *
		 * @return string Post type name.
		 */
		public function tpae_get_post_type_name( $config ) {
			$post_type = $this->tpae_get_options( $config['post_type_key'] );

			if ( empty( $post_type ) ) {
				return $config['default'];
			}

			if ( 'themes' === $post_type ) {
				return l_theplus_get_option( 'post_type', $config['themes_option'] );
			}

			if ( 'plugin' === $post_type ) {
				$name = l_theplus_get_option( 'post_type', $config['plugin_option'] );

				return ! empty( $name ) ? $name : $config['default'];
			}

			if ( 'themes_pro' === $post_type ) {
				return $config['themes_pro_value'];
			}

			return $config['default'];
		}

		/**
		 * Get the current page number from query vars.
		 *
		 * @since 6.4.13
		 *
		 * @return int Current page number (defaults to 1).
		 */
		public static function get_current_page_number() {
			if ( get_query_var( 'paged' ) ) {
				return absint( get_query_var( 'paged' ) );
			}

			if ( get_query_var( 'page' ) ) {
				return absint( get_query_var( 'page' ) );
			}

			return 1;
		}
	}
}
