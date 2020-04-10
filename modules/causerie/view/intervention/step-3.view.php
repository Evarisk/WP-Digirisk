<?php
/**
 * Etape de recuperation des tasks
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2019 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>


<?php
	if( ! empty( $task ) ) :
		echo do_shortcode( '[task id="' . $task->data['id'] . '"]' );
	else :
		esc_html_e( 'Veuillez activer Task-Manager pour cette interface', 'digirisk' );
	endif;
?>

<a href="<?php echo Causerie_Intervention_Class::g()->get_link( $final_causerie, 2 ); ?>" class="wpeo-button button-grey">
	<i class="fas fa-arrow-left"></i>
	<span><?php esc_html_e( 'Lecture de la causerie', 'digirisk' ); ?></span>
</a>

<div class="wpeo-button button-blue alignright action-attribute"
	data-action="next_step_causerie"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_causerie' ) ); ?>"
	data-id="<?php echo esc_attr( $final_causerie->data['id'] ); ?>">
	<?php esc_html_e( 'Participant(s)', 'digirisk' ); ?>
	<i class="fas fa-arrow-right"></i>
	</span>
</div>
