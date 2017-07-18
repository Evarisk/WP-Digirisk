<?php
/**
 * Affichage principale pour les diffusions d'informations
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.10.0
 * @version 6.2.10.0
 * @copyright 2015-2017 Evarisk
 * @package society
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<h1><?php esc_html_e( 'Générer la fiche de diffusion d\'information', 'digirisk' ); ?></h1>

<table class="table">
	<?php Diffusion_Informations_Class::g()->display_document_list( $element->id ); ?>
</table>

<?php Diffusion_Informations_Class::g()->display_form( $element ); ?>
