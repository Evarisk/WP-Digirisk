<?php
/**
 * Form element téléphone de l'utilisateur
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $eo_search; ?>

<?php if( empty( $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->phone ) ): ?>

	<div class="wpeo-form">
		<section class="wpeo-gridlayout padding grid-2  digi-phone-user" style="margin-bottom: 10px;">
			<div class="form-element">
				<span class="form-label"><?php esc_html_e( 'Code', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<?php
					\eoxia\View_Util::exec( 'digirisk', 'user', 'user-profile-list-calling-code', array(
						'local' => get_locale(),
						'width' => 'none',
						'name' => 'maitre-oeuvre-phone-callingcode'
					) );
					?>
				</label>
			</div>

			<div class="form-element element-phone">
				<span class="form-label"><?php esc_html_e( 'Portable', 'digirisk' ); ?></span>
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-mobile-alt"></i></span>
					<input type="text" class="form-field element-phone-input" name="maitre-oeuvre-phone" value="" style="width: auto;">
				</label>
			</div>
		</section>
	</div>

<?php else: ?>
	<div class="form-element element-phone form-element-disable">
		<span class="form-label"><?php esc_html_e( 'Portable', 'digirisk' ); ?></span>
		<label class="form-field-container">
			<span class="form-field-icon-prev"><i class="fas fa-mobile-alt"></i></span>
			<input type="hidden" name="update" value="no" />
			<input type="hidden" class="form-field element-phone-input" value="<?php echo esc_attr( $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->phone_nbr ); ?>" name="maitre-oeuvre-phone" data-verif="false">
			<input type="text" class="form-field element-phone-input" value="<?php echo esc_attr( $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->phone ); ?>" data-verif="false">
		</label>
	</div>
<?php endif; ?>
