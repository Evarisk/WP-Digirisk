<?php
/**
 * Edition d'un evaluateur
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.6.0
 * @version 7.6.0
 * @copyright 2015-2020 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $eo_search;

?>
<div class="table-row evaluator-row edit">

	<!-- Les champs obligatoires pour le formulaire -->
	<?php wp_nonce_field( 'edit_evaluator_assign' ); ?>
	<input type="hidden" name="element_id" value="<?php echo esc_attr( $evaluator->data['id'] );?>" />
	<input type="hidden" name="action" value="edit_evaluator_assign" />

	<div class="table-cell table-50">
		-
	</div>
	<div class="table-cell" name="user_id" >
		<?php $eo_search->display( 'evaluator') ?>
	</div>
	<div class="table-cell table-125">
		<div class="wpeo-form">
			<div class="form-element group-date">
				<label class="form-field-container">
					<span class="form-field-icon-prev"><i class="fas fa-calendar-alt"></i></span>
					<input type="hidden" class="mysql-date" name="affectation_date" value="<?php echo esc_html( mysql2date( 'd/m/Y', $evaluator->data['affectation_date'] ) ); ?>">
					<input type="text" class="form-field date" value='<?php echo esc_html( mysql2date( 'd/m/Y', $evaluator->data['affectation_date'] ) ); ?>'>
				</label>
			</div>
		</div>
	</div>


	<div class="table-cell table-50">
		<label class="form-field-container">
			<input type="number" name="affectation_duration" value="<?php echo (int) esc_attr( ($evaluator->data['affectation_duration']) ); ?>">
		</label>
	</div>

	<div class="table-cell table-50 table-end">
		<div class="action wpeo-gridlayout grid-gap-0 grid-1">
			<div data-namespace="digirisk"
			     data-module="evaluator"
			     data-loader="wpeo-table"
			     data-parent="evaluator-row"
			     class="wpeo-button button-square-50 add action-input button-progress">
				<i class="button-icon fas fa-plus"></i></div>
		</div>
	</div>

</div>
