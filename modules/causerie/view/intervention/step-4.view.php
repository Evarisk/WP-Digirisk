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

<div class="wpeo-table table-flex table-causerie causerie causerie-step-4">
	<div class="table-row">
		<div class="table-cell"><?php esc_html_e( 'Participant', 'digirisk' ); ?></div>
		<div class="table-cell table-100"><?php esc_html_e( 'Signature', 'digirisk' ); ?></div>
		<div class="table-cell table-50 table-end"><?php esc_html_e( 'Actions', 'digirisk' ); ?></div>
	</div>

	<?php
	if ( ! empty( $final_causerie->data['participants'] ) ) :
		foreach ( $final_causerie->data['participants'] as $participant ) :
			\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-4-item', array(
				'final_causerie' => $final_causerie,
				'participant'    => $participant,
			) );
		endforeach;
	endif;

	\eoxia\View_Util::exec( 'digirisk', 'causerie', 'intervention/step-4-item-new', array(
		'final_causerie' => $final_causerie,
	) );
	?>
</div>

<a href="<?php echo Causerie_Intervention_Class::g()->get_link( $final_causerie, 3 ); ?>" class="wpeo-button button-grey">
	<i class="fas fa-arrow-left"></i>
	<span><?php esc_html_e( 'Tâche liée', 'digirisk' ); ?></span>
</a>

<a href="<?php echo esc_attr( wp_nonce_url( admin_url( 'admin-post.php?action=next_step_causerie&id=' . $final_causerie->data['id'] ), 'next_step_causerie' ) ); ?>"
	class="<?php echo ( ! $all_signed ) ? esc_attr( 'button-disable wpeo-tooltip-event' ) : ''; ?> wpeo-button button-blue alignright"
	aria-label="<?php esc_attr_e( 'Veuillez ajouter des participants et les faire signer avant de cloturer la causerie', 'digirisk' ); ?>"
	data-direction="left">
	<span><?php esc_html_e( 'Cloturer la causerie', 'digirisk' ); ?></span>
</a>
