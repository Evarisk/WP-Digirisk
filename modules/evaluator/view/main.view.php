<?php
/**
 * La vue contenant les deux blocs pour afficher les évaluateurs
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.3
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $eo_search; ?>

<section class="grid-layout padding w2">
	<!-- Le bloc des utilisateurs affectés -->
	<div>
		<?php $eo_search->display( 'evaluator_affected' ); ?>
		<!-- La liste des utilisateurs affectés -->
		<?php \eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list-evaluator-affected', array( 'element' => $element, 'element_id' => $element->data['id'], 'current_page' => $current_page, 'number_page' => $number_page, 'list_affected_evaluator' => $list_affected_evaluator ) ); ?>
	</div>

	<!-- Le bloc des utilisateurs à affecter -->
	<div>
		<?php $eo_search->display( 'evaluator_to_assign' ); ?>
		<!-- La liste des utilisateurs à affecter -->
		<?php \eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list-evaluator-to-assign', array( 'element' => $element, 'element_id' => $element->data['id'], 'current_page' => $current_page, 'number_page' => $number_page, 'evaluators' => $evaluators ) ); ?>
	</div>
</section>
