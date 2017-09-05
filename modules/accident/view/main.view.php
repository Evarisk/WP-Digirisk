<?php
/**
 * Apelle la vue list.view du module accident
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<div class="digirisk-wrap">
	<?php Accident_Class::g()->display_accident_list(); ?>

	<?php Accident_Travail_Benin_Class::g()->display(); ?>
</div>
