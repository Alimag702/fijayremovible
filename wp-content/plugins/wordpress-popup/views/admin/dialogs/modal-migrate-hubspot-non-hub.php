<?php
/**
 * Modal for migrating HubSpot with API keys.
 *
 * @package Hustle
 * @since 7.8.13
 */

$redirect_uri = Hustle_HubSpot::get_instance()
	->api()
	->get_redirect_uri();
?>

<div class="sui-modal sui-modal-sm">

	<div
		role="dialog"
		id="hustle-dialog-migrate--hubspot"
		class="sui-modal-content"
		aria-modal="true"
		aria-labelledby="hustle-dialog-migrate--hubspot-title"
		aria-describedby="hustle-dialog-migrate--hubspot-description"
	>

		<div class="sui-box">

			<div class="sui-box-header sui-content-center sui-flatten sui-spacing-top--60">

				<button class="sui-button-icon sui-button-float--right" data-modal-close>
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_html_e( 'Close this dialog window', 'hustle' ); ?></span>
				</button>

				<h3 id="hustle-dialog-migrate--hubspot-title" class="sui-box-title sui-lg">
					<?php esc_html_e( 'Migrate HubSpot', 'hustle' ); ?>
				</h3>

				<p id="hustle-dialog-migrate--hubspot-description" class="sui-description">
					<?php esc_html_e( 'Enter your HubSpot Client ID and Client Secret to authenticate and migrate your integration.', 'hustle' ); ?>
				</p>

			</div>

			<form class="sui-box-body sui-spacing-top--20">
				<div class="sui-form-field 	">
						<label for="hubspot_redirect_uri" class="sui-label"><?php esc_html_e( 'Redirect URI', 'hustle' ); ?></label>
						<div class="sui-with-button sui-with-button-inside">
						<input type="text" name="hubspot_redirect_uri" value="<?php echo esc_url( $redirect_uri ); ?>" id="hubspot_redirect_uri" class="sui-form-control optin_readonly_readonly readonly " readonly="" data-listener-added="true">
						<button class="sui-button-icon sui-copy-button hustle-copy-shortcode-button" type="button" aria-label="<?php esc_attr_e( 'Copy to clipboard', 'hustle' ); ?>">
							<span class="sui-icon-copy" aria-hidden="true"></span>
							<span class="sui-screen-reader-text"><?php esc_html_e( 'Copy to clipboard', 'hustle' ); ?></span>
						</button>
					</div>
					<span class="sui-description"><?php esc_html_e( 'Add this URL as the redirect / callback URL in your HubSpot app settings.', 'hustle' ); ?></span>

				</div>
				<div class="sui-form-field" style="text-align: left;">
					<label for="hubspot-public-key" id="label-hubspot-public-key" class="sui-label">
						<?php esc_html_e( 'Client ID', 'hustle' ); ?>
					</label>
					<input
						id="hubspot-public-key"
						name="api_key"
						type="text"
						class="sui-form-control"
						aria-labelledby="label-hubspot-public-key"
						aria-describedby="error-hubspot-public-key"
						placeholder="<?php esc_attr_e( 'e.g. 123abc456def789ghi', 'hustle' ); ?>"
					/>
					<span id="error-hubspot-public-key" class="sui-error-message sui-hidden">
						<?php esc_html_e( 'Please enter a valid Client ID.', 'hustle' ); ?>
					</span>
				</div>

				<div class="sui-form-field" style="text-align: left;">
					<label for="hubspot-private-key" id="label-hubspot-private-key" class="sui-label">
						<?php esc_html_e( 'Client Secret', 'hustle' ); ?>
					</label>
					<input
						id="hubspot-private-key"
						name="private_key"
						type="text"
						class="sui-form-control"
						aria-labelledby="label-hubspot-private-key"
						aria-describedby="error-hubspot-private-key"
						placeholder="<?php esc_attr_e( 'e.g. 123abc456def789ghi', 'hustle' ); ?>"
					/>
					<span id="error-hubspot-private-key" class="sui-error-message sui-hidden">
						<?php esc_html_e( 'Please enter a valid Client Secret.', 'hustle' ); ?>
					</span>
				</div>

			</form>

			<div class="sui-box-footer sui-flatten sui-content-center">
				<button
					id="integration-migrate"
					class="hustle-hubspot-migrate sui-button sui-button-blue"
					data-id=""
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'hustle_provider_action' ) ); ?>"
				>
					<span class="sui-loading-text"><?php esc_html_e( 'Authorize', 'hustle' ); ?></span>
					<span class="sui-icon-loader sui-loading" aria-hidden="true"></span>
				</button>
			</div>

		</div>

	</div>

</div>