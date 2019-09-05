<?php
/**
 * Information du maitre d'oeuvre (utilisateur wordpress) pour compléter les informations du plan de prévention
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
<div class="wpeo-form">
	<?php if( ! empty( $permis_feu->data[ 'maitre_oeuvre' ][ 'user_id' ] ) ): ?>
		<div class="form-element element-maitre-oeuvre form-element-disable">
	<?php else: ?>
		<div class="form-element element-maitre-oeuvre">
	<?php endif; ?>
		<input type="hidden" name="permis_feu_id" value="<?php echo esc_attr( $permis_feu->data[ 'id' ] ); ?>">
		<span class="form-label"><?php esc_html_e( 'Nom', 'digirisk' ); ?></span>
		<?php if( ! empty( $permis_feu->data[ 'maitre_oeuvre' ][ 'data' ]->last_name ) ): ?>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
				<input type="text" class="form-field" name="maitre-oeuvre-name" value="<?php echo esc_attr( $permis_feu->data[ 'maitre_oeuvre' ][ 'data' ]->last_name ); ?>">
			</label>
		<?php else: ?>
			<input type="hidden" name="maitre-oeuvre-name" value="-1">
			<?php $eo_search->display( 'maitre_oeuvre' ); ?>
		<?php endif; ?>
	</div>
</div>
<div class="wpeo-form">
	<?php if( ! empty( $permis_feu->data[ 'maitre_oeuvre' ][ 'data' ]->first_name ) ): ?>
		<div class="form-element element-maitre-oeuvre form-element-disable">
	<?php else: ?>
		<div class="form-element element-maitre-oeuvre">
	<?php endif; ?>
		<span class="form-label"><?php esc_html_e( 'Prénom', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
				<?php if( ! empty( $permis_feu->data[ 'maitre_oeuvre' ][ 'data' ]->first_name ) ): ?>
					<input type="text" class="form-field" name="maitre-oeuvre-lastname" value="<?php echo esc_attr( $permis_feu->data[ 'maitre_oeuvre' ][ 'data' ]->first_name ); ?>">
				<?php else: ?>
					<input type="text" class="form-field" name="maitre-oeuvre-lastname" value="">
				<?php endif; ?>
			</label>
	</div>
</div>
