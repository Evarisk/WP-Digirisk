<?php
/**
 * Affichage d'un plan de prévention liés à un permis de feu : étape 2
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

global $eo_search;
?>

<?php if( ! empty( $permis_feu->data[ 'prevention_id' ] ) && $permis_feu->data[ 'prevention_id' ] != 0 ): ?>
	<div class="wpeo-form select-prevention">
		<div class="form-element form-element-disable">
			<span class="form-label"><?php esc_html_e( 'Plan de prévention', 'digirisk' ); ?></span>
			<label class="form-field-container">
				<span class="form-field-icon-prev"><i class="fas fa-globe-americas"></i></span>
				<?php $title = $permis_feu->data[ 'prevention_data' ][ 'title' ]; ?>
				<?php $id = $permis_feu->data[ 'prevention_id' ]; ?>
				<input type="text" name="permis_feu-title" class="form-field" value="<?php echo esc_attr( $title . ' #' . $id ); ?>">
			</label>
		</div>
	</div>
	<div class="action-permis-feu-prevention" style="margin-top : 30px">

		<span class="action-attribute wpeo-button button-green button-square-50 wpeo-tooltip-event"
			data-id="<?php echo esc_attr( $permis_feu->data['prevention_id'] ); ?>"
			data-action="generate_document_prevention"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'generate_document_prevention' ) ); ?>"
			aria-label="<?php echo esc_attr_e( 'Générer le document', 'digirisk' ); ?>">
			<i class="fas fa-download"></i>
		</span>
		<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-prevention&id=' . $permis_feu->data[ 'prevention_id' ] ) ); ?>"
			target="_blank"
			class="wpeo-button button-blue button-square-50 wpeo-tooltip-event"
			aria-label="<?php esc_html_e( 'Editer', 'digirisk' ); ?>">
		 		<i class="fas fa-pen"></i>
		</a>
		<span class="wpeo-button button-red button-square-50 wpeo-tooltip-event delete-prevention-from-permis-feu"
			data-id="<?php echo esc_attr( $permis_feu->data['id'] ); ?>"
			data-action="delete_prevention_from_permis_feu"
			data-message="<?php esc_html_e( 'Voulez-vous vraiment supprimer la liaison avec ce plan de prévention', 'digirisk' ); ?>"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_prevention_from_permis_feu' ) ); ?>"
			aria-label="<?php echo esc_attr_e( 'Supprimer la liaison avec ce plan de prévention', 'digirisk' ); ?>">
			<i class="fas fa-unlink"></i>
		</span>
	</div>

<?php else: ?>
	<div class="wpeo-form select-prevention"
	data-action="add_prevention_to_permis_feu"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'add_prevention_to_permis_feu' ) ); ?>">
		<input type="hidden" name="permis_feu_id" value="<?php echo esc_attr( $permis_feu->data[ 'id' ] ); ?>">
		<?php $eo_search->display( 'prevention_list' ); ?>
	</div>

<?php endif; ?>
