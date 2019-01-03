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

<div class="flex-table accident">
	<div class="table-header">
		<div class="col">
			<div class="header-cell padding w150"><?php esc_html_e( 'Ref.', 'digirisk' ); ?></div>
			<div class="header-cell padding w200"><?php esc_html_e( 'Nom., Prénom.. victime', 'digirisk' ); ?><span class="red">*</span></div>
			<div class="header-cell padding w150"><?php esc_html_e( 'Date et heure', 'digirisk' ); ?><span class="red">*</span></div>
			<div class="header-cell padding w200"><?php esc_html_e( 'Lieu', 'digirisk' ); ?><span class="red">*</span></div>
			<div class="header-cell padding"><?php esc_html_e( 'Circonstances', 'digirisk' ); ?><span class="red">*</span></div>
			<div class="header-cell padding w70"><?php esc_html_e( 'Indicateurs', 'digirisk' ); ?></div>
			<div class="header-cell padding w150"></div>
		</div>
	</div>

	<div class="table-body">
		<?php
		if ( ! empty( $accidents ) ) :
			foreach ( $accidents as $accident ) :
				\eoxia\View_Util::exec( 'digirisk', 'accident', 'list-item', array(
					'accident' => $accident,
				) );
			endforeach;
		endif;
		?>
	</div>

	<div class="table-footer">
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'accident', 'item-add', array(
			'accident'     => $accident_schema,
			'main_society' => $main_society,
		) );
		?>
	</div>
</div>
