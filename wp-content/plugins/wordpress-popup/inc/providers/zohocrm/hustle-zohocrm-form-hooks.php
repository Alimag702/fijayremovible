<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Hustle_ZohoCRM_Form_Hooks class
 *
 * @package Hustle
 */

/**
 * Class Hustle_ZohoCRM_Form_Hooks
 */
class Hustle_ZohoCRM_Form_Hooks extends Hustle_Provider_Form_Hooks_Abstract {

	/**
	 * Zoho CRM provider instance.
	 *
	 * Redeclared here to narrow the type from Hustle_Provider_Abstract so that
	 * static analysers resolve the api() method without inline type hints.
	 *
	 * @var Hustle_ZohoCRM
	 */
	protected $addon;

	/**
	 * Called on form submission. Maps form fields to Zoho CRM Contact fields and
	 * creates or updates a Contact record, de-duplicating by email.
	 *
	 * Standard fields (email, phone, etc.) are mapped directly to built-in Zoho
	 * Contact API names. Any remaining Hustle form fields are written to custom
	 * Zoho fields, which are created automatically on the first submission.
	 *
	 * @param array $submitted_data Submitted form data.
	 * @return array
	 */
	public function add_entry_fields( $submitted_data ) {
		$module_id              = $this->module_id;
		$form_settings_instance = $this->form_settings_instance;

		/**
		 * Filter submitted form data to be processed.
		 *
		 * @param array                          $submitted_data
		 * @param int                            $module_id
		 * @param Hustle_ZohoCRM_Form_Settings   $form_settings_instance
		 */
		$submitted_data = apply_filters(
			'hustle_provider_zohocrm_form_submitted_data',
			$submitted_data,
			$module_id,
			$form_settings_instance
		);

		$settings = $form_settings_instance->get_form_settings_values();
		$tag_id   = $settings['tag_id'] ?? 'none';

		[ $record, $custom_fields ] = $this->map_to_zoho_fields( $submitted_data );

		if ( empty( $record ) && empty( $custom_fields ) ) {
			return array();
		}

		$api = $this->addon->api();

		// For each custom form field, ensure the Zoho custom field exists
		// (creating it when missing) then add its value to the record.
		foreach ( $custom_fields as $label => $field ) {
			$api_name = $api->ensure_custom_field( 'Contacts', $label, $field['data_type'] );
			if ( is_wp_error( $api_name ) ) {
				Hustle_Provider_Utils::maybe_log(
					$this->addon->get_slug(),
					__METHOD__,
					$api_name->get_error_message()
				);
				continue;
			}
			$record[ $api_name ] = $field['value'];
		}

		/**
		 * Fires before creating or updating the Zoho CRM Contact.
		 *
		 * @param int                          $module_id
		 * @param array                        $submitted_data
		 * @param Hustle_ZohoCRM_Form_Settings $form_settings_instance
		 */
		do_action(
			'hustle_provider_zohocrm_before_add_subscriber',
			$module_id,
			$submitted_data,
			$form_settings_instance
		);

		$email    = $record['Email'] ?? null;
		$existing = ! empty( $email ) ? $api->search_record_by_email( 'Contacts', $email ) : null;

		if ( $existing ) {
			$result    = $api->update_record( 'Contacts', $existing, $record );
			$record_id = is_wp_error( $result ) ? null : $existing;
		} else {
			$result    = $api->create_record( 'Contacts', $record );
			$record_id = is_wp_error( $result ) ? null : $result;
		}

		/**
		 * Fires after creating or updating the Zoho CRM Contact.
		 *
		 * @param int                          $module_id
		 * @param array                        $submitted_data
		 * @param mixed                        $result
		 * @param Hustle_ZohoCRM_Form_Settings $form_settings_instance
		 */
		do_action(
			'hustle_provider_zohocrm_after_add_subscriber',
			$module_id,
			$submitted_data,
			$result,
			$form_settings_instance
		);

		if ( is_wp_error( $result ) ) {
			Hustle_Provider_Utils::maybe_log(
				$this->addon->get_slug(),
				__METHOD__,
				$result->get_error_message()
			);
			$entry_fields = array(
				array(
					'name'  => 'status',
					'value' => array(
						'is_sent'       => false,
						'description'   => $result->get_error_message(),
						'member_status' => __( 'Contact could not be saved.', 'hustle' ),
					),
				),
			);
		} else {
			// Apply the selected tag, replacing any existing tags on the contact.
			if ( ! empty( $record_id ) ) {
				if ( ! empty( $tag_id ) && 'none' !== $tag_id ) {
					// over_write=true in add_tag_to_record replaces existing tags in one call.
					$tag_result = $api->add_tag_to_record( $tag_id, $record_id );
				} else {
					// 'None' selected: strip any tags already on the contact.
					$tag_result = $api->remove_all_tags_from_record( $record_id );
				}

				if ( is_wp_error( $tag_result ) ) {
					Hustle_Provider_Utils::maybe_log(
						$this->addon->get_slug(),
						__METHOD__,
						$tag_result->get_error_message()
					);
				}
			}

			$entry_fields = array(
				array(
					'name'  => 'status',
					'value' => array(
						'is_sent'       => true,
						'description'   => $existing
							? __( 'Successfully updated Contact in Zoho CRM.', 'hustle' )
							: __( 'Successfully created Contact in Zoho CRM.', 'hustle' ),
						'member_status' => __( 'OK', 'hustle' ),
					),
				),
			);
		}

		$entry_fields = apply_filters(
			'hustle_provider_zohocrm_entry_fields',
			$entry_fields,
			$module_id,
			$submitted_data,
			$form_settings_instance
		);

		return $entry_fields;
	}

	/**
	 * Called when a user unsubscribes. Finds the Contact by email and removes
	 * all tags from it.
	 *
	 * @param string $email The email address of the user unsubscribing.
	 */
	public function unsubscribe( $email ) {
		if ( empty( $email ) ) {
			return;
		}

		$api       = $this->addon->api();
		$record_id = $api->search_record_by_email( 'Contacts', $email );

		if ( $record_id ) {
			$result = $api->remove_all_tags_from_record( $record_id );

			if ( is_wp_error( $result ) ) {
				Hustle_Provider_Utils::maybe_log(
					$this->addon->get_slug(),
					__METHOD__,
					$result->get_error_message()
				);
			}
		}
	}

	/**
	 * Map submitted form fields to Zoho CRM Contact API names.
	 *
	 * Loads the module's field definitions so that each field's display label
	 * and Hustle type are used rather than guessing from the runtime value.
	 *
	 * Standard Hustle field names (email, phone, etc.) are mapped directly to
	 * built-in Zoho Contact API names and returned in $record.
	 *
	 * All other form fields (custom fields) are returned in $custom_fields as
	 * an associative array of:
	 *   [ field_label => [ 'data_type' => zoho_type, 'value' => sanitized_value ] ]
	 *
	 * Zoho Contacts require Last_Name; it falls back to the email local-part.
	 *
	 * @param array $submitted_data Raw submitted form data.
	 * @return array Two-element list: [ $record, $custom_fields ].
	 */
	private function map_to_zoho_fields( $submitted_data ) {
		$known_map = array(
			'email'        => 'Email',
			'first_name'   => 'First_Name',
			'fname'        => 'First_Name',
			'last_name'    => 'Last_Name',
			'lname'        => 'Last_Name',
			'name'         => 'Last_Name',
			'full_name'    => 'Last_Name',
			'phone'        => 'Phone',
			'mobile'       => 'Mobile',
			'company'      => 'Company',
			'organization' => 'Company',
			'website'      => 'Website',
			'message'      => 'Description',
			'description'  => 'Description',
			'comments'     => 'Description',
			'comment'      => 'Description',
		);

		$module        = Hustle_Module_Model::new_instance( $this->module_id );
		$module_fields = ! is_wp_error( $module ) ? ( $module->get_form_fields() ?? array() ) : array();
		$ignored       = Hustle_Entry_Model::ignored_fields();

		$record        = array();
		$custom_fields = array();

		foreach ( $submitted_data as $field_name => $value ) {
			if ( '' === $value || is_array( $value ) ) {
				continue;
			}
			$value = sanitize_text_field( $value );

			// Known standard fields map directly to Zoho Contact API names.
			$zoho_key = $known_map[ strtolower( $field_name ) ] ?? null;
			if ( $zoho_key ) {
				$record[ $zoho_key ] = $value;
				continue;
			}

			// For custom fields, use the module field definition for label and type.
			if ( ! isset( $module_fields[ $field_name ] ) ) {
				continue;
			}

			$field_def = $module_fields[ $field_name ];

			if ( in_array( $field_def['type'], $ignored, true ) ) {
				continue;
			}

			$label = $field_def['label'] ?? $field_name;

			$custom_fields[ $label ] = array(
				'data_type' => $this->hustle_type_to_zoho_type( $field_def['type'] ),
				'value'     => $value,
			);
		}

		// Zoho Contacts require Last_Name; fall back to the email local-part.
		if ( empty( $record['Last_Name'] ) && ! empty( $record['Email'] ) ) {
			$local               = strstr( $record['Email'], '@', true );
			$record['Last_Name'] = ! empty( $local ) ? $local : $record['Email'];
		}

		return array( $record, $custom_fields );
	}

	/**
	 * Map a Hustle form field type to the corresponding Zoho CRM data type.
	 *
	 * Only simple scalar types that require no extra body keys are returned.
	 * Complex Hustle types (select, radio, checkbox, textarea) are stored as
	 * plain 'text' fields to avoid mandatory extra parameters in the Zoho API.
	 *
	 * @param string $hustle_type Hustle field type (e.g. 'email', 'phone', 'datepicker').
	 * @return string Zoho CRM data type string.
	 */
	private function hustle_type_to_zoho_type( $hustle_type ) {
		switch ( $hustle_type ) {
			case 'email':
				return 'email';
			case 'phone':
				return 'phone';
			case 'number':
				return 'integer';
			case 'datepicker':
				return 'date';
			case 'website':
				return 'website';
			default:
				return 'text';
		}
	}
}
