<?php
/**
 * Affiches la liste des accident
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.3.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpeo-table table-flex table-accident">
	<div class="table-row table-header">
		<div class="table-cell table-150"><?php esc_html_e( 'Ref.', 'digirisk' ); ?></div>
		<div class="table-cell table-150"><?php esc_html_e( 'Nom., Prénom.. victime', 'digirisk' ); ?><span class="red">*</span></div>
		<div class="table-cell table-100"><?php esc_html_e( 'Date et heure', 'digirisk' ); ?><span class="red">*</span></div>
		<div class="table-cell table-150"><?php esc_html_e( 'Lieu', 'digirisk' ); ?><span class="red">*</span></div>
		<div class="table-cell"><?php esc_html_e( 'Circonstances', 'digirisk' ); ?><span class="red">*</span></div>
		<div class="table-cell table-75"><?php esc_html_e( 'Indicateurs', 'digirisk' ); ?></div>
		<div class="table-cell table-150"></div>
	</div>

	<?php
	if ( ! empty( $accidents ) ) :
		foreach ( $accidents as $accident ) :
			\eoxia\View_Util::exec( 'digirisk', 'accident', 'list-item', array(
				'accident' => $accident,
			) );
		endforeach;
	endif;
	?>

	<?php
	\eoxia\View_Util::exec( 'digirisk', 'accident', 'item-add', array(
		'accident'     => $accident_schema,
		'main_society' => $main_society,
	) );
	?>
</div>
