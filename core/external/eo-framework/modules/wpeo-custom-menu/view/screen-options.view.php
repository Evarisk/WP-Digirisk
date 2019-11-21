<?php
/**
 * Display Nav Menu.
 *
 * @author Eoxia <techinque@eoxia.com>
 * @since 1.0.0
 * @copyright 2015-2019 Eoxia
 * @package EOFramework
 */

namespace eoxia;

defined( 'ABSPATH' ) || exit; ?>

<div class="wpeo-screen-options">
	<div class="wpeo-button button-main toggle-screen-options"><span><?php esc_html_e( 'Screen options', 'eo-framework' ); ?></span><i class="button-icon fas fa-caret-down"></i></div>
	<div class="content hidden">
		<form id="adv-settings" method="post">
			<ul class="wpeo-form">
				<?php
				foreach ( $current_screen->get_options() as $key => $option ) :
					$value = get_user_meta( get_current_user_id(), $option['option'], true );
					?>
					<li>
						<div class="form-element">
							<span class="form-label"><?php echo esc_html( $option['label'] ); ?></span>
							<label class="form-field-container">
								<input type="text" name="wp_screen_options[value]" class="form-field" value="<?php echo isset( $value ) ? $value : esc_attr( $option['default'] ); ?>"/>
							</label>
						</div>
						<input type="hidden" name="wp_screen_options[option]" value="<?php echo $option['option']; ?>">
					</li>
					<?php
				endforeach;
				wp_nonce_field( 'screen-options-nonce', 'screenoptionnonce' );
				?>

				<li>
					<input class="wpeo-button button-grey" name="screen-options-apply" id="screen-options-apply" type="submit" value="<?php esc_attr_e( 'Save Changes', 'eo-framework' ); ?>" />
				</li>
			</ul>
		</form>
	</div>
</div>
