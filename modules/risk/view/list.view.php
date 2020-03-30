<?php
/**
 * Affiches la liste des risques
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpeo-table table-flex table-risk">
	<div class="table-row table-header">
		<div class="table-cell table-75"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</div>
		<div class="table-cell table-50"><?php esc_html_e( 'Risque', 'digirisk' ); ?></div>
		<div class="table-cell table-50"><?php esc_html_e( 'Cot', 'digirisk' ); ?></div>
		<div class="table-cell table-50"><?php esc_html_e( 'Photo', 'digirisk' ); ?></div>
		<div class="table-cell"><?php esc_html_e( 'Commentaire', 'digirisk' ); ?></div>
		<div class="table-cell table-100 table-end"></div>
	</div>

	<?php
	if ( ! empty( $risks ) ) :
		foreach ( $risks as $risk ) :
			\eoxia\View_Util::exec( 'digirisk', 'risk', 'list-item', array(
				'society_id' => $society_id,
				'risk'       => $risk,
				'societies'  => $societies,
			) );
		endforeach;
	endif;

	\eoxia\View_Util::exec( 'digirisk', 'risk', 'item-edit', array(
		'society_id' => $society_id,
		'risk'       => $risk_schema,
	) );
	?>
</div>
