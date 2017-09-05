<?php
/**
 * Affichage d'un accident
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.3.0
 * @version 6.3.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<tr class="accident-row">
	<td data-title="Ref." class="padding">
		<?php \eoxia\View_Util::exec( 'digirisk', 'accident', 'popup', array(
			'accident' => $accident,
		) ); ?>
		<span><strong><?php echo esc_html( $accident->modified_unique_identifier ); ?></strong></span>
	</td>
	<td data-title="Date et heure" class="padding">
		<span><?php echo esc_html( $accident->registration_date_in_register ); ?></span>
	</td>
	<td data-title="Identité victime" class="padding">
		<span><?php echo ! empty( $accident->victim_identity->id ) ? User_Digi_Class::g()->element_prefix . $accident->victim_identity->id . ' ' . $accident->victim_identity->login : ''; ?></span>
	</td>
	<td data-title="Circonstances détaillées" class="padding">
		<?php do_shortcode( '[digi_comment id="' . $accident->id . '" namespace="eoxia" type="comment" display="view" display_date="false" display_user="false"]' ); ?>
	</td>
	<td data-title="Etat" class="padding">
		<span><?php echo esc_html( $accident->state ); ?></span>
	</td>
	<td data-title="Enquête accident" class="padding">
		<?php do_shortcode( '[wpeo_upload id="' . $accident->id . '" model_name="/digi/' . $accident->get_class() . '" field_name="accident_investigation_id" custom_class="investigation"]' ); ?>
	</td>
	<td data-title="Opt. avancées">
		<div 	class="open-popup button light w50 task"
					data-parent="accident-row"
					data-target="popup">YO</div>
	</td>
	<td data-title="Action">
		<div class="action grid-layout w2">
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
