<?php
/**
 * Edition d'un accident
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

<div class="accident-row edit" data-id="<?php echo esc_attr( $accident->id ); ?>">

	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="action" value="edit_accident" />
	<?php wp_nonce_field( 'edit_accident' ); ?>
	<input type="hidden" name="accident[id]" value="<?php echo esc_attr( $accident->id ); ?>" />
	<input type="hidden" name="accident[parent_id]" value="<?php echo esc_attr( $main_society->id ); ?>" />

	<div data-title="Ref." class="padding">
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'accident', 'popup-edit', array(
			'accident' => $accident,
		) );
		?>

		<span>
			<strong><?php echo esc_html( $accident->modified_unique_identifier ); ?></strong>
			<span><?php echo esc_html( $accident->registration_date_in_register['date_input']['fr_FR']['date'] ); ?></span>
		</span>
	</div>
	<div data-title="Identité victime" class="padding">
		<input type="text" data-field="accident[victim_identity_id]" data-type="user" placeholder="" class="digi-search" value="<?php echo ! empty( $accident->victim_identity->id ) ? User_Digi_Class::g()->element_prefix . $accident->victim_identity->id . ' ' . $accident->victim_identity->login : ''; ?>" dir="ltr">
		<input type="hidden" name="accident[victim_identity_id]" value="<?php echo esc_attr( $accident->victim_identity_id ); ?>">
	</div>
	<div data-title="Date et heure" class="group-date padding">
		<input type="text" class="mysql-date" style="width: 0px; padding: 0px; border: none;" name="accident[accident_date]" value="<?php echo esc_attr( $accident->accident_date['date_input']['date'] ); ?>" />
		<input type="text" class="date-time" placeholder="04/01/2017 00:00" value="<?php echo esc_html( $accident->accident_date['date_input']['fr_FR']['date_time'] ); ?>" />
	</div>
	<div data-title="Lieu" class="padding">
		<input name="accident[place]" type="text" value="<?php echo esc_attr( $accident->place ); ?>">
	</div>
	<div data-title="Circonstances détaillées" class="padding">
		<?php do_shortcode( '[digi_comment id="' . $accident->id . '" namespace="eoxia" type="comment" display="edit" display_date="false" display_user="false"]' ); ?>
	</div>
	<div data-title="NB. Jours arrêts" class="padding">
		<ul class="comment-container">
			<?php
			$i = 0;

			if ( ! empty( $accident->number_of_stopping_days ) ) :
				foreach ( $accident->number_of_stopping_days as $i => $stopping_days ) :
					?>
					<li class="comment">
						<input type="hidden" name="accident[number_of_stopping_days][<?php echo esc_attr( $i ); ?>][date]" value="<?php echo esc_attr( $stopping_days['date'] ); ?>" />
						<input type="text" name="accident[number_of_stopping_days][<?php echo esc_attr( $i ); ?>][stopping_days]" value="<?php echo esc_attr( $stopping_days['stopping_days'] ); ?>" />
					</li>
					<?php
				endforeach;
			endif;
			$i++;
			?>
			<li class="comment">
				<input type="hidden" name="accident[number_of_stopping_days][<?php echo esc_attr( $i ); ?>][date]" value="<?php echo esc_attr( current_time( 'mysql' ) ); ?>" />
				<input type="text" name="accident[number_of_stopping_days][<?php echo esc_attr( $i ); ?>][stopping_days]" />
			</li>
		</ul>

	</div>

	<div data-title="Enquête accident" class="padding">
		<select name="accident[have_investigation]">
			<option <?php echo ( ! $accident->have_investigation ) ? 'selected="selected"' : ''; ?> value="0"><?php esc_html_e( 'Non', 'digirisk' ); ?></option>
			<option <?php echo ( $accident->have_investigation ) ? 'selected="selected"' : ''; ?> value="1"><?php esc_html_e( 'Oui', 'digirisk' ); ?></option>
		</select>

		<span class="<?php echo ( ! $accident->have_investigation ) ? 'hidden' : ''; ?>">
			<?php do_shortcode( '[wpeo_upload id="' . $accident->id . '" model_name="/digi/' . $accident->get_class() . '" field_name="accident_investigation_id" custom_class="investigation"]' ); ?>
		</span>
	</div>

	<div class="form-element <?php echo ! empty( $accident->location_of_lesions ) ? 'active' : ''; ?>">
		<input type="text" name="accident[location_of_lesions]" value="<?php echo esc_attr( $accident->location_of_lesions ); ?>">
		<span class="bar"></span>
	</div>

	<div class="form-element <?php echo ! empty( $accident->nature_of_lesions ) ? 'active' : ''; ?>">
		<input type="text" name="accident[nature_of_lesions]" value="<?php echo esc_attr( $accident->nature_of_lesions ); ?>">
		<span class="bar"></span>
	</div>

	<div class="form-element <?php echo ! empty( $accident->name_and_address_of_witnesses ) ? 'active' : ''; ?>">
		<textarea name="accident[name_and_address_of_witnesses]"><?php echo $accident->name_and_address_of_witnesses; ?></textarea>
		<span class="bar"></span>
	</div>

	<div class="form-element <?php echo ! empty( $accident->name_and_address_of_third_parties_involved ) ? 'active' : ''; ?>">
		<textarea name="accident[name_and_address_of_third_parties_involved]"><?php echo $accident->name_and_address_of_third_parties_involved; ?></textarea>
		<span class="bar"></span>
	</div>

	<div class="form-element">
		<canvas></canvas>
		<input type="hidden" name="signature_of_the_caregiver" />
		<input type="hidden" class="url" value="<?php echo ! empty( $accident->associated_document_id['signature_of_the_caregiver_id'][0] ) ? esc_attr( wp_get_attachment_url( $accident->associated_document_id['signature_of_the_caregiver_id'][0] ) ) : ''; ?>" />
		<i class="fa fa-eraser" aria-hidden="true"></i>
	</div>

	<div class="form-element">
		<canvas></canvas>
		<input type="hidden" name="signature_of_the_victim" />
		<input type="hidden" class="url" value="<?php echo ! empty( $accident->associated_document_id['signature_of_the_victim_id'][0] ) ? esc_attr( wp_get_attachment_url( $accident->associated_document_id['signature_of_the_victim_id'][0] ) ) : ''; ?>" />
		<i class="fa fa-eraser" aria-hidden="true"></i>
	</div>

	<div class="form-element <?php echo ! empty( $accident->observation ) ? 'active' : ''; ?>">
		<textarea name="accident[observation]"><?php echo $accident->observation; ?></textarea>
		<span></span>
	</div>

	<div data-title="action">
		<?php if ( 0 !== $accident->id ) : ?>
			<div class="action grid-layout w3">
				<div data-parent="accident-row" data-loader="table" data-namespace="digirisk" data-module="accident" data-before-method="saveSignature" class="button w50 green save action-input"><i class="icon fa fa-floppy-o"></i></div>
			</div>
		<?php else : ?>
			<div class="action grid-layout w3">
				<div data-loader="table" data-parent="accident-row" data-namespace="digirisk" data-module="accident" data-before-method="saveSignature" class="button w50 blue add action-input progress"><i class="icon fa fa-plus"></i></div>
			</div>
		<?php endif; ?>
	</div>

</div>
