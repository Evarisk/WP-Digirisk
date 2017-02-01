<?php
/**
 * Gestion de l'affichage d'une fiche de groupement
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package sheet_groupment
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<tr>
	<td class="padding"><strong><?php echo esc_html( $element->unique_identifier ); ?></strong></td>
	<td class="padding"><?php echo esc_html( $element->title ); ?></td>
	<td>
		<div class="action">
			<a class="button red h50" href="<?php echo esc_attr( Document_Class::g()->get_document_path( $element ) ); ?>">
				<i class="fa fa-download icon" aria-hidden="true"></i>
				<span><?php esc_html_e( 'Fiche de groupement', 'digirisk' ); ?></span>
			</a>
		</div>
	</td>
</tr>
