<?php
/**
 * Gestion de l'affichage d'une fiche de poste
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package sheet_workunit
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<tr>
	<td><strong><?php echo esc_html( $element->unique_identifier ); ?></strong></td>
	<td><?php echo esc_html( $element->title ); ?></td>
	<td>
		<a href="<?php echo esc_attr( Document_Class::g()->get_document_path( $element ) ); ?>">
			<i class="fa fa-download" aria-hidden="true"></i>
			<?php esc_html_e( 'Fiche de poste', 'digirisk' ); ?>
		</a>
	</td>
</tr>
