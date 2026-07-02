<?php
/**
 * Language section under the "turnstile" tab.
 *
 * @package Hustle
 * @since 7.8.13
 */

?>
<div class="sui-form-field">

	<label class="sui-settings-label"><?php esc_html_e( 'Language', 'hustle' ); ?></label>
	<span class="sui-description"><?php esc_html_e( "By default, we'll show the Turnstile Captcha in your website's default language.", 'hustle' ); ?></span>

	<div style="width: 100%; max-width: 240px; margin-top: 10px;">

		<select
			id="hustle-turnstile-language"
			class="sui-select"
			name="language"
		>
			<option value="auto" <?php selected( ! empty( $settings['language'] ) && 'auto' === $settings['language'] ); ?>>
				<?php esc_attr_e( 'Automatic', 'hustle' ); ?>
			</option>

			<?php
			$languages = Opt_In_Utils::get_captcha_languages();

			foreach ( $languages as $key => $language ) :
				?>

				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( ! empty( $settings['language'] ) && $settings['language'] === $key ); ?>>
					<?php echo esc_attr( $language ); ?>
				</option>

			<?php endforeach; ?>

		</select>

	</div>

</div>
