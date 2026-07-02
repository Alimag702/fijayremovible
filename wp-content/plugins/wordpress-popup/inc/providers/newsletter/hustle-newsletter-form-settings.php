<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName
/**
 * Hustle_Newsletter_Form_Settings class
 *
 * @package Hustle
 */

if ( ! class_exists( 'Hustle_Newsletter_Form_Settings' ) ) :

	/**
	 * Class Hustle_Newsletter_Form_Settings
	 */
	class Hustle_Newsletter_Form_Settings extends Hustle_Provider_Form_Settings_Abstract {

		/**
		 * Cached list labels keyed by list ID.
		 *
		 * @var array
		 */
		private $email_lists = array();

		/**
		 * Wizard step definitions.
		 *
		 * @return array
		 */
		public function form_settings_wizards() {
			return array(
				array(
					'callback'     => array( $this, 'first_step_callback' ),
					'is_completed' => array( $this, 'first_step_is_completed' ),
				),
			);
		}

		/**
		 * Check if the first step is completed.
		 *
		 * @return bool
		 */
		public function first_step_is_completed() {
			$this->addon_form_settings = $this->get_form_settings_values();

			if ( ! isset( $this->addon_form_settings['list_id'] ) ) {
				$this->addon_form_settings['list_id'] = '';
				return false;
			}

			return ! empty( $this->addon_form_settings['list_id'] );
		}

		/**
		 * Render and handle the first (and only) step of the per-module wizard.
		 *
		 * @param array $submitted_data Submitted data.
		 * @return array
		 */
		public function first_step_callback( $submitted_data ) {
			$this->addon_form_settings = $this->get_form_settings_values();

			$current_data = array(
				'list_id' => '',
			);
			$current_data = $this->get_current_data( $current_data, $submitted_data );
			$is_submit    = ! empty( $submitted_data['hustle_is_submit'] );

			if ( $is_submit && empty( $submitted_data['list_id'] ) ) {
				$error_message = __( 'The email list is required.', 'hustle' );
			}

			$options = $this->get_first_step_options( $current_data, $is_submit );

			$step_html  = Hustle_Provider_Utils::get_integration_modal_title_markup(
				__( 'Newsletter List', 'hustle' ),
				__( 'Select the Newsletter list new subscribers will be added to when they submit your form.', 'hustle' )
			);
			$step_html .= Hustle_Provider_Utils::get_html_for_options( $options );

			$has_errors = isset( $error_message );
			if ( $has_errors ) {
				$step_html .= '<span class="sui-error-message">' . esc_html( $error_message ) . '</span>';
			}

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

			$response = array(
				'html'       => $step_html,
				'buttons'    => $buttons,
				'has_errors' => $has_errors,
			);

			if ( $is_submit && ! $has_errors ) {
				$current_data['list_name'] = $this->get_selected_list_names( $current_data );
				$this->save_form_settings_values( $current_data );
			}

			return $response;
		}

		/**
		 * Build the options array for the first step.
		 *
		 * @param array $current_data Current data.
		 * @param bool  $is_submit    Whether this is a form submission.
		 * @return array
		 */
		private function get_first_step_options( $current_data, $is_submit ) {
			$lists = array();

			try {
				$raw_lists = $this->provider->get_lists();

				if ( ! empty( $raw_lists ) ) {
					foreach ( $raw_lists as $list ) {
						$lists[ $list->id ] = $list->name;
					}
					$this->email_lists = $lists;
				}
			} catch ( Exception $e ) {
				return array();
			}

			$selected_list = isset( $current_data['list_id'] ) ? $current_data['list_id'] : '';

			return array(
				array(
					'type'        => 'wrapper',
					'elements'    => array(
						array(
							'type'  => 'label',
							'value' => __( 'Email List', 'hustle' ),
						),
						array(
							'type'     => 'select',
							'name'     => 'list_id',
							'id'       => 'hustle-email-provider-lists',
							'selected' => $selected_list,
							'options'  => $lists,
						),
					),
					'description' => array(
						'type'  => 'description',
						'value' => __( 'Subscribers who complete your form will be added to this list.', 'hustle' ),
					),
				),
			);
		}

		/**
		 * Return the name of the selected list.
		 *
		 * @param array $current_data Current data with list_id scalar.
		 * @return string
		 */
		private function get_selected_list_names( $current_data ) {
			$id = $current_data['list_id'];
			if ( empty( $this->email_lists ) || empty( $id ) ) {
				return '';
			}

			return isset( $this->email_lists[ $id ] ) ? $this->email_lists[ $id ] : '';
		}
	}
endif;
