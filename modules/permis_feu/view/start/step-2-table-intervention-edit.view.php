<?php
/**
 * Evaluation d'une causerie: étape 2, permet d'afficher les images associées à la causerie dans un format "slider".
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

global $eo_search;
?>



<?php if( isset( $new_line ) && $new_line ): ?>
	<tr class="intervention-row edit unite-de-travail-class new-line-intervention" data-id="<?php echo esc_attr( $permis_feu->data['id'] ); ?>" style="display : none">
<?php else: ?>
	<tr class="intervention-row edit unite-de-travail-class" data-id="<?php echo esc_attr( $permis_feu->data['id'] ); ?>">
<?php endif; ?>
	<?php if( isset( $intervention ) ): ?>
		<input type="hidden" name="unite-travail-hidden" class="form-field" value="<?php echo esc_attr( $intervention->data[ 'unite_travail' ] ); ?>">
	<?php endif; ?>
	<td class="w100 padding" data-title="<?php esc_html_e( 'IdRPP', 'digirisk' ); ?>" style="padding: 30px;">
		<?php if( isset( $intervention ) ): ?>
			<?php echo esc_attr( $intervention->data['key_unique'] ); ?>
		<?php else: ?>
			-
		<?php endif; ?>
	</td>
	<td class="w150 padding unite-de-travail-element" data-title="<?php esc_html_e( 'Société', 'digirisk' ); ?>">
		<div class="wpeo-form">
			<div class="form-element">
				<?php $eo_search->display( 'accident_post' ); ?>
			</div>
		</div>

	</td>
	<td data-title="Description des actions">
		<div class="wpeo-form">
			<div class="form-element">
				<label class="form-field-container">
					<?php if( isset( $intervention ) ): ?>
						<input type="text" name="description-des-actions" class="form-field" value="<?php echo esc_attr( $intervention->data[ 'action_realise' ] ); ?>">
					<?php else: ?>
						<input type="text" name="description-des-actions" class="form-field">
					<?php endif; ?>
				</label>
			</div>
		</div>
	</td>
	<td class="w100 padding" data-title="Risque"> <!-- class="w50" -->
		<div class="wpeo-form worktype-element" style="padding: 0px !important;">
			<div class="form-element">
				<div class="form-field-container" style="margin-left:2%">
					<?php if( isset( $intervention ) ): ?>
						<?php do_shortcode( '[digi_dropdown_worktype category_worktype_id="' . $intervention->data[ 'worktype' ] . '" display="edit"]' ); ?>
					<?php else: ?>
						<?php do_shortcode( '[digi_dropdown_worktype id="0" display="edit"]' ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</td>
	<td class="padding" data-title="Moyen de prévention">
		<div class="wpeo-form">
			<div class="form-element">
				<label class="form-field-container">
					<?php if( isset( $intervention ) ): ?>
						<input type="text" name="materiel-utilise" class="form-field" value="<?php echo esc_attr( $intervention->data[ 'materiel_utilise' ] ); ?>">
					<?php else: ?>
						<input type="text" name="materiel-utilise" class="form-field">
					<?php endif; ?>
				</label>
			</div>
		</div>
	</td>
	<td></td>
	<td></td>

	<td class="w50 padding" data-title="action">
		<div class="intervention-action">
			<div class="wpeo-button button-add-row-intervention action-input <?php echo ! empty( $intervention->data[ 'unite_travail' ] ) ? '' : 'button-disable'; ?>"
			data-parentid="<?php echo esc_attr( $permis_feu->data[ 'id' ] ); ?>"
			data-id="<?php echo esc_attr( isset( $intervention ) ? $intervention->data[ 'id' ] : 0 ); ?>"
			data-action="<?php echo esc_attr( 'add_intervention_line_permisfeu' ); ?>"
			data-parent="unite-de-travail-class"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'add_intervention_line_permisfeu' ) ); ?>"
			style="margin-right: 20px;">
			<?php if( isset( $intervention ) ): ?>
				<span><i class="fas fa-save"></i></span>
			<?php else: ?>
				<span><i class="fas fa-plus"></i></span>
			<?php endif; ?>
			</div>
		</div>
	</td>
</tr>
