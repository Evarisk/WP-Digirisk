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

<div class="table-row intervention-row readonly">
	<div class="table-cell table-100" data-title="<?php esc_html_e( 'IdRPP', 'digirisk' ); ?>">
		#<?php echo esc_attr( $intervention->data['key_unique'] ); ?>
	</div>
	<div class="table-cell table-150" data-title="<?php esc_html_e( 'Société', 'digirisk' ); ?>">
		<div class="wpeo-form">
			<div class="form-element form-element-disable">
				<label class="form-field-container">
					<input type="text" name="description-des-actions" class="form-field" value="<?php echo esc_attr( Prevention_Intervention_Class::g()->return_name_workunit( $intervention->data[ 'unite_travail' ] ) ); ?>">
				</label>
			</div>
		</div>
	</div>
	<div class="table-cell" data-title="Description des actions">
		<div class="wpeo-form">
			<div class="form-element form-element-disable">
				<label class="form-field-container">
					<input type="text" name="description-des-actions" class="form-field" value="<?php echo esc_attr( $intervention->data[ 'action_realise' ] ); ?>">
				</label>
			</div>
		</div>
	</div>
	<div class="table-cell table-50" data-title="Risque"> <!-- class="w50" -->
		<div class="wpeo-form risque-element" style=": 0px !important;">
			<div class="form-element">
				<div class="form-field-container" style="margin-left:2%">
					<?php
						do_shortcode( '[digi_dropdown_categories_risk id="' . $intervention->data['id'] . '" type="causerie" display="view" category_risk_id="' . $intervention->data[ 'risk' ] . '"]' );
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="table-cell table-200" data-title="Moyen de prévention">
		<div class="wpeo-form">
			<div class="form-element form-element-disable">
				<label class="form-field-container">
					<input type="text" name="description-des-actions" class="form-field" value="<?php echo esc_attr( $intervention->data[ 'moyen_prevention' ] ); ?>">
				</label>
			</div>
		</div>
	</div>
	<div class="table-cell table-150 table-end" data-title="<?php esc_html_e( 'Unité de travail', 'digirisk' ); ?>">
		<div class="action wpeo-gridlayout grid-3 grid-gap-0">
			<div class="wpeo-form button-unite-de-travail" style="float: right;">
				<?php
				\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-2-unite-de-travail', array(
					'id'  => $intervention->data['unite_travail'],
					'tab' => $intervention->data['unite_travail_tab'],
				) );
				?>
			</div>
			<?php if( $edit ): ?>
				<div class="wpeo-button button-transparent action-input button-square-50"
					data-id="<?php echo esc_attr( $intervention->data[ 'id' ] ); ?>"
					data-action="edit_intervention_line"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'edit_intervention_line' ) ); ?>">
					<span><i class="fas fa-pen"></i></span>
				</div>
				<div class="wpeo-button button-transparent action-delete button-square-50"
					data-id="<?php echo esc_attr( $intervention->data[ 'id' ] ); ?>"
					data-message-delete="<?php esc_html_e( 'Voulez-vous supprimer cette intervention ?', 'digirisk' ); ?>"
					data-action="delete_intervention_line"
					data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_intervention_line' ) ); ?>">
					<span><i class="fas fa-trash"></i></span>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
