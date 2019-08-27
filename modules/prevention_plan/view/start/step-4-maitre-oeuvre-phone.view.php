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


<?php if( ! empty( $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->phone ) ): ?>
	<div class="form-element element-phone form-element-disable">
<?php else: ?>
	<div class="form-element element-phone">
<?php endif; ?>
	<span class="form-label"><?php esc_html_e( 'Portable', 'task-manager' ); ?></span>
	<label class="form-field-container">
		<span class="form-field-icon-prev"><i class="fas fa-mobile-alt"></i></span>
		<?php if( ! empty( $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->phone ) ): ?>
			<input type="text" class="form-field element-phone-input" name="maitre-oeuvre-phone" value="<?php echo esc_attr( $prevention->data[ 'maitre_oeuvre' ][ 'data' ]->phone ); ?>" data-verif="false">
		<?php else: ?>
			<input type="text" class="form-field element-phone-input" name="maitre-oeuvre-phone" value="" data-verif="false">
		<?php endif; ?>
	</label>
</div>
