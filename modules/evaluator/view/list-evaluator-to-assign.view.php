<?php
/**
 * Le tableau des évaluateurs qui peuvent être affecté.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3.0
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package evaluator
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<form method="POST" class="form-edit-evaluator-assign" action="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>">

	<table class="table evaluators">
		<thead>
			<tr>
				<th class="w50"></th>
				<th class="padding w50"><?php esc_html_e( 'ID', 'digirisk' ); ?></th>
				<th class="padding"><?php esc_html_e( 'Nom', 'digirisk' ); ?></th>
				<th class="padding"><?php esc_html_e( 'Prénom', 'digirisk' ); ?></th>
				<th class="w100 padding"><?php esc_html_e( 'Date d\'embauche', 'digirisk' ); ?></th>
				<th class="w50 padding"><input type="text" class="affect" value="15"></th>
				<th class="w50 padding"><?php esc_html_e( 'Affecter', 'digirisk' ); ?></th>
			</tr>
		</thead>

		<tbody>
			<?php if ( ! empty( $evaluators ) ) : ?>
				<?php foreach ( $evaluators as $evaluator ) : ?>
					<tr>
						<td><div class="avatar" style="background-color: #<?php echo esc_attr( $evaluator->avatar_color ); ?>;"><span><?php echo esc_html( $evaluator->initial ); ?></span></div></td>
						<td class="padding"><span><strong><?php echo esc_html( Evaluator_Class::g()->element_prefix . $evaluator->id ); ?><strong></span></td>
						<td class="padding"><span><?php echo esc_html( $evaluator->lastname ); ?></span></td>
						<td class="padding"><span><?php echo esc_html( $evaluator->firstname ); ?></span></td>
						<td class="padding"><input type="text" class="date" name="list_user[<?php echo esc_attr( $evaluator->id ); ?>][on]" value="<?php echo esc_attr( date( 'd/m/Y', strtotime( $evaluator->hiring_date ) ) ); ?>"></td>
						<td class="padding"><input type="text" class="affect" name="list_user[<?php echo esc_attr( $evaluator->id ); ?>][duration]" value=""></td>
						<td class="padding"><input type="checkbox" name="list_user[<?php echo esc_attr( $evaluator->id ); ?>][affect]"></td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>

	<?php wp_nonce_field( 'edit_evaluator_assign' ); ?>
	<input type="hidden" name="element_id" value="<?php echo esc_attr( $element->id ); ?>" />
	<input type="hidden" name="action" value="edit_evaluator_assign" />
	<div class="button green uppercase strong float right margin submit-form"><span><?php esc_html_e( 'Mettre à jour', 'digirisk' ); ?></span></div>

</form>
