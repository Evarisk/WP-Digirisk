<?php
/**
 * Appel la méthode pour afficher la liste des listing de risque.
 * Appel la vue "item-edit".
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.5.0
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<table class="table">
	<thead>
		<tr>
			<th class="padding"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</th>
			<th class="padding"><?php esc_html_e( 'Nom', 'digirisk' ); ?></th>
			<th class="w50"></th>
		</tr>
	</thead>

	<tbody>
		<?php if ( ! empty( $documents ) ) : ?>
			<?php foreach ( $documents as $element ) : ?>
				<?php \eoxia\View_Util::exec( 'digirisk', 'listing-risk', 'list-item', array( 'element' => $element ) ); ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>


	<?php
	\eoxia\View_Util::exec( 'digirisk', 'listing-risk', 'item-edit', array(
		'element_id' => $element_id,
		'type'       => $type,
	) );
	?>
</table>
