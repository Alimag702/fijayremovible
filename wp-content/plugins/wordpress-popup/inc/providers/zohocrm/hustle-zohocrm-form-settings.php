<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Hustle_ZohoCRM_Form_Settings class
 *
 * @package Hustle
 */

/**
 * Class Hustle_ZohoCRM_Form_Settings
 */
class Hustle_ZohoCRM_Form_Settings extends Hustle_Provider_Form_Settings_Abstract {

	/**
	 * Zoho CRM provider instance.
	 *
	 * Redeclared here to narrow the type from Hustle_Provider_Abstract so that
	 * static analysers resolve the api() method without inline type hints.
	 *
	 * @var Hustle_ZohoCRM
	 */
	protected $provider;

	/**
	 * Options required for the form integration to be considered connected.
	 *
	 * @var array
	 */
	protected $form_completion_options = array( 'tag_id' );

	/**
	 * Form settings wizard: single step for tag selection.
	 *
	 * @return array
	 */
	public function form_settings_wizards() {
		return array(
			array(
				'callback'     => array( $this, 'tag_step' ),
				'is_completed' => array( $this, 'tag_step_completed' ),
			),
		);
	}

	// -----------------------------------------------------------------------
	// Tag selection step
	// -----------------------------------------------------------------------

	/**
	 * Render / handle the tag selection step.
	 *
	 * Fetches the tags defined for the Leads module in Zoho CRM and presents a
	 * dropdown so the admin can optionally tag every Lead created by this form.
	 * Choosing "None" creates the Lead without any tag.
	 *
	 * @param array $submitted_data Submitted data.
	 * @return array
	 */
	public function tag_step( $submitted_data ) {
		$saved     = $this->get_form_settings_values();
		$is_submit = ! empty( $submitted_data['hustle_is_submit'] );

		if ( $is_submit ) {
			$tag_id = isset( $submitted_data['tag_id'] )
			? sanitize_text_field( $submitted_data['tag_id'] )
			: 'none';
			$this->save_form_settings_values( array( 'tag_id' => $tag_id ) );
			return array(
				'html'       => '',
				'has_errors' => false,
			);
		}

		$tags       = $this->provider->api()->get_tags();
		$current_id = $saved['tag_id'] ?? 'none';

		$options_list = array( 'none' => __( '— None —', 'hustle' ) ) + $tags;

		$options = array(
			array(
				'type'     => 'wrapper',
				'elements' => array(
					'label'   => array(
						'type'  => 'label',
						'for'   => 'zohocrm_tag_id',
						'value' => __( 'Tag', 'hustle' ),
					),
					'wrapper' => array(
						'type'                 => 'wrapper',
						'is_not_field_wrapper' => true,
						'class'                => 'hui-select-refresh',
						'elements'             => array(
							'select'  => array(
								'type'     => 'select',
								'name'     => 'tag_id',
								'id'       => 'zohocrm_tag_id',
								'class'    => 'sui-select',
								'value'    => $current_id,
								'selected' => $current_id,
								'options'  => $options_list,
							),
							'refresh' => array(
								'type'  => 'raw',
								'value' => Hustle_Provider_Utils::get_provider_button_markup( __( 'Refresh', 'hustle' ), '', 'refresh_list', true ),
							),
						),
					),
					'desc'    => array(
						'type'  => 'description',
						'value' => __( 'Optionally, apply a tag to every contact created by this form.', 'hustle' ),
					),
				),
			),
		);

		$html  = Hustle_Provider_Utils::get_integration_modal_title_markup(
			__( 'Zoho CRM Settings', 'hustle' ),
			__( 'Form submissions will create a contact in Zoho CRM. Optionally tag the contact using a tag defined in your Zoho CRM account.', 'hustle' )
		);
		$html .= Hustle_Provider_Utils::get_html_for_options( $options );

		$is_connected = $this->provider->is_form_connected( $this->module_id );
		$buttons      = array();

		if ( $is_connected ) {
			$buttons['disconnect'] = array(
				'markup' => Hustle_Provider_Utils::get_provider_button_markup(
					__( 'Disconnect', 'hustle' ),
					'sui-button-ghost',
					'disconnect_form',
					true
				),
			);
		}

		$buttons['save'] = array(
			'markup' => Hustle_Provider_Utils::get_provider_button_markup(
				__( 'Save', 'hustle' ),
				$is_connected ? '' : 'sui-button-right',
				'next',
				true
			),
		);

		return array(
			'html'    => $html,
			'buttons' => $buttons,
		);
	}

	/**
	 * Whether the tag selection step has been completed.
	 *
	 * True as soon as any value (including 'none') has been saved.
	 *
	 * @return bool
	 */
	public function tag_step_completed() {
		$saved = $this->get_form_settings_values();
		return isset( $saved['tag_id'] );
	}

	// -----------------------------------------------------------------------
	// Refresh lists (clears the cached tags)
	// -----------------------------------------------------------------------

	/**
	 * Purge the cached tags list so the dropdown refreshes on next render.
	 *
	 * @param string $module_id Hustle module ID (unused).
	 * @return array
	 */
	public function refresh_global_multi_lists( $module_id ) {
		delete_transient( 'hustle_zohocrm_tags' );
		return array();
	}
}
