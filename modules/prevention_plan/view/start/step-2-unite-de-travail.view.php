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
}

?>
<div class="form-element">
	<div class="wpeo-button button-purple display-modal-unite button-square-50">
		<i class="fas fa-download"></i>
	</div>
</div>
<div class="wpeo-modal digirisk-modal-unite">
		<div class="modal-container">

			<!-- Entête -->
			<div class="modal-header">
				<h2 class="modal-title"><?php esc_html_e( 'Information', 'digirisk' ); ?></h2>
				<div class="modal-close"><i class="fal fa-times"></i></div>
			</div>

			<!-- Corps -->
			<div class="modal-content">
				<div class="tab-container">
					<div class="tab-content tab-active">
						<h1><?php echo esc_html( $tab->title ); ?></h1>
						<?php echo do_shortcode( '[' . $tab->slug . ' post_id="' . $id . '" ]' ); ?>
					</div>
				</div>
			</div>

			<!-- Footer -->
			<div class="modal-footer">
				<a class="wpeo-button button-grey button-uppercase modal-close"><span>Annuler</span></a>
			</div>
		</div>
	</div>
