<?php
/**
 * Cloudflare Turnstile tab.
 *
 * @package Hustle
 * @since 4.0.0
 */

?>
<div id="turnstile-box" class="sui-box hustle-settings-tab-turnstile" data-tab="turnstile" <?php echo 'turnstile' !== $section ? 'style="display: none;"' : ''; ?>>

	<div class="sui-box-header">
		<h2 class="sui-box-title"><?php esc_html_e( 'Cloudflare Turnstile', 'hustle' ); ?></h2>
	</div>

	<div class="sui-box-body">

		<div class="sui-box-settings-row">

			<div class="sui-box-settings-col-1">
				<span class="sui-settings-label"><?php esc_html_e( 'Configure', 'hustle' ); ?></span>
				<span class="sui-description"><?php esc_html_e( 'Enter your Cloudflare Turnstile API key and client secret to enable Turnstile protection in your opt-in forms.', 'hustle' ); ?></span>
			</div>

			<div class="sui-box-settings-col-2">
				<div id="hustle-turnstile-script-container"></div>

				<form id="hustle-settings-turnstile-form">

					<?php
					// SETTINGS: API Keys.
					$this->render(
						'admin/settings/turnstile/api-keys',
						array( 'settings' => $settings )
					);
					?>

					<?php
					// SETTINGS: Language.
					$this->render(
						'admin/settings/turnstile/language',
						array( 'settings' => $settings )
					);
					?>
				</form>

			</div>
		</div>
	</div>
	<div class="sui-box-footer">

		<div class="sui-actions-right">

			<button
				class="sui-button sui-button-blue hustle-settings-save"
				data-form-id="hustle-settings-turnstile-form"
				data-target="turnstile"
			>
				<span class="sui-loading-text"><?php esc_html_e( 'Save Settings', 'hustle' ); ?></span>
				<span class="sui-icon-loader sui-loading" aria-hidden="true"></span>
			</button>

		</div>

	</div>

</div>
