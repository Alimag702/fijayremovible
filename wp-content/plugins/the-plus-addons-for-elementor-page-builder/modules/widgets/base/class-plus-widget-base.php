<?php
/**
 * Abstract base class for all ThePlus Elementor widgets.
 *
 * Centralises the boilerplate that historically lived inside every
 * L_ThePlus_* widget class:
 *
 *   - the $tp_doc / $tp_help properties,
 *   - the get_custom_help_url() implementation,
 *   - the default has_widget_inner_wrapper() behaviour,
 *   - the get_upsale_data() "Upgrade to Pro" CTA.
 *
 * Concrete widgets should `extends Plus_Widget_Base` instead of
 * `extends \Elementor\Widget_Base`. They only need to override a
 * member when its behaviour genuinely differs from the default.
 *
 * @package the-plus-addons-for-elementor-page-builder
 * @since   6.4.13
 * @version 6.4.13
 */

namespace TheplusAddons\Widgets\Base;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Plus_Widget_Base.
 *
 * @since 6.4.13
 */
#[\AllowDynamicProperties]
abstract class Plus_Widget_Base extends Widget_Base {

	/**
	 * Documentation link used by children (e.g. `$this->tp_doc . 'some-slug/'`).
	 *
	 * Populated in the constructor so autoloading this class before the main
	 * plugin file has defined L_THEPLUS_TPDOC does not emit a PHP warning.
	 *
	 * @since 6.4.13
	 *
	 * @var string
	 */
	public $tp_doc = '';

	/**
	 * Helpdesk link surfaced by Elementor's widget panel "Need help" button.
	 *
	 * Populated in the constructor for the same reason as $tp_doc.
	 *
	 * @since 6.4.13
	 *
	 * @var string
	 */
	public $tp_help = '';

	/**
	 * @since 6.4.14
	 *
	 * @param array      $data Widget data.
	 * @param array|null $args Widget arguments.
	 */
	public function __construct( $data = array(), $args = null ) {
		$this->tp_doc  = defined( 'L_THEPLUS_TPDOC' ) ? L_THEPLUS_TPDOC : '';
		$this->tp_help = defined( 'L_THEPLUS_HELP' )  ? L_THEPLUS_HELP  : '';

		parent::__construct( $data, $args );
	}

	/**
	 * Default implementation for Elementor's help-URL hook.
	 *
	 * When the Pro plugin is active (THEPLUS_HELP defined), users are sent to
	 * Pro's helpdesk; otherwise the widget's own $tp_help (default: wp.org
	 * support forum) is used. Children may override for a per-widget help page.
	 *
	 * @since 6.4.13
	 *
	 * @return string
	 */
	public function get_custom_help_url() {
		$help_url = defined( 'THEPLUS_HELP' ) ? THEPLUS_HELP : $this->tp_help;

		return esc_url( $help_url );
	}

	/**
	 * Respect Elementor's e_optimized_markup experiment by default.
	 *
	 * Children that must always opt out of the inner wrapper
	 * (e.g. listing widgets rendering their own loop markup) should
	 * override and return false.
	 *
	 * @since 6.4.13
	 *
	 * @return bool
	 */
	public function has_widget_inner_wrapper(): bool {
		return ! \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' );
	}

	/**
	 * Default upsale block surfaced by Elementor's widget panel.
	 *
	 * Shows an "Upgrade to Pro" CTA when only the Free plugin is active.
	 * Children may override to suppress the upsale or to point to a
	 * widget-specific upgrade page.
	 *
	 * @since 6.4.13
	 *
	 * @return array
	 */
	public function get_upsale_data() {
		$val = false;

		if ( ! defined( 'THEPLUS_VERSION' ) ) {
			$val = true;
		}

		$assets_url = defined( 'L_THEPLUS_ASSETS_URL' ) ? L_THEPLUS_ASSETS_URL : '';

		return array(
			'condition'    => $val,
			'image'        => esc_url( $assets_url . 'images/pro-features/upgrade-proo.png' ),
			'image_alt'    => esc_attr__( 'Upgrade', 'tpebl' ),
			'title'        => esc_html__( 'Unlock all Features', 'tpebl' ),
			'upgrade_url'  => esc_url( 'https://theplusaddons.com/pricing/?utm_source=wpbackend&utm_medium=elementoreditor&utm_campaign=links' ),
			'upgrade_text' => esc_html__( 'Upgrade to Pro!', 'tpebl' ),
		);
	}
}
