<?php
/**
 * Ajoutes le champs pour déplacer une societé vers une autre.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.5
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php
	\eoxia\View_Util::exec( 'digirisk', 'society', 'dashboard/bloc-information-society', array(
		'element' => $element,
		'address' => $address,
	) );
 ?>

 <?php
 	\eoxia\View_Util::exec( 'digirisk', 'society', 'dashboard/bloc-information-society-more', array(
 		'element' => $element,
 		'address' => $address,
 	) );
  ?>

<style media="screen">
	.bloc-information-society:hover{
		border: solid blue 1px;
		cursor : pointer
	}
</style>
