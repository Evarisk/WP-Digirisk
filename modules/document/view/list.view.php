<?php
/**
 * Template permettant d'afficher la liste des fiches de groupement ou de poste.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @copyright (c) 2006-2018 Evarisk <dev@evarisk.com>.
 *
 * @license   AGPLv3 <https://spdx.org/licenses/AGPL-3.0-or-later.html>
 *
 * @package   DigiRisk\Templates
 *
 * @since     6.1.9
 */

namespace digi;

defined( 'ABSPATH' ) || exit; ?>

<thead>
	<tr>
		<th class="padding"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</th>
		<th class="padding"><?php esc_html_e( 'Nom', 'digirisk' ); ?></th>
		<th class="w50"></th>
	</tr>
</thead>

<tbody>
	<?php if ( ! empty( $list_document ) ) : ?>
		<?php foreach ( $list_document as $element ) : ?>
			<?php
			\eoxia\View_Util::exec( 'digirisk', 'document', 'list-item', array(
				'element' => $element,
			) );
			?>
		<?php endforeach; ?>
	<?php endif; ?>
</tbody>
