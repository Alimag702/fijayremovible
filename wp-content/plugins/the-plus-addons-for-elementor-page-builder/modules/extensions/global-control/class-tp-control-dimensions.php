<?php
/**
 * Global Dimensions Base Control Override
 *
 * @link    https://posimyth.com/
 * @since   v6.5.0
 *
 * @package the-plus-addons-for-elementor-page-builder
 */
namespace ThePlusAddons\Elementor\Dimensions;

use Elementor\Control_Dimensions;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'ThePlusAddons\Elementor\Dimensions\TP_Control_Dimensions' ) && class_exists( '\Elementor\Control_Dimensions' ) ) {

	/**
	 * Extends Elementor's native Dimensions control to append a Global Setting preset check.
	 *
	 * @since v6.5.0
	 */
	class TP_Control_Dimensions extends Control_Dimensions {

		/**
		 * Retrieve dimensions control default value.
		 * Inject our preset key.
		 *
		 * @since v6.5.0
		 * @return array Default value.
		 */
		public function get_default_value() {
			return array_merge(
				parent::get_default_value(),
				array(
					'tp_global_preset' => '',
				)
			);
		}

		/**
		 * Resolve style placeholders from the selected global preset when present.
		 *
		 * This lets existing DIMENSIONS controls keep using their current selectors
		 * (`{{TOP}}`, `{{RIGHT}}`, `{{BOTTOM}}`, `{{LEFT}}`, `{{UNIT}}`) without any
		 * per-widget changes.
		 *
		 * @since v6.5.0
		 *
		 * @param string $css_property  CSS placeholder property.
		 * @param array  $control_value Control value.
		 * @param array  $control_data  Control data.
		 *
		 * @return string
		 */
		/**
		 * Stores preset IDs resolved on the desktop control so that
		 * responsive child controls (tablet / mobile) can inherit them.
		 *
		 * Keyed by base (desktop) control name.
		 *
		 * @var array
		 */
		/**
		 * Stores preset IDs resolved on the desktop control so that
		 * responsive child controls (tablet / mobile) can inherit them.
		 *
		 * Keyed by base (desktop) control name.
		 *
		 * @var array
		 */
		private static $resolved_presets = array();

		/**
		 * Known responsive device suffixes used by Elementor.
		 *
		 * @var array
		 */
		private static $device_suffixes = array(
			'_mobile',
			'_mobile_extra',
			'_tablet',
			'_tablet_extra',
			'_laptop',
			'_widescreen',
		);

		/**
		 * Derive the base (desktop) control name by stripping any device suffix.
		 *
		 * e.g. 'box_padding_tablet' → 'box_padding'
		 *      'box_padding'        → 'box_padding'
		 *
		 * @param string $name Control name.
		 * @return string Base control name.
		 */
		private static function get_base_control_name( $name ) {
			foreach ( self::$device_suffixes as $suffix ) {
				$len = strlen( $suffix );

				if ( substr( $name, -$len ) === $suffix ) {
					return substr( $name, 0, -$len );
				}
			}

			return $name;
		}

		public function get_style_value( $css_property, $control_value, array $control_data ) {
			$css_property = strtoupper( $css_property );

			if ( ! class_exists( 'ThePlusAddons\Elementor\Dimensions\TP_Dimensions_Global' ) ) {
				return parent::get_style_value( $css_property, $control_value, $control_data );
			}

			// Detect current device from control metadata.
			$device = 'desktop';

			if ( ! empty( $control_data['responsive']['max'] ) ) {
				$device = $control_data['responsive']['max'];
			} elseif ( ! empty( $control_data['responsive']['min'] ) ) {
				$device = $control_data['responsive']['min'];
			}

			$preset_id   = ! empty( $control_value['tp_global_preset'] ) ? $control_value['tp_global_preset'] : '';
			$control_name = isset( $control_data['name'] ) ? $control_data['name'] : '';
			$base_name    = self::get_base_control_name( $control_name );

			if ( ! empty( $preset_id ) ) {
				// Store for child controls (tablet / mobile) to inherit.
				self::$resolved_presets[ $base_name ] = $preset_id;
			} elseif ( 'desktop' === $device ) {
				// Desktop with no preset — clear any stale entry left by a previous widget
				// sharing the same base control name (e.g. two widgets both using `border_radius`).
				// Without this, that widget's tablet/mobile would silently inherit the prior preset.
				unset( self::$resolved_presets[ $base_name ] );
			} else {
				// Tablet / Mobile with no preset — inherit from this widget's desktop if available.
				$preset_id = isset( self::$resolved_presets[ $base_name ] ) ? self::$resolved_presets[ $base_name ] : '';
			}

			if ( ! empty( $preset_id ) ) {
				$preset_values = TP_Dimensions_Global::get_preset_raw_values( $preset_id, $device );

				if ( ! empty( $preset_values ) ) {
					if ( 'UNIT' === $css_property ) {
						return ! empty( $preset_values['unit'] ) ? $preset_values['unit'] : 'px';
					}

					$dimension_key = strtolower( $css_property );

					if ( isset( $preset_values[ $dimension_key ] ) ) {
						$val = $preset_values[ $dimension_key ];

						// Ensure 0 and '0' are returned as '0', not as empty string.
						// Elementor skips CSS generation when get_style_value returns ''.
						if ( '' === $val || null === $val ) {
							return '0';
						}

						return $val;
					}

					// Dimension key not found in preset — default to 0.
					return '0';
				}
			}

			return parent::get_style_value( $css_property, $control_value, $control_data );
		}

		/**
		 * Enqueue editor JS for live toggle of dimension inputs.
		 *
		 * @since v6.5.0
		 */
		public function enqueue() {
			if ( did_action( 'tp_global_dim_editor_js' ) ) {
				return;
			}

			do_action( 'tp_global_dim_editor_js' );

			wp_add_inline_script( 'elementor-editor', '
				( function () {
					var tpSyncing = false;
					var tpDeviceSuffixes = [ "_mobile_extra", "_mobile", "_tablet_extra", "_tablet", "_laptop", "_widescreen" ];

					function tpDimToggle( wrap ) {
						var select = wrap.querySelector( ".tp-global-dim-select" );
						if ( ! select ) return;

						var dims  = wrap.querySelector( ".tp-native-dim-inputs" ),
							units = wrap.querySelector( ".e-units-wrapper" ),
							hide  = select.value !== "";

						if ( dims ) dims.style.display = hide ? "none" : "";
						if ( units ) units.style.display = hide ? "none" : "";
					}

					/**
					 * Get the Elementor control name from the wrapper element.
					 * The wrapper has a class like "elementor-control-box_padding_tablet".
					 */
					function tpGetControlName( wrap ) {
						var classes = wrap.className.split( /\\s+/ );

						for ( var i = 0; i < classes.length; i++ ) {
							var cls = classes[ i ];

							if ( cls.indexOf( "elementor-control-" ) !== 0 || cls === "elementor-control" ) continue;
							if ( cls.indexOf( "elementor-control-type-" ) === 0 ) continue;
							if ( cls.indexOf( "elementor-control-responsive-" ) === 0 ) continue;
							if ( cls.indexOf( "elementor-control-dynamic-" ) === 0 ) continue;

							return cls.replace( "elementor-control-", "" );
						}

						return "";
					}

					/**
					 * Strip device suffix to get the base (desktop) control name.
					 */
					function tpBaseName( name ) {
						for ( var i = 0; i < tpDeviceSuffixes.length; i++ ) {
							var s = tpDeviceSuffixes[ i ];

							if ( name.length > s.length && name.slice( -s.length ) === s ) {
								return name.slice( 0, -s.length );
							}
						}

						return name;
					}

					/**
					 * Sync the preset value to responsive sibling controls of the SAME control.
					 * Uses the control wrapper class to match, e.g.:
					 *   box_padding  →  box_padding_tablet, box_padding_mobile
					 */
					function tpSyncSiblings( changedSelect, newVal ) {
						var wrap = changedSelect.closest( ".elementor-control" );
						if ( ! wrap ) return;

						var controlName = tpGetControlName( wrap );
						if ( ! controlName ) return;

						var baseName  = tpBaseName( controlName );
						var container = wrap.closest( ".elementor-controls-stack" );
						if ( ! container ) return;

						var suffixes = [ "", "_tablet", "_mobile", "_tablet_extra", "_mobile_extra", "_laptop", "_widescreen" ];

						suffixes.forEach( function ( suffix ) {
							var sibName = baseName + suffix;
							if ( sibName === controlName ) return;

							var sibWrap = container.querySelector( ".elementor-control-" + sibName );
							if ( ! sibWrap ) return;

							var sibSelect = sibWrap.querySelector( ".tp-global-dim-select" );
							if ( ! sibSelect || sibSelect.value === newVal ) return;

							sibSelect.value = newVal;
							sibSelect.dispatchEvent( new Event( "input",  { bubbles: true } ) );
							sibSelect.dispatchEvent( new Event( "change", { bubbles: true } ) );
						} );
					}

					// Event delegation — live toggle + sync to same-control siblings only.
					document.addEventListener( "change", function ( e ) {
						if ( ! e.target.classList.contains( "tp-global-dim-select" ) ) return;

						var wrap = e.target.closest( ".elementor-control" );
						if ( wrap ) tpDimToggle( wrap );

						if ( tpSyncing ) return;
						tpSyncing = true;
						tpSyncSiblings( e.target, e.target.value );
						tpSyncing = false;
					} );

					// MutationObserver — handles initial render and re-renders.
					var observer = new MutationObserver( function ( mutations ) {
						mutations.forEach( function ( m ) {
							m.addedNodes.forEach( function ( node ) {
								if ( node.nodeType !== 1 ) return;

								var selects = node.querySelectorAll
									? node.querySelectorAll( ".tp-global-dim-select" )
									: [];

								selects.forEach( function ( sel ) {
									var wrap = sel.closest( ".elementor-control" );
									if ( wrap ) tpDimToggle( wrap );
								} );
							} );
						} );
					} );

					observer.observe( document.body, { childList: true, subtree: true } );
				} )();
			' );
		}

		/**
		 * Render dimensions control output in the editor.
		 * Used to generate the control HTML in the editor using Underscore JS template.
		 *
		 * @since v6.5.0
		 */
		public function content_template() {
			$class_name = $this->get_singular_name();
			?>
			<div class="elementor-control-field">
				<label class="elementor-control-title">{{{ data.label }}}</label>
				<?php $this->print_units_template(); ?>
				<div class="elementor-control-input-wrapper">
					
					<#
					var tpIsKitControl = data.name.indexOf( 'tdm_values' ) !== -1;
					var tpShowPreset = ! tpIsKitControl;
					#>
					<# if ( tpShowPreset ) { #>
					<div class="tp-global-dim-select-wrapper" style="margin-bottom: 8px;">
						<select data-setting="tp_global_preset" class="tp-global-dim-select" style="width: 100%; border-radius: 3px; font-size: 11px;">
							<option value=""><?php esc_html_e( 'None', 'tpebl' ); ?></option>
							<?php
							if ( class_exists( 'ThePlusAddons\Elementor\Dimensions\TP_Dimensions_Global' ) ) {
								$presets = TP_Dimensions_Global::get_global_dimensions_list();
								if ( ! empty( $presets ) ) {
									foreach ( $presets as $preset ) {
										$id    = ! empty( $preset['_id'] ) ? $preset['_id'] : '';
										$title = ! empty( $preset['name'] ) ? $preset['name'] : 'Unnamed';
										if ( '' === $id ) {
											continue;
										}
										echo '<option value="' . esc_attr( $id ) . '">' . esc_html( $title ) . '</option>';
									}
								}
							}
							?>
						</select>
					</div>
					<# } #>

					<ul class="elementor-control-<?php echo esc_attr( $class_name ); ?>s tp-native-dim-inputs" <# if ( tpShowPreset && data.controlValue && data.controlValue.tp_global_preset ) { #> style="display:none;" <# } #> <# if ( tpIsKitControl ) { #> data-tp-kit="1" <# } #>>
						<?php foreach ( $this->get_dimensions() as $dimension_key => $dimension_title ) : ?>
							<li class="elementor-control-<?php echo esc_attr( $class_name ); ?>">
								<input id="<?php $this->print_control_uid( $dimension_key ); ?>" type="text" data-setting="<?php
									echo esc_attr( $dimension_key );
								?>" placeholder="<#
										placeholder = view.getControlPlaceholder();
										if ( _.isObject( placeholder ) && ! _.isUndefined( placeholder.<?php echo esc_attr( $dimension_key ); ?> ) ) {
												print( encodeURIComponent( placeholder.<?php echo esc_attr( $dimension_key ); ?> ) );
										} else {
											print( placeholder ? encodeURIComponent( placeholder ) : '' );
										} #>"
								<# if ( -1 === _.indexOf( allowed_dimensions, '<?php echo esc_attr( $dimension_key ); ?>' ) ) { #>
									disabled
								<# } #>
										/>
								<label for="<?php $this->print_control_uid( $dimension_key ); ?>" class="elementor-control-<?php echo esc_attr( $class_name ); ?>-label"><?php
									echo esc_html( $dimension_title );
								?></label>
							</li>
						<?php endforeach; ?>
						<li>
							<button class="elementor-link-<?php echo esc_attr( $class_name ); ?>s tooltip-target" data-tooltip="<?php echo esc_attr__( 'Link values together', 'elementor' ); ?>">
								<span class="elementor-linked">
									<i class="eicon-link" aria-hidden="true"></i>
									<span class="elementor-screen-only"><?php echo esc_html__( 'Link values together', 'elementor' ); ?></span>
								</span>
								<span class="elementor-unlinked">
									<i class="eicon-chain-broken" aria-hidden="true"></i>
									<span class="elementor-screen-only"><?php echo esc_html__( 'Unlinked values', 'elementor' ); ?></span>
								</span>
							</button>
						</li>
					</ul>
				</div>
			</div>
			
			<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
			<# } #>
			<?php
		}
	}
}
