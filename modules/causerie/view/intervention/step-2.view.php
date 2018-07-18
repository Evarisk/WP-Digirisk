<?php
/**
 * Evaluation d'une causerie: étape 2, permet d'afficher les images associées à la causerie dans un format "slider".
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

<div class="owl-carousel owl-theme" style="width: 800px; margin: auto;">
	<?php
	if ( ! empty( $final_causerie->associated_document_id['image'] ) ) :
		foreach ( $final_causerie->associated_document_id['image'] as $image_id ) :
			?>
			<img style="width: 800px;" src="<?php echo wp_get_attachment_image_url( $image_id, 'full' ); ?>" />
			<?php
		endforeach;
	endif;
	?>
</div>

<div class="button blue float right action-attribute"
	data-action="next_step_causerie"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'next_step_causerie' ) ); ?>"
	data-id="<?php echo esc_attr( $final_causerie->id ); ?>">
	<?php esc_html_e( 'Ajouter des participants', 'digirisk' ); ?></span>
</div>
