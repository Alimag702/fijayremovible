<?php
/**
 * Hustle Turnstile API Keys Settings Template.
 *
 * @package Hustle
 * @since 7.8.13
 */

?>
<div class="sui-form-field">

	<label for="hustle-turnstile-api-key" id="hustle-turnstile-api-key-label" class="sui-label">
		<?php esc_html_e( 'API Key (Site Key)', 'hustle' ); ?>
	</label>

	<input
		type="text"
		name="turnstile_api_key"
		value="<?php echo esc_attr( $settings['turnstile_api_key'] ); ?>"
		placeholder="<?php esc_html_e( 'Enter your Turnstile site key here', 'hustle' ); ?>"
		id="hustle-turnstile-api-key"
		class="sui-form-control"
		aria-labelledby="hustle-turnstile-api-key-label"
	/>
	<span class="sui-description"><?php esc_html_e( 'The site key is used to render the Turnstile widget on your opt-in forms. You can find it in your Cloudflare Turnstile dashboard.', 'hustle' ); ?></span>

</div>

<div class="sui-form-field">

	<label for="hustle-turnstile-client-secret" id="hustle-turnstile-client-secret-label" class="sui-label">
		<?php esc_html_e( 'Client Secret Key', 'hustle' ); ?>
	</label>

	<input
		type="password"
		name="turnstile_client_secret"
		value="<?php echo esc_attr( $settings['turnstile_client_secret'] ); ?>"
		placeholder="<?php esc_html_e( 'Enter your Turnstile secret key here', 'hustle' ); ?>"
		id="hustle-turnstile-client-secret"
		class="sui-form-control"
		aria-labelledby="hustle-turnstile-client-secret-label"
	/>
	<span class="sui-description"><?php esc_html_e( 'The secret key is used for server-side verification. Keep it private and never expose it publicly.', 'hustle' ); ?></span>

</div>
<div class="sui-form-field" data-id="checkbox" data-render-id="0">

	<label class="sui-label"><?php esc_html_e( 'Turnstile Captcha Preview', 'hustle' ); ?></label>

	<div
		id="hustle-modal-turnstile-captcha-0"
		class="hustle-turnstile-preview-container hustle-turnstile"
		style="display: none;"
		data-sitekey=""
		data-theme="light"
		data-size="normal"
		data-language="<?php echo isset( $settings['language'] ) ? esc_attr( $settings['language'] ) : 'auto'; ?>"
	></div>

	<?php
		$this->get_html_for_options(
			array(
				array(
					'type'       => 'inline_notice',
					'class'      => 'hustle-turnstile-captcha-0-preview-notice',
					'icon'       => 'info',
					'value'      => esc_html__( 'Save your API keys to load the Turnstile preview.', 'hustle' ),
					'attributes' => array(
						'style' => 'margin-top: 0;',
					),
				),
			)
		);
		?>
</div>