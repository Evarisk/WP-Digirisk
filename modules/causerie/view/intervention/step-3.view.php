<?php
/**
 * Affiches la liste des causeries
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<table class="table causerie">
	<thead>
		<tr>
			<th class="padding"><?php esc_html_e( 'Participant', 'digirisk' ); ?></th>
			<th class="w50 padding"><?php esc_html_e( 'Signature', 'digirisk' ); ?></th>
			<th class="w50"><?php esc_html_e( 'Actions', 'digirisk' ); ?></th>
		</tr>
	</thead>

	<tbody>
		<?php
		if ( ! empty( $final_causerie->participants ) ) :
			foreach ( $final_causerie->participants as $participant ) :
				\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-3-item', array(
					'final_causerie' => $final_causerie,
					'participant'    => $participant,
				) );
			endforeach;
		endif;

		\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-3-item-new', array(
			'final_causerie' => $final_causerie,
		) );
		?>
	</tbody>
</table>

<a class="button grey" href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-causerie' ) ); ?>"><?php esc_html_e( 'Finir plus tard', 'digirisk' ); ?></a>

<a href="<?php echo esc_attr( wp_nonce_url( admin_url( 'admin-post.php?action=next_step_causerie&id=' . $final_causerie->id ), 'next_step_causerie' ) ); ?>" class="button blue float right">
	<span><?php esc_html_e( 'Cloturer la causerie', 'digirisk' ); ?></span>
</a>
