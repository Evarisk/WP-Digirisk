<?php
/**
 * Le tableau des évaluateurs qui sont affectés.
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.2.3
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<table class="table affected-evaluator">
	
	<tbody>
		<?php if ( ! empty( $list_affected_evaluator ) ) : ?>
			<?php foreach ( $list_affected_evaluator as $sub_list_affected_evaluator ) : ?>
				<?php if ( ! empty( $sub_list_affected_evaluator ) ) : ?>
					<?php foreach ( $sub_list_affected_evaluator as $evaluator ) : ?>
						<tr>
							<td class="w50"><div class="avatar" style="background-color: #<?php echo esc_attr( $evaluator['user_info']->data['avatar_color'] ); ?>;"><span><?php echo esc_html( $evaluator['user_info']->data['initial'] ); ?></span></div></td>
							<td class="padding"><span><strong><?php echo esc_html( Evaluator_Class::g()->element_prefix . $evaluator['user_info']->data['id'] ); ?></strong></span></td>
							<td class="padding"><span><?php echo esc_html( $evaluator['user_info']->data['lastname'] ); ?></span></td>
							<td class="padding"><span><?php echo esc_html( $evaluator['user_info']->data['firstname'] ); ?></span></td>
							<td><?php echo esc_html( mysql2date( 'd/m/Y', $evaluator['affectation_info']['start']['date'], true ) ); ?></td>
							<td class="padding"><?php echo esc_html( Evaluator_Class::g()->get_duration( $evaluator['affectation_info'] ) ); ?></td>
							<td>
									<div class="action">
										<div data-id="<?php echo esc_attr( $element->data['id'] ); ?>"
												data-nonce="<?php echo esc_attr( wp_create_nonce( 'detach_evaluator' ) ); ?>"
												data-action="detach_evaluator"
												data-user-id="<?php echo esc_attr( $evaluator['user_info']->data['id'] ); ?>"
												data-affectation-id="<?php echo esc_attr( $evaluator['affectation_info']['id'] ); ?>"
												data-loader="affected-evaluator"
												data-message-delete="<?php echo esc_attr_e( 'Dissocier l\'évaluateur', 'digirisk' ); ?>"
												class="action-delete wpeo-button button-square-50 button-transparent delete">
												<i class="button-icon fas fa-times"></i>
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
