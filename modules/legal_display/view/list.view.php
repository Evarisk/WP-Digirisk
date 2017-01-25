<?php
/**
 * La liste des DUER
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.1.9.0
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package legal_display
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {	exit; } ?>

<thead>
	<tr>
		<th class="padding"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</th>
		<th class="full"><?php esc_html_e( 'Nom', 'digirisk' ); ?></th>
		<th></th>
	</tr>
</thead>

<tbody>
	<?php if ( ! empty( $list_document ) ) : ?>
		<?php foreach ( $list_document as $element ) : ?>
			<?php View_Util::exec( 'legal_display', 'list-item', array( 'element' => $element ) ); ?>
		<?php endforeach; ?>
	<?php else : ?>
		<tr><td class="padding" colspan="2"><?php esc_html_e( 'Le formulaire ci-dessous permet la génération d\'un affichage légal au format A3 et A4', 'digirisk' ); ?></td></tr>
	<?php endif; ?>
</tbody>
