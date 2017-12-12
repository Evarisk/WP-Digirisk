<?php
/**
 * Affichage principale pour les diffusions d'informations
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.4.0
 * @version 6.4.4
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="content-diffusions-information">
	<table class="table">
		<?php Diffusion_Informations_Class::g()->display_document_list( $element->id ); ?>
	</table>

	<?php Diffusion_Informations_Class::g()->display_form( $element ); ?>
</div>
