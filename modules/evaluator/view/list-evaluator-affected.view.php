<?php
/**
 * Le tableau des évaluateurs qui sont affectés.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.5.0
 * @copyright 2015-2017 Evarisk
 * @package evaluator
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<table class="table affected-evaluator">
	<thead>
		<tr>
			<th class="w50"></th>
			<th class="padding"><?php esc_html_e( 'ID', 'digirisk' ); ?></th>
			<th class="padding"><?php esc_html_e( 'Nom', 'digirisk' ); ?></th>
			<th class="padding"><?php esc_html_e( 'Prénom', 'digirisk' ); ?></th>
			<th><?php esc_html_e( 'Date d\'affectation', 'digirisk' ); ?></th>
			<th class="padding"><?php esc_html_e( 'Durée', 'digirisk' ); ?></th>
			<th class="w50"></th>
		</tr>
	</thead>

	<tbody>
		<?php if ( ! empty( $list_affected_evaluator ) ) : ?>
			<?php foreach ( $list_affected_evaluator as $sub_list_affected_evaluator ) : ?>
				<?php if ( ! empty( $sub_list_affected_evaluator ) ) : ?>
					<?php foreach ( $sub_list_affected_evaluator as $evaluator ) : ?>
						<tr>
							<td class="w50"><div class="avatar" style="background-color: #<?php echo esc_attr( $evaluator['user_info']->avatar_color ); ?>;"><span><?php echo esc_html( $evaluator['user_info']->initial ); ?></span></div></td>
							<td class="padding"><span><strong><?php echo esc_html( Evaluator_Class::g()->element_prefix . $evaluator['user_info']->id ); ?></strong></span></td>
							<td class="padding"><span><?php echo esc_html( $evaluator['user_info']->lastname ); ?></span></td>
							<td class="padding"><span><?php echo esc_html( $evaluator['user_info']->firstname ); ?></span></td>
							<td><?php echo esc_html( mysql2date( 'd/m/Y H:i', $evaluator['affectation_info']['start']['date'], true ) ); ?></td>
							<td class="padding"><?php echo esc_html( Evaluator_Class::g()->get_duration( $evaluator['affectation_info'] ) ); ?></td>
							<td>
									<div class="action">
										<div data-id="<?php echo esc_attr( $element->id ); ?>"
												data-nonce="<?php echo esc_attr( wp_create_nonce( 'detach_evaluator' ) ); ?>"
												data-action="detach_evaluator"
												data-user-id="<?php echo esc_attr( $evaluator['user_info']->id ); ?>"
												data-affectation-id="<?php echo esc_attr( $evaluator['affectation_info']['id'] ); ?>"
												data-loader="affected-evaluator"
												class="action-delete button w50 light delete">
												<i class="icon fa fa-times"></i>
											</div>
										</div>
								</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
