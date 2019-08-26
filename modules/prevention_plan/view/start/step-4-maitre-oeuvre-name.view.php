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
	<div class="form-element element-maitre-oeuvre">
		<input type="hidden" name="prevention_id" value="<?php echo esc_attr( $prevention->data[ 'id' ] ); ?>">
		<span class="form-label"><?php esc_html_e( 'Nom', 'task-manager' ); ?></span>
		<?php if( ! empty( $user ) && isset( $user->first_name ) ): ?>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
				<input type="text" class="form-field" name="maitre-oeuvre-name" value="<?php echo esc_attr( $user->first_name ); ?>">
			</label>
		<?php else: ?>
			<input type="hidden" name="maitre-oeuvre-name" value="-1">
			<?php $eo_search->display( 'maitre_oeuvre' ); ?>
		<?php endif; ?>
	</div>
</div>

<div class="wpeo-form">
	<div class="form-element">
		<span class="form-label"><?php esc_html_e( 'Prénom', 'task-manager' ); ?></span>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
				<?php if( ! empty( $user ) && isset( $user->last_name ) ): ?>
					<input type="text" class="form-field" name="maitre-oeuvre-lastname" value="<?php echo esc_attr( $user->last_name ); ?>">
				<?php else: ?>
					<input type="text" class="form-field" name="maitre-oeuvre-lastname" value="">
				<?php endif; ?>
			</label>
	</div>
</div>
