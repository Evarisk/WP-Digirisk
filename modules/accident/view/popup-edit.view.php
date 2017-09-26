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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="popup">
	<div class="container">

		<div class="header">
			<h2 class="title"><?php esc_html_e( 'blabla', 'digirisk' ); ?></h2>
			<i class="close fa fa-times"></i>
		</div>

		<div class="content">

			<div class="form">
				<ul class="grid-layout padding w2">
					<li>
						<div class="group-date form-element <?php echo ! empty( $accident->accident_date['date_input']['date'] ) ? 'active' : ''; ?>">
							<input type="text" class="mysql-date" style="width: 0px; padding: 0px; border: none;" name="accident[accident_date]" value="<?php echo esc_attr( $accident->accident_date['date_input']['date'] ); ?>" />
							<input type="text" class="date-time" placeholder="04/01/2017 00:00" value="<?php echo esc_html( $accident->accident_date['date_input']['fr_FR']['date_time'] ); ?>" />
							<label><?php esc_html_e( 'Date d\'accident', 'digirisk' ); ?></label>
							<span class="bar"></span>
						</div>
					</li>

					<li>
						<div class="form-element <?php echo ! empty( $accident->place ) ? 'active' : ''; ?>">
							<input name="accident[place]" type="text" value="<?php echo esc_attr( $accident->place ); ?>">
							<label><?php esc_html_e( 'Lieu', 'digirisk' ); ?></label>
							<span class="bar"></span>
						</div>
					</li>

					<li>
						<div class="form-element <?php echo ! empty( $accident->location_of_lesions ) ? 'active' : ''; ?>">
							<input type="text" name="accident[location_of_lesions]" value="<?php echo esc_attr( $accident->location_of_lesions ); ?>">
							<label><?php esc_html_e( 'Siège des lésions (préciser droite ou gauche)', 'digirisk' ); ?></label>
							<span class="bar"></span>
						</div>
					</li>

					<li>
						<div class="form-element <?php echo ! empty( $accident->nature_of_lesions ) ? 'active' : ''; ?>">
							<input type="text" name="accident[nature_of_lesions]" value="<?php echo esc_attr( $accident->nature_of_lesions ); ?>">
							<label><?php esc_html_e( 'Nature des lésions', 'digirisk' ); ?></label>
							<span class="bar"></span>
						</div>
					</li>

					<li>
						<div class="form-element <?php echo ! empty( $accident->name_and_address_of_witnesses ) ? 'active' : ''; ?>">
							<textarea name="accident[name_and_address_of_witnesses]"><?php echo $accident->name_and_address_of_witnesses; ?></textarea>
							<label><?php esc_html_e( 'Nom et adresse des témoins', 'digirisk' ); ?></label>
							<span class="bar"></span>
						</div>
					</li>

					<li>
						<div class="form-element <?php echo ! empty( $accident->name_and_address_of_third_parties_involved ) ? 'active' : ''; ?>">
							<textarea name="accident[name_and_address_of_third_parties_involved]"><?php echo $accident->name_and_address_of_third_parties_involved; ?></textarea>
							<label><?php esc_html_e( 'Nom et adresse des tiers impliqués', 'digirisk' ); ?></label>
							<span class="bar"></span>
						</div>
					</li>

					<li>
						<div class="form-element">
							<p><?php esc_html_e( 'Nom et signature du donneur de soins', 'digirisk' ); ?></p>
							<?php do_shortcode( '[wpeo_upload id="' . $accident->id . '" model_name="/digi/' . $accident->get_class() . '" single="true" field_name="name_and_signature_of_the_caregiver_id" custom_class="caregiver" ]' ); ?>
						</div>
					</li>

					<li>
						<div class="form-element">
							<p><?php esc_html_e( 'Signature de la victime', 'digirisk' ); ?></p>
							<?php do_shortcode( '[wpeo_upload id="' . $accident->id . '" model_name="/digi/' . $accident->get_class() . '" single="true" field_name="signature_of_the_victim_id" custom_class="victim" ]' ); ?>
						</div>
					</li>
				</ul>

				<ul>
					<li class="form-element <?php echo ! empty( $accident->observation ) ? 'active' : ''; ?>">
						<textarea name="accident[observation]"><?php echo $accident->observation; ?></textarea>
						<label><?php esc_html_e( 'Observations (date de la DAT éventuellement)', 'digirisk' ); ?></label>
						<span class="bar"></span>
					</li>
				</ul>

				<div class="button green margin uppercase strong float right"><span><?php esc_html_e( 'Save', 'digirisk' ); ?></span></div>
			</div>
		</div>
	</div>
</div>
