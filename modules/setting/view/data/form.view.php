<?php
/**
 * Affichage principale du formulaire pour gérer les valeurs par défaut.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.4.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi; ?>

<?php 
\eoxia\View_Util::exec( 'digirisk', 'setting', 'data/main', array(
	'list_default_values' => $list_default_values,
) );
?>
