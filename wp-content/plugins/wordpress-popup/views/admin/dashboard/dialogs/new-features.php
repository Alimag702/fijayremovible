<?php
/**
 * Dialog advertising new features: Zoho integration, Newsletter integrations, Cloudflare Turnstile captcha.
 *
 * @package Hustle
 * @since 4.8.0
 */

$user     = wp_get_current_user();
$username = ! empty( $user->user_firstname ) ? $user->user_firstname : $user->user_login;
?>

<div class="sui-modal sui-modal-md">

	<div
		role="dialog"
		id="hustle-dialog--new-features"
		class="sui-modal-content"
		aria-modal="true"
		aria-labelledby="hustle-dialog--new-features-title"
		aria-describedby="hustle-dialog--new-features-description"
		data-name="<?php echo esc_attr( Hustle_Dashboard_Admin::NEW_FEATURES_MODAL_NAME ); ?>"
	>

		<div class="sui-box" style="margin-bottom: 10px;">

			<div class="sui-box-header sui-flatten sui-content-center sui-spacing-right--30 sui-spacing-left--30">

				<button class="sui-button-icon sui-button-float--right hustle-modal-close" style="z-index: 2;" data-modal-close>
					<span class="sui-icon-close sui-md" aria-hidden="true"></span>
					<span class="sui-screen-reader-text"><?php esc_html_e( 'Close this dialog window', 'hustle' ); ?></span>
				</button>

				<figure role="banner" class="sui-box-banner" aria-hidden="true">
					<?php
					$image_attrs = array(
						'path'        => self::$plugin_url . 'assets/images/onboard-image.png',
						'retina_path' => self::$plugin_url . 'assets/images/onboard-image@2x.png',
						'class'       => 'sui-image sui-image-center',
					);

					$this->render( 'admin/image-markup', $image_attrs );
					?>
				</figure>

				<h3 id="hustle-dialog--new-features-title" class="sui-box-title sui-lg">
					<?php /* translators: current user's name */ printf( esc_html__( 'Hey %s, Check Out What\'s New!', 'hustle' ), esc_html( $username ) ); ?>
				</h3>

			</div>

		<div class="sui-box-body">

			<ul style="list-style: none; padding: 0; margin: 0;">

				<li style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 16px 0;">
					<img src="<?php echo esc_url( self::$plugin_url . 'assets/images/zoho-integration.png' ); ?>" alt="<?php esc_attr_e( 'Zoho Integration', 'hustle' ); ?>" style="height: 56px; margin-bottom: 16px;">
					<p class="sui-description" style="margin: 0; text-align:justify;">
						<?php esc_html_e( 'Connect your Hustle optin forms to Zoho CRM and automatically add new subscribers to your Contacts list.', 'hustle' ); ?>
					</p>
				</li>

				<li style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 16px 0;">
					<img src="<?php echo esc_url( self::$plugin_url . 'assets/images/newsletter-integration.svg' ); ?>" alt="<?php esc_attr_e( 'Newsletter Integrations', 'hustle' ); ?>" style="width: 200px; margin-bottom:16px;">
					<p class="sui-description" style="margin: 0; text-align:justify;">
						<?php esc_html_e( 'Connect your Hustle optin forms to the Newsletter plugin to grow your audience and keep your subscribers engaged with targeted email campaigns.', 'hustle' ); ?>
					</p>
				</li>

				<li style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 16px 0;">
					<img src="<?php echo esc_url( self::$plugin_url . 'assets/images/cloudflare-integration.png' ); ?>" alt="<?php esc_attr_e( 'Cloudflare Turnstile', 'hustle' ); ?>" style="height: 48px; margin-bottom: 16px;">
					<p class="sui-description" style="margin: 0; text-align:justify;">
						<?php esc_html_e( 'Protect your Hustle optin forms from spam and abuse with a privacy-friendly CAPTCHA alternative. Keep bots out without frustrating your real visitors.', 'hustle' ); ?>
					</p>
				</li>

			</ul>

		</div>

		<div class="sui-box-footer sui-flatten sui-content-center sui-spacing-bottom--50">

			<button
				id="hustle-new-features-action-button"
				class="sui-button hustle-modal-close"
				data-modal-close
			>
				<?php esc_html_e( 'Got It', 'hustle' ); ?>
			</button>

		</div>

	</div>

	<button class="sui-modal-skip" data-modal-close><?php esc_html_e( "I'll check this later", 'hustle' ); ?></button>

	</div>

</div>
