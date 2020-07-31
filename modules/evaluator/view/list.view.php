<?php
/**
 * Affiches la liste des évaluateurs
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

?>

<div class="wpeo-table table-flex table-evaluator">
	<div class="table-row table-header">
		<div class="table-cell table-50"><?php esc_html_e( 'ID', 'digirisk' ); ?></div>
		<div class="table-cell"><?php esc_html_e( 'Nom, Prénom', 'digirisk' ); ?></div>
		<div class="table-cell table-125"><?php esc_html_e( 'Date d\'affectation', 'digirisk' ); ?></div>
		<div class="table-cell table-50"><?php esc_html_e( 'Durée', 'digirisk' ); ?></div>
		<div class="table-cell table-50 table-end"></div>
	</div>

	<?php
		
	if ( ! empty( $evaluators ) ) :
	
		foreach( $evaluators as $evaluator ) :
			
			if( isset($evaluator['affectation_date'])) {
				\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list-item', array(
					'element'    => $element,
					//'element_id' => $element->data['id'],
					'evaluator'  => $evaluator,		
					) );
						
			}
						
		
		endforeach;
		
	endif;
	
	\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'item-edit', array(
		'element'    => $element,
		//'element_id' => $element->data['id'],
		'evaluator'  => $evaluator
	) );

	?>
</div>
