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

<?php
\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list', array(
	'element'                 => $element,
	'element_id'              => $element->data['id'],
	'evaluators'              => $evaluators,
	'list_affected_evaluator' => $list_affected_evaluator,
	'default_duration'        => $default_duration,
) );
?>
