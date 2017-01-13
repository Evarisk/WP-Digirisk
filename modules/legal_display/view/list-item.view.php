<?php
/**
 * Gestion de l'affichage d'un affichage légal
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package legal_display
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<tr>
	<td><strong><?php echo esc_html( $element->unique_identifier ); ?></strong></td>
	<td><?php echo esc_html( $element->title ); ?></td>
	<td class="padded flex-tmp">
		<a href="<?php echo esc_attr( Document_Class::g()->get_document_path( $element ) ); ?>">
			<i class="fa fa-download" aria-hidden="true"></i>
			<?php esc_html_e( 'Affichage légal ', 'digirisk' ); ?>
			<?php echo esc_html( strtoupper( substr( $element->type, 16, 2 ) ) ); ?></a>
	</td>
</tr>
