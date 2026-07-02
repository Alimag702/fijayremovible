<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Hustle_Newsletter_Form_Hooks class
 *
 * @package Hustle
 */

/**
 * Class Hustle_Newsletter_Form_Hooks
 * Define the form hooks that are used by the Newsletter integration.
 */
class Hustle_Newsletter_Form_Hooks extends Hustle_Provider_Form_Hooks_Abstract {

	/**
	 * Add Newsletter data to the entry after form submission.
	 *
	 * @param array $submitted_data Submitted data.
	 * @throws Exception Required fields are missing.
	 * @return array
	 */
	public function add_entry_fields( $submitted_data ) {

		if ( ! class_exists( 'NewsletterSubscription' ) || ! class_exists( 'Newsletter' ) ) {
			throw new Exception(
				esc_html__(
					'Newsletter plugin classes not found. Please ensure the Newsletter plugin is installed and activated.',
					'hustle'
				)
			);
		}

		$module_id              = $this->module_id;
		$form_settings_instance = $this->form_settings_instance;

		/**
		 * Filter submitted form data before processing.
		 *
		 * @since 7.8.13
		 *
		 * @param array                              $submitted_data
		 * @param int                                $module_id
		 * @param Hustle_Newsletter_Form_Settings    $form_settings_instance
		 */
		$submitted_data = apply_filters(
			'hustle_provider_newsletter_form_submitted_data',
			$submitted_data,
			$module_id,
			$form_settings_instance
		);

		$addon_setting_values = $form_settings_instance->get_form_settings_values();

		try {
			if ( empty( $submitted_data['email'] ) ) {
				throw new Exception( __( 'Required Field "email" was not filled by the user.', 'hustle' ) );
			}

			$submitted_data = $this->check_legacy( $submitted_data );

			$subscription              = NewsletterSubscription::instance()->get_default_subscription();
			$subscription->data->email = $submitted_data['email'];
			$subscription->spamcheck   = false;
			$subscription->send_emails = true;

			if ( ! empty( $submitted_data['first_name'] ) ) {
				$subscription->data->name = $submitted_data['first_name'];
			}

			if ( ! empty( $submitted_data['last_name'] ) ) {
				$subscription->data->surname = $submitted_data['last_name'];
			}

			// Map custom (profile) fields: match by "profile_N" key or by slugified field name.
			$custom_fields = Newsletter::instance()->get_customfields();
			$mapped_keys   = array();
			foreach ( $custom_fields as $field_id => $field ) {
				$key_by_id   = 'profile_' . $field_id;
				$key_by_name = sanitize_title( $field->name );

				if ( isset( $submitted_data[ $key_by_id ] ) && '' !== $submitted_data[ $key_by_id ] ) {
					$subscription->data->profiles[ '' . $field_id ] = $submitted_data[ $key_by_id ];

					$mapped_keys[] = $key_by_id;
				} elseif ( isset( $submitted_data[ $key_by_name ] ) && '' !== $submitted_data[ $key_by_name ] ) {
					$subscription->data->profiles[ '' . $field_id ] = $submitted_data[ $key_by_name ];

					$mapped_keys[] = $key_by_name;
				} else {
					$subscription->data->profiles[ '' . $field_id ] = ''; // Ensure all profile fields are set, even if empty.
				}
			}

			// Auto-create Newsletter profile fields for any extra submitted fields not yet mapped.
			$extra_fields = $this->get_extra_fields( $submitted_data );
			foreach ( $extra_fields as $key => $value ) {
				if ( '' === $value || in_array( $key, $mapped_keys, true ) ) {
					continue;
				}
				$profile_id = $this->get_or_create_profile_field( $key );
				if ( $profile_id ) {
					$subscription->data->profiles[ '' . $profile_id ] = $value;
				}
			}

			if ( ! empty( $addon_setting_values['list_id'] ) ) {
				$subscription->data->lists[ '' . $addon_setting_values['list_id'] ] = 1;
			}

			/**
			 * Fires before adding a subscriber.
			 *
			 * @param int                             $module_id
			 * @param array                           $submitted_data
			 * @param Hustle_Newsletter_Form_Settings $form_settings_instance
			 */
			do_action(
				'hustle_provider_newsletter_before_add_subscriber',
				$module_id,
				$submitted_data,
				$form_settings_instance
			);

			$result = NewsletterSubscription::instance()->subscribe2( $subscription );

			/**
			 * Fires after adding a subscriber.
			 *
			 * @param int                             $module_id
			 * @param array                           $submitted_data
			 * @param TNP_User|WP_Error               $result
			 * @param Hustle_Newsletter_Form_Settings $form_settings_instance
			 */
			do_action(
				'hustle_provider_newsletter_after_add_subscriber',
				$module_id,
				$submitted_data,
				$result,
				$form_settings_instance
			);

			if ( is_wp_error( $result ) ) {
				$entry_fields = array(
					array(
						'name'  => 'status',
						'value' => array(
							'is_sent'       => false,
							'description'   => $result->get_error_message(),
							'data_sent'     => $submitted_data,
							'data_received' => array(),
							'member_status' => __( 'Member could not be subscribed.', 'hustle' ),
							'list_name'     => isset( $addon_setting_values['list_name'] ) ? $addon_setting_values['list_name'] : '',
						),
					),
				);
			} else {
				$entry_fields = array(
					array(
						'name'  => 'status',
						'value' => array(
							'is_sent'       => true,
							'description'   => __( 'Successfully subscribed to Newsletter list', 'hustle' ),
							'data_sent'     => $submitted_data,
							'data_received' => array(
								'id'     => $result->id,
								'status' => $result->status,
							),
							'member_status' => 'C' === $result->status ? __( 'Subscribed', 'hustle' ) : __( 'Pending', 'hustle' ),
							'list_name'     => isset( $addon_setting_values['list_name'] ) ? $addon_setting_values['list_name'] : '',
						),
					),
				);
			}
		} catch ( Exception $e ) {
			$entry_fields = $this->exception( $e );
		}

		$entry_fields = apply_filters(
			'hustle_provider_newsletter_entry_fields',
			$entry_fields,
			$module_id,
			$submitted_data,
			$form_settings_instance
		);

		return $entry_fields;
	}

	/**
	 * Unsubscribe an email address from the configured list.
	 *
	 * @param string $email Email address.
	 */
	public function unsubscribe( $email ) {
		$form_settings_instance = $this->form_settings_instance;
		$addon_setting_values   = $form_settings_instance->get_form_settings_values();
		$list_id                = isset( $addon_setting_values['list_id'] ) ? (int) $addon_setting_values['list_id'] : 0;

		try {
			$newsletter = Newsletter::instance();
			$user       = $newsletter->get_user_by_email( $email );

			if ( empty( $user ) ) {
				return false;
			}

			if ( $list_id ) {
				$newsletter->set_user_list( $user, $list_id, 0 );
			}
		} catch ( Exception $e ) {
			Opt_In_Utils::maybe_log( $this->addon->get_slug(), 'unsubscription failed', $e->getMessage() );
		}
	}

	/**
	 * Validate the form submission before processing.
	 *
	 * @param array $submitted_data      Submitted data.
	 * @param bool  $allow_subscribed    Allow already-subscribed emails.
	 * @return bool|string True on success, error message string on failure.
	 */
	public function on_form_submit( $submitted_data, $allow_subscribed = true ) {

		$is_success             = true;
		$module_id              = $this->module_id;
		$form_settings_instance = $this->form_settings_instance;
		$addon                  = $this->addon;

		if ( empty( $submitted_data['email'] ) ) {
			return __( 'Required Field "email" was not filled by the user.', 'hustle' );
		}

		if ( ! $allow_subscribed ) {

			/**
			 * Filter submitted form data before duplicate validation.
			 *
			 * @param array                           $submitted_data
			 * @param int                             $module_id
			 * @param Hustle_Newsletter_Form_Settings $form_settings_instance
			 */
			$submitted_data = apply_filters(
				'hustle_provider_newsletter_form_submitted_data_before_validation',
				$submitted_data,
				$module_id,
				$form_settings_instance
			);

			$existing = $this->get_subscriber( $addon, $submitted_data['email'] );
			if ( $existing ) {
				$is_success = self::ALREADY_SUBSCRIBED_ERROR;
			}
		}

		/**
		 * Filter the final validation result.
		 *
		 * @param bool|string                     $is_success
		 * @param int                             $module_id
		 * @param array                           $submitted_data
		 * @param Hustle_Newsletter_Form_Settings $form_settings_instance
		 */
		$is_success = apply_filters(
			'hustle_provider_newsletter_form_submitted_data_after_validation',
			$is_success,
			$module_id,
			$submitted_data,
			$form_settings_instance
		);

		if ( true !== $is_success ) {
			if ( ! empty( $is_success ) ) {
				$this->submit_form_error_message = (string) $is_success;
			}
			return $is_success;
		}

		return true;
	}

	/**
	 * Return the Newsletter profile field ID for the given name, creating it if it doesn't exist.
	 *
	 * Custom field definitions are stored in the WordPress option `newsletter_customfields`
	 * as a flat associative array: profile_N, profile_N_type, profile_N_status.
	 *
	 * @param string $field_name Hustle form field key used as the profile name.
	 * @return int|null Profile slot ID on success, null when all slots are taken.
	 */
	private function get_or_create_profile_field( $field_name ) {
		$options = get_option( 'newsletter_customfields', array() );
		if ( ! is_array( $options ) ) {
			$options = array();
		}

		$slug = sanitize_title( $field_name );

		// Return the slot ID if a field with the same (slugified) name already exists.
		for ( $i = 1; $i <= NEWSLETTER_PROFILE_MAX; $i++ ) {
			if ( ! empty( $options[ 'profile_' . $i ] ) && sanitize_title( $options[ 'profile_' . $i ] ) === $slug ) {
				return $i;
			}
		}

		// Find the first free slot and create the field.
		for ( $i = 1; $i <= NEWSLETTER_PROFILE_MAX; $i++ ) {
			if ( empty( $options[ 'profile_' . $i ] ) ) {
				$options[ 'profile_' . $i ]              = $field_name;
				$options[ 'profile_' . $i . '_type' ]    = 'text';
				$options[ 'profile_' . $i . '_status' ]  = 0;
				$options[ 'profile_' . $i . '_options' ] = '';
				$options[ 'profile_' . $i . '_rules' ]   = '';

				$options[ 'profile_' . $i . '_placeholder' ] = '';
				update_option( 'newsletter_customfields', $options );
				return $i;
			}
		}

		return null; // All slots taken.
	}

	/**
	 * Cache and return the subscriber lookup result.
	 *
	 * @param object $api  Provider instance (unused; uses Newsletter::instance() directly).
	 * @param string $data Email address.
	 * @return TNP_User|null
	 */
	protected function get_subscriber( $api, $data ) {
		if ( empty( $this->subscriber ) || ! isset( $this->subscriber[ md5( $data ) ] ) ) {
			$this->subscriber[ md5( $data ) ] = $api->is_member( $data );
		}
		return $this->subscriber[ md5( $data ) ];
	}
}
