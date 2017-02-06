<?php
/**
 * La vue principale de la page "Risques"
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package risk
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="digirisk-wrap risk-page">

	<table class="table risk">
		<?php Risk_Page_Class::g()->display_risk_list(); ?>
	</table>

	<a href="#" class="button disable save-all right">Enregistrer</a>

</div>
