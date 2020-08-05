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

	if ( ! empty ($element->data['affected_users']) ) : 
		
		foreach( $element->data['affected_users'] as $evaluator) :

			\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list-item', array(
				'element'    => $element,
				'element_id' => $element->data['id'],
				'evaluator'  => $evaluator,
				) );





	/*if ( ! empty( $evaluators ) ) :
		foreach( $evaluators as $evaluator ) :
			if( !empty ( $evaluator->data['affectation_infos']) ) :
				foreach($evaluator->data['affectation_infos'] as $affected_evaluator) :
					
					if ( $affected_evaluator['parent_id'] == $element->data['id'] ) :
						
						\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list-item', array(
							'element'    => $element,
							'element_id' => $element->data['id'],
							'evaluator'  => $evaluator,
							) );
						
					endif;
				endforeach;
			endif;*/
		endforeach;

	endif;

	\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'item-edit', array(
		'element'          => $element,
		'element_id'       => $element->data['id'],
		'evaluator'        => $evaluator,
		'default_duration' => $default_duration,
	) );

	?>
</div>
