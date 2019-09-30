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

<tr class="intervention-row readonly" style="height : 60px">
	<td class="w100 padding" data-title="<?php esc_html_e( 'IdRPP', 'digirisk' ); ?>">
		#<?php echo esc_attr( $intervention->data['key_unique'] ); ?>
	</td>
	<td class="w150 padding" data-title="<?php esc_html_e( 'Unité de travail', 'digirisk' ); ?>">
		<div class="wpeo-form">
			<div class="form-element form-element-disable">
				<label class="form-field-container">
					<input type="text" name="description-des-actions" class="form-field" value="<?php echo esc_attr( Prevention_Intervention_Class::g()->return_name_workunit( $intervention->data[ 'unite_travail' ] ) ); ?>">
				</label>
			</div>
		</div>
	</td>
	<td data-title="Description des actions">
		<div class="wpeo-form">
			<div class="form-element form-element-disable">
				<label class="form-field-container">
					<input type="text" name="description-des-actions" class="form-field" value="<?php echo esc_attr( $intervention->data[ 'action_realise' ] ); ?>">
				</label>
			</div>
		</div>
	</td>
	<td class="w100 padding" data-title="Risque"> <!-- class="w50" -->
		<div class="wpeo-form risque-element" style="padding: 0px !important;">
			<div class="form-element">
				<div class="form-field-container" style="margin-left:2%">
					<?php
					do_shortcode( '[digi_dropdown_worktype category_worktype_id="' . $intervention->data[ 'worktype' ] . '" display="view"]' );
						// do_shortcode( '[digi_dropdown_categories_risk id="' . $intervention->data['id'] . '" type="causerie" display="view" category_risk_id="' . $intervention->data[ 'risk' ] . '"]' );
					?>
				</div>
			</div>
		</div>
	</td>
	<td class="padding" data-title="Matériels utilisés">
		<div class="wpeo-form">
			<div class="form-element form-element-disable">
				<label class="form-field-container">
					<input type="text" name="materiel-utilise" class="form-field" value="<?php echo esc_attr( $intervention->data[ 'materiel_utilise' ] ); ?>">
				</label>
			</div>
		</div>
	</td>

	<td class="w50 padding" data-title="<?php esc_html_e( 'Unité de travail', 'digirisk' ); ?>">
	  <div class="wpeo-form button-unite-de-travail" style="float: right;">
		  <?php
		  \eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-2-unite-de-travail', array(
	  			'id' => $intervention->data[ 'unite_travail' ],
	  			'tab' => $intervention->data[ 'unite_travail_tab' ]
	  		) );
		   ?>
	  </div>
	</td>

	<td class="w50 padding" data-title="action">
		<div class="wpeo-button button-blue action-input"
		 data-id="<?php echo esc_attr( $intervention->data[ 'id' ] ); ?>"
		 data-action="edit_intervention_line_permisfeu"
		 data-nonce="<?php echo esc_attr( wp_create_nonce( 'edit_intervention_line_permisfeu' ) ); ?>">
			<span><i class="fas fa-pen"></i></span>
		</div>
	</td>
	<td class="w50 padding" data-title="action">
		<div class="wpeo-button button-red action-delete"
		 data-id="<?php echo esc_attr( $intervention->data[ 'id' ] ); ?>"
		 data-message-delete="<?php esc_html_e( 'Voulez-vous supprimer cette intervention ?', 'digirisk' ); ?>"
		 data-action="delete_intervention_line_permisfeu"
		 data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_intervention_line_permisfeu' ) ); ?>">
			<span><i class="fas fa-trash"></i></span>
		</div>
	</td>
</tr>
