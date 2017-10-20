<?php
/**
 * Affichage d'un accident
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

<tr class="accident-row" data-id="<?php echo esc_attr( $accident->id ); ?>">
	<td data-title="Ref." class="padding">
		<span>
			<strong><?php echo esc_html( $accident->modified_unique_identifier ); ?></strong>
			<span class="tooltip hover" aria-label="<?php esc_attr_e( 'Date d\'inscription dans le registre', 'digirisk' ); ?>">
				<?php echo esc_html( $accident->registration_date_in_register['date_input']['fr_FR']['date'] ); ?>
			</span>
		</span>
	</td>
	<td data-title="Identité victime" class="padding">
		<span><?php echo ! empty( $accident->victim_identity->id ) ? User_Digi_Class::g()->element_prefix . $accident->victim_identity->id . ' ' . $accident->victim_identity->login : ''; ?></span>
	</td>
	<td data-title="Date et heure" class="padding">
		<span><?php echo esc_html( $accident->accident_date['date_input']['fr_FR']['date_time'] ); ?></span>
	</td>
	<td data-title="Lieu" class="padding">
		<span><?php echo esc_html( $accident->place ); ?></span>
	</td>
	<td data-title="Circonstances détaillées" class="padding">
		<?php do_shortcode( '[digi_comment id="' . $accident->id . '" namespace="eoxia" type="comment" display="view" display_date="false" display_user="false"]' ); ?>
	</td>
	<td data-title="NB. Jours arrêt" class="padding">
		<span><?php echo esc_html( $accident->compiled_stopping_days ); ?></span>
	</td>
	<td data-title="Enquête accident" class="padding">
		<span><?php echo ( $accident->have_investigation ) ? '' : __( 'Non' ,'digirisk' ); ?></span>
		<span class="<?php echo ( ! $accident->have_investigation ) ? 'hidden' : ''; ?>">
			<?php do_shortcode( '[wpeo_upload id="' . $accident->id . '" model_name="/digi/' . $accident->get_class() . '" field_name="accident_investigation_id" custom_class="investigation"]' ); ?>
		</span>
	</td>
	<td data-title="Opt. avancées">
		<span class="popup-edit button grey radius w30"><i class="float-icon fa fa-pencil animated"></i><span class="fa fa-cog"></span></span>
	</td>
	<td data-title="Action">
		<div class="action grid-layout w3">
			<a class="button red h50" href="<?php echo esc_attr( Document_Class::g()->get_document_path( $accident->document ) ); ?>"><i class="fa fa-download icon" aria-hidden="true"></i></a>
			<!-- Editer un accident -->
			<div 	class="button light w50 edit action-attribute"
						data-id="<?php echo esc_attr( $accident->id ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_load_accident' ) ); ?>"
						data-loader="accident"
						data-action="load_accident"><i class="icon fa fa-pencil"></i></div>

			<div 	class="button light w50 delete action-delete"
						data-id="<?php echo esc_attr( $accident->id ); ?>"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'ajax_delete_accident' ) ); ?>"
						data-action="delete_accident"><i class="icon fa fa-times"></i></div>
		</div>
	</td>
</tr>
