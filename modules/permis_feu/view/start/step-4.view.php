<?php
/**
 * liste les intervenants du permis de feu ( dernière étape )
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
}

global $eo_search; ?>

<div class="information-intervenant-exterieur wpeo-form" style="background-color: #fff; padding: 1em;">
	<h2 style="text-align:center">
		<?php esc_html_e( 'Responsable de la société intervenante', 'digirisk' ); ?> -
		<i><?php echo esc_attr( $society->data['title'] ); ?></i>
		<span class="wpeo-tooltip-event"
		      aria-label="<?php esc_html_e( 'Responsable de la société intervenante', 'digirisk' ); ?>"
		      style="color : dodgerblue; cursor : pointer">
			<i class="fas fa-info-circle"></i>
		</span>
	</h2>

	<div class="wpeo-gridlayout grid-4" style="align-items: end">
		<?php $eo_search->display( 'intervenant_exterieur' ); ?>

		<div class="form-element <?php echo ! empty( $permis_feu->data['intervenant_exterieur']['user_id'] ) ? 'form-element-disable' : ''; ?>">
			<span class="form-label"><?php esc_html_e( 'Prénom', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input type="text" name="intervenant-firstname" class="form-field" value="<?php echo ! empty( $permis_feu->data['intervenant_exterieur']['user_id'] ) ? $permis_feu->data['intervenant_exterieur']['data']->first_name : ''; ?>" />
			</label>
		</div>

		<div class="form-element <?php echo ! empty( $permis_feu->data['intervenant_exterieur']['user_id'] ) ? 'form-element-disable' : ''; ?>">
			<span class="form-label"><?php esc_html_e( 'Portable', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<input type="text" name="intervenant-phone" class="form-field" value="<?php echo ! empty( $permis_feu->data['intervenant_exterieur']['user_id'] ) ? $permis_feu->data['intervenant_exterieur']['data']->phone : ''; ?>" />
			</label>
		</div>

		<div>
			<?php echo do_shortcode( '[digi_signature id="' . $permis_feu->data['id'] . '" key="intervenant_exterieur_signature_id"]' ); ?>
		</div>
	</div>
</div>
