<?php
/**
 * Liste des informations complémentaires (Numéro SAMU / POLICE / URGENCE / POMPIER)
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     7.3.0
 * @version   7.3.0
 * @copyright 2019 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<h2 style="text-align:center">
	<?php esc_html_e( 'Informations complémentaires', 'digirisk' ); ?>
	<span class="wpeo-tooltip-event"
	aria-label="<?php esc_html_e( 'Ces informations ont été définies dans l\'affichage légal de Digirisk', 'digirisk' ); ?>"
	style="color : dodgerblue; cursor : pointer">
		<i class="fas fa-info-circle"></i>
	</span>
</h2>
<section class="wpeo-gridlayout padding grid-4 information-element-society" style="margin-bottom: 10px;">

	<div class="wpeo-form">
		<div class="form-element form-element-disable">
			<span class="form-label"><?php esc_html_e( 'Numéro SAMU', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-mobile"></i></span>
				<?php if( ! empty( $society ) ): ?>
					<input type="text" class="form-field" value="<?php echo esc_attr( $legal_display->data[ 'emergency_service' ][ 'samu' ] ); ?>">
				<?php else: ?>
					<input type="text" class="form-field" value="">
				<?php endif; ?>
			</label>
		</div>
	</div>

	<div class="wpeo-form">
		<div class="form-element form-element-disable">
			<span class="form-label"><?php esc_html_e( 'Numéro Police', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-car"></i></span>
				<?php if( ! empty( $society ) ): ?>
					<input type="text" class="form-field" value="<?php echo esc_attr( $legal_display->data[ 'emergency_service' ][ 'police' ] ); ?>">
				<?php else: ?>
					<input type="text" class="form-field" value="">
				<?php endif; ?>
			</label>
		</div>
	</div>

	<div class="wpeo-form">
		<div class="form-element form-element-disable">
			<span class="form-label"><?php esc_html_e( 'Numéro Pompier', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-fire-extinguisher"></i></span>
				<?php if( ! empty( $society ) ): ?>
					<input type="text" class="form-field" value="<?php echo esc_attr( $legal_display->data[ 'emergency_service' ][ 'pompier' ] ); ?>">
				<?php else: ?>
					<input type="text" class="form-field" value="">
				<?php endif; ?>
			</label>
		</div>
	</div>

	<div class="wpeo-form">
		<div class="form-element form-element-disable">
			<span class="form-label"><?php esc_html_e( 'Numéro Urgence', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-heartbeat"></i></span>
				<?php if( ! empty( $society ) ): ?>
					<input type="text" class="form-field" value="<?php echo esc_attr( $legal_display->data[ 'emergency_service' ][ 'emergency' ] ); ?>">
				<?php else: ?>
					<input type="text" class="form-field" value="">
				<?php endif; ?>
			</label>
		</div>
	</div>
</section>
