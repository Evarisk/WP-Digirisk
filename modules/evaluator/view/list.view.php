<?php
/**
 * Affiches la liste des évaluateurs
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.6.0
 * @version 7.6.0
 * @copyright 2015-2020 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wpeo-table table-flex table-evaluator">
	<div class="table-row table-header">
		<div class="table-cell table-50"><?php esc_html_e( 'ID', 'digirisk' ); ?></div>
		<div class="table-cell"><?php esc_html_e( 'Nom, Prénom', 'digirisk' ); ?></div>
		<div class="table-cell table-125"><?php esc_html_e( 'Date d\'affectation', 'digirisk' ); ?></div>
		<div class="table-cell table-50"><?php esc_html_e( 'Durée', 'digirisk' ); ?></div>
		<div class="table-cell table-50 table-end"></div>
	</div>
	<?php if ( ! empty( $list_affected_evaluator ) ) : ?>
		<?php foreach ( $list_affected_evaluator as $sub_list_affected_evaluator ) : ?>
			<?php if ( ! empty( $sub_list_affected_evaluator ) ) : ?>
				<?php foreach ( $sub_list_affected_evaluator as $evaluator ) : ?>
					<?php \eoxia\View_Util::exec( 'digirisk', 'evaluator', 'list-item', array(
					'element'    => $element,
					'element_id' => $element->data['id'],
					'evaluator'  => $evaluator,
					'default_duration' => $default_duration,
					) );
					?>

				<?php endforeach; ?>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
	<?php

	\eoxia\View_Util::exec( 'digirisk', 'evaluator', 'item-edit', array(
		'element'          => $element,
		'element_id'       => $element->data['id'],
		'list_affected_evaluator' => $list_affected_evaluator,
		'default_duration' => $default_duration,
	) );

	?>
</div>
