<?php
/**
 * Trait providing "reload preview required" behaviour for widgets.
 *
 * When a widget's visual output depends on render-time PHP state that
 * Elementor's JS-side re-render cannot reproduce (e.g. server-rendered
 * loops, third-party markup, shortcodes), returning true from
 * is_reload_preview_required() tells Elementor to reload the preview
 * iframe on every control change instead of re-rendering in place.
 *
 * Widgets that need this behaviour should:
 *
 *     use TheplusAddons\Widgets\Base\Reload_Preview_Trait;
 *
 *     class My_Widget extends Plus_Widget_Base {
 *         use Reload_Preview_Trait;
 *         // ...
 *     }
 *
 * @package the-plus-addons-for-elementor-page-builder
 * @since   6.4.13
 * @version 6.4.13
 */

namespace TheplusAddons\Widgets\Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! trait_exists( __NAMESPACE__ . '\\Reload_Preview_Trait' ) ) {

	/**
	 * Trait Reload_Preview_Trait.
	 *
	 * Opt-in trait that forces an Elementor editor preview reload on
	 * every control change for the consuming widget.
	 *
	 * @since 6.4.13
	 */
	trait Reload_Preview_Trait {

		/**
		 * Tell Elementor the editor preview must reload on control changes.
		 *
		 * @since 6.4.13
		 *
		 * @return bool Always true.
		 */
		public function is_reload_preview_required() {
			return true;
		}
	}
}
