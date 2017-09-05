<?php
/**
 * La popup contenant les champs supplémentaires pour les accidents.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<div class="popup">
	<div class="container">

		<div class="header">
			<h2 class="title"><?php esc_html_e( 'blabla', 'digirisk' ); ?></h2>
			<i class="close fa fa-times"></i>
		</div>

		<div class="content">

			<div class="form">
				<ul class="grid-layout w2">
					<li class="form-element">
						<label><?php esc_html_e( 'Date d\'accident', 'digirisk' ); ?></label>
						<span><?php echo esc_html( $accident->accident_date ); ?></span>
						<span class="bar"></span>
					</li>

					<li class="form-element">
						<label><?php esc_html_e( 'Lieu', 'digirisk' ); ?></label>
						<span><?php echo esc_html( $accident->place ); ?></span>
						<span class="bar"></span>
					</li>

					<li class="form-element">
						<label><?php esc_html_e( 'Siège des lésions (préciser droite ou gauche)', 'digirisk' ); ?></label>
						<span><?php echo esc_html( $accident->location_of_lesions ); ?></span>
						<span class="bar"></span>
					</li>

					<li class="form-element">
						<label><?php esc_html_e( 'Nature des lésions', 'digirisk' ); ?></label>
						<span><?php echo esc_html( $accident->nature_of_lesions ); ?></span>
						<span class="bar"></span>
					</li>

					<li class="form-element">
						<label><?php esc_html_e( 'Nom et adresse des témoins', 'digirisk' ); ?></label>
						<span><?php echo esc_html( $accident->name_and_address_of_witnesses ); ?></span>
						<span class="bar"></span>
					</li>

					<li class="form-element">
						<label><?php esc_html_e( 'Nom et adresse des tiers impliqués', 'digirisk' ); ?></label>
						<span><?php echo esc_html( $accident->name_and_address_of_third_parties_involved ); ?></span>
						<span class="bar"></span>
					</li>

					<li class="form-element">
						<p><?php esc_html_e( 'Nom et signature du donneur de soins', 'digirisk' ); ?></p>
						<?php do_shortcode( '[wpeo_upload id="' . $accident->id . '" model_name="/digi/' . $accident->get_class() . '" field_name="name_and_signature_of_the_caregiver_id" custom_class="caregiver"]' ); ?>
					</li>

					<li class="form-element">
						<p><?php esc_html_e( 'Signature de la victime', 'digirisk' ); ?></p>
						<?php do_shortcode( '[wpeo_upload id="' . $accident->id . '" model_name="/digi/' . $accident->get_class() . '" field_name="signature_of_the_victim_id" custom_class="victim"]' ); ?>
					</li>
				</ul>

				<ul>
					<li class="form-element">
						<label><?php esc_html_e( 'Observations (date de la DAT éventuellement)', 'digirisk' ); ?></label>
						<span><?php echo esc_html( $accident->observation ); ?></span>
						<span class="bar"></span>
					</li>
				</ul>

				<div class="button green margin uppercase strong float right"><span><?php esc_html_e( 'OK', 'digirisk' ); ?></span></div>
			</div>

		</div>
	</div>
</div>
