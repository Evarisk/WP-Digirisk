<?php
/**
 * Initialise le tableau contenant les EPI.
 * Appelle la méthode display_epi_list de EPI_Class.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.1.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package epi
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="digirisk-wrap risk-page">
	<table class="table">
		<?php EPI_Class::g()->display_epi_list( $society_id ); ?>
		<?php View_Util::exec( 'epi', 'item-edit', array( 'society_id' => $society_id, 'epi' => $epi ) ); ?>
	</table>
</div>
