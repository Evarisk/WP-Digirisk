<?php
/**
 * Edition d'un accident
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>
<div class="col advanced" data-id="<?php echo esc_attr( $accident->id ); ?>">
	<input type="hidden" name="action" value="edit_accident" />
	<?php wp_nonce_field( 'edit_accident' ); ?>
	<input type="hidden" name="accident[id]" value="<?php echo esc_attr( $accident->id ); ?>" />
	<input type="hidden" name="accident[parent_id]" value="<?php echo esc_attr( $accident->parent_id ); ?>" />
	<div class="col">
		<div data-title="Ref." class="cell padding w150">
			<ul>
				<li><strong><?php echo esc_attr( $accident->modified_unique_identifier ); ?></strong></li>
				<li><?php echo esc_attr( $accident->registration_date_in_register['date_input']['fr_FR']['date'] ); ?></li>
			</ul>
		</div>
		<div data-title="<?php esc_attr_e( 'Nom., Prénom.. victime', 'digirisk' ); ?>" class="cell padding w200"><?php echo ! empty( $accident->victim_identity->id ) ? User_Digi_Class::g()->element_prefix . $accident->victim_identity->id . ' ' . $accident->victim_identity->login : ''; ?></div>
		<div data-title="<?php esc_attr_e( 'Date et heure', 'digirisk' ); ?>" class="cell padding w150"><?php echo esc_html( $accident->accident_date['date_input']['fr_FR']['date_time'] ); ?></div>
		<div data-title="<?php esc_attr_e( 'Lieu', 'digirisk' ); ?>" class="cell padding w100"><?php echo esc_attr( $accident->place ); ?></div>
		<div data-title="<?php esc_attr_e( 'Circonstances', 'digirisk' ); ?>" class="cell padding"><?php do_shortcode( '[digi_comment id="' . $accident->id . '" namespace="eoxia" type="comment" display="view" display_date="false" display_user="false"]' ); ?></div>
		<div data-title="<?php esc_attr_e( 'Indicateurs', 'digirisk' ); ?>" class="cell padding w70"><span class="number-field"><?php echo esc_attr( $accident->number_field_completed ); ?></span>/13</div>
		<div data-title="<?php esc_attr_e( 'Actions', 'digirisk' ); ?>" class="cell w150">
			<div class="action grid-layout w3">
				<div data-parent="advanced[data-id='<?php echo esc_attr( $accident->id ); ?>']" data-loader="flex-table" data-namespace="digirisk" data-module="accident" data-before-method="checkAllData" class="button w50 green save action-input float right"><i class="icon fa fa-floppy-o"></i></div>
			</div>
		</div>
	</div>

	<div class="advanced">
		<div class="form">
			<div class="grid-layout padding w3">
				<div>
					<label for="champs1"><?php esc_html_e( 'Nom, Prénom, Matricule de la victime', 'digirisk' ); ?></label>
					<input type="text" data-field="accident[victim_identity_id]" data-type="user" placeholder="" class="digi-search" value="<?php echo ! empty( $accident->victim_identity->id ) ? User_Digi_Class::g()->element_prefix . $accident->victim_identity->id . ' ' . $accident->victim_identity->login : ''; ?>" dir="ltr">
					<input type="hidden" name="accident[victim_identity_id]" value="<?php echo esc_attr( $accident->victim_identity_id ); ?>">
				</div>
				<div class="group-date">
					<label for="champs2"><?php esc_html_e( 'Date et heure', 'digirisk' ); ?></label>
					<input type="text" class="mysql-date" style="width: 0px; padding: 0px; border: none;" name="accident[accident_date]" value="<?php echo esc_attr( $accident->accident_date['date_input']['date'] ); ?>" />
					<input type="text" class="date-time" placeholder="04/01/2017 00:00" value="<?php echo esc_html( $accident->accident_date['date_input']['fr_FR']['date_time'] ); ?>" />
				</div>
				<div>
					<label for="champs3"><?php esc_html_e( 'Lieu', 'digirisk' ); ?></label>
					<input name="accident[place]" type="text" value="<?php echo esc_attr( $accident->place ); ?>">
				</div>
			</div>

			<label for="textarea"><?php esc_html_e( 'Circonstances détaillées', 'digirisk' ); ?></label>
			<?php do_shortcode( '[digi_comment id="' . $accident->id . '" namespace="eoxia" type="comment" display="edit" display_date="false" display_user="false"]' ); ?>

			<div class="grid-layout padding w2">
				<div>
					<?php
					\eoxia\View_Util::exec( 'digirisk', 'accident', 'list-stopping-day', array(
						'accident' => $accident,
					) );
					?>
				</div>

				<div>
					<label for="have_investigation"><?php esc_html_e( 'Enquête accident', 'digirisk' ); ?></label>
					<input id="have_investigation" type="checkbox" <?php echo $accident->have_investigation ? 'checked' : ''; ?> name="accident[have_investigation]" />
					<label for="have_investigation" class="no-style"><?php esc_html_e( 'Réaliser une enquête accident', 'digirisk' ); ?></label>
					<span class="<?php echo ( ! $accident->have_investigation ) ? 'hidden' : ''; ?>">
						<?php do_shortcode( '[wpeo_upload id="' . $accident->id . '" model_name="/digi/' . $accident->get_class() . '" single="true" mime_type="application" field_name="accident_investigation_id" custom_class="investigation" title="' . $accident->modified_unique_identifier . ' : ' . __( 'enquête accident', 'digirisk' ) . '"]' ); ?>
					</span>
				</div>
			</div>

			<div class="grid-layout padding w2">
				<div>
					<label for="champs3"><?php esc_html_e( 'Siège des lésions (préciser droite ou gauche)', 'digirisk' ); ?></label>
					<input type="text" name="accident[location_of_lesions]" value="<?php echo esc_attr( $accident->location_of_lesions ); ?>">
				</div>

				<div>
					<label for="champs3"><?php esc_html_e( 'Nature des lésions', 'digirisk' ); ?></label>
					<input type="text" name="accident[nature_of_lesions]" value="<?php echo esc_attr( $accident->nature_of_lesions ); ?>">
				</div>

			</div>

			<div class="grid-layout padding w2">
				<div>
					<label for="textarea"><?php esc_html_e( 'Nom et adresse des témoins', 'digirisk' ); ?></label>
					<textarea id="textarea" name="accident[name_and_address_of_witnesses]"><?php echo $accident->name_and_address_of_witnesses; ?></textarea>
				</div>
				<div>
					<label for="textarea"><?php esc_html_e( 'Nom et adresse des tiers impliqués', 'digirisk' ); ?></label>
					<textarea id="textarea" name="accident[name_and_address_of_third_parties_involved]"><?php echo $accident->name_and_address_of_third_parties_involved; ?></textarea>
				</div>
			</div>

			<div class="grid-layout padding w2">
				<div>
					<label for="textarea"><?php esc_html_e( 'Signature du donneur de soin', 'digirisk' ); ?></label>
					<input type="hidden" name="signature_of_the_caregiver" />
					<input type="hidden" class="url" value="<?php echo ! empty( $accident->associated_document_id['signature_of_the_caregiver_id'][0] ) ? esc_attr( wp_get_attachment_url( $accident->associated_document_id['signature_of_the_caregiver_id'][0] ) ) : ''; ?>" />
					<canvas></canvas>
					<i class="canvas-eraser fa fa-eraser" aria-hidden="true"></i>
				</div>
				<div>
					<label for="textarea"><?php esc_html_e( 'Signature de la victime', 'digirisk' ); ?></label>
					<input type="hidden" name="signature_of_the_victim" />
					<input type="hidden" class="url" value="<?php echo ! empty( $accident->associated_document_id['signature_of_the_victim_id'][0] ) ? esc_attr( wp_get_attachment_url( $accident->associated_document_id['signature_of_the_victim_id'][0] ) ) : ''; ?>" />
					<canvas></canvas>
					<i class="canvas-eraser fa fa-eraser" aria-hidden="true"></i>
				</div>
			</div>

			<label for="textarea"><?php esc_html_e( 'Observations', 'digirisk' ); ?></label>
			<textarea name="accident[observation]"><?php echo $accident->observation; ?></textarea>

			<div data-parent="advanced[data-id='<?php echo esc_attr( $accident->id ); ?>']" data-loader="flex-table" data-namespace="digirisk" data-module="accident" data-before-method="checkAllData" class="button w50 green save action-input float right"><i class="icon fa fa-floppy-o"></i></div>
		</div>
	</div>
</div>
