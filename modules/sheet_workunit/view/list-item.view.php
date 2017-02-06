<?php
/**
 * Gestion de l'affichage d'une fiche de poste
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9.0
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package sheet_workunit
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<tr>
	<td class="padding w50"><strong><?php echo esc_html( $element->unique_identifier ); ?></strong></td>
	<td class="padding"><?php echo esc_html( $element->title ); ?></td>
	<td class="w50">
		<div class="action">
			<a class="button red h50" href="<?php echo esc_attr( Document_Class::g()->get_document_path( $element ) ); ?>">
				<i class="fa fa-download" aria-hidden="true"></i>
				<span><?php esc_html_e( 'Fiche de poste', 'digirisk' ); ?></span>
			</a>
		</div>
	</td>
</tr>
