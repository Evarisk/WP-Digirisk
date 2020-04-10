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
} ?>

<div class="table-row evaluator-row edit">

	<!-- Les champs obligatoires pour le formulaire -->
	<?php wp_nonce_field( 'edit_evaluator_assign' ); ?>
	<input type="hidden" name="element_id" value="<?php echo esc_attr( $element->data['id'] ); ?>" />
	<input type="hidden" name="action" value="edit_evaluator_assign" />

	<div class="table-cell table-50">
		-
	</div>
	<div class="table-cell">
		RECHERCHE UTILISATEUR
	</div>
	<div class="table-cell table-125">
		-
	</div>
	<div class="table-cell table-50">
		TEMPS
	</div>
	<div class="table-cell table-50 table-end">
		<div class="action wpeo-gridlayout grid-gap-0 grid-1">
			<div data-namespace="digirisk"
			     data-module=""
			     data-before-method=""
			     data-loader="wpeo-table"
			     data-parent="evaluator-row"
			     class="wpeo-button button-square-50 add action-input button-progress">
				<i class="button-icon fas fa-plus"></i></div>
		</div>
	</div>
</div>
