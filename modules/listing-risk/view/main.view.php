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

<div class="wpeo-table table-flex table-listing-risk">
	<div class="table-row table-header">
		<div class="table-cell table-75"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</div>
		<div class="table-cell table-500"><?php esc_html_e( 'Nom', 'digirisk' ); ?></div>
		<div class="table-cell"><?php esc_html_e('Date de génération','digirisk'); ?></div>
		<div class="table-50 table-end"></div>
	</div>

	<?php if ( ! empty( $documents ) ) : ?>
		<?php foreach ( $documents as $element ) : ?>
			<?php \eoxia\View_Util::exec( 'digirisk', 'listing-risk', 'list-item', array( 'element' => $element ) ); ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php
	\eoxia\View_Util::exec( 'digirisk', 'listing-risk', 'item-edit', array(
		'element_id' => $element_id,
		'type'       => $type,
	) );
	?>
</div>
