<?php
/**
 * Affichage principale pour les diffusions d'informations
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.4.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="content-diffusions-information">
	<table class="table">
		<?php Diffusion_Informations_Class::g()->display_document_list( $element->data['id'] ); ?>
	</table>

	<?php Diffusion_Informations_Class::g()->display_form( $element ); ?>
</div>
