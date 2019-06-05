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
	if( ! empty( $task ) ):
		\eoxia\View_Util::exec( 'task-manager', 'task', 'backend/task', array(
			'task' => $task
		) );
	else:
		esc_html_e( 'Veuillez activer Task-Manager pour cette interface', 'digirisk' );

	endif;
?>

<div class="wpeo-button button-blue alignright action-attribute"
data-action="next_step_causerie"
data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_causerie' ) ); ?>"
data-id="<?php echo esc_attr( $final_causerie->data['id'] ); ?>">
<?php esc_html_e( 'Participant(s)', 'digirisk' ); ?>
<i class="fas fa-arrow-right"></i>
</span>
</div>
