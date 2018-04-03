<?php
/**
 * La vue contenant les deux blocs pour afficher les évaluateurs
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.3
 * @version 6.2.4.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<section class="grid-layout padding w2">
	<!-- Le bloc des utilisateurs affectés -->
	<div>
		<?php do_shortcode( '[digi-search id="' . $element->data['id'] . '" icon="dashicons dashicons-search" next-action="display_evaluator_affected" type="user" target="affected-evaluator"]' ); ?>
		<!-- La liste des utilisateurs affectés -->
		<?php \eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list-evaluator-affected', array( 'element' => $element, 'element_id' => $element->data['id'], 'current_page' => $current_page, 'number_page' => $number_page, 'list_affected_evaluator' => $list_affected_evaluator ) ); ?>
	</div>

	<!-- Le bloc des utilisateurs à affecter -->
	<div>
		<?php do_shortcode( '[digi-search id="' . $element->data['id'] . '" icon="dashicons dashicons-search" next-action="display_evaluator_to_assign" type="user" target="form-edit-evaluator-assign"]' ); ?>
		<!-- La liste des utilisateurs à affecter -->
		<?php \eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list-evaluator-to-assign', array( 'element' => $element, 'element_id' => $element->data['id'], 'current_page' => $current_page, 'number_page' => $number_page, 'evaluators' => $evaluators ) ); ?>
	</div>
</section>
