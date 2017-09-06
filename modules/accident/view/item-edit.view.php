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

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<tr class="accident-row edit">

	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="action" value="edit_accident" />
	<?php wp_nonce_field( 'edit_accident' ); ?>
	<input type="hidden" name="accident[id]" value="<?php echo esc_attr( $accident->id ); ?>" />

	<td data-title="Ref." class="padding">
		<?php \eoxia\View_Util::exec( 'digirisk', 'accident', 'popup-edit', array(
			'accident' => $accident,
		) ); ?>

		<span><strong><?php echo esc_html( $accident->modified_unique_identifier ); ?></strong></span>
	</td>
	<td data-title="Date d'inscription dans le registre" class="padding">
		<?php if ( empty( $accident->id ) ) : ?>
			<input type="text" class="date" name="accident[registration_date_in_register]" value="<?php echo esc_attr( $accident->registration_date_in_register ); ?>" />
		<?php else : ?>
			<span><?php echo esc_html( $accident->registration_date_in_register ); ?></span>
		<?php endif; ?>
	</td>
	<td data-title="Identité victime" class="padding">
		<input type="text" data-field="accident[victim_identity_id]" data-type="user" placeholder="" class="digi-search" value="<?php echo ! empty( $accident->victim_identity->id ) ? User_Digi_Class::g()->element_prefix . $accident->victim_identity->id . ' ' . $accident->victim_identity->login : ''; ?>" dir="ltr">
		<input type="hidden" name="accident[victim_identity_id]" value="<?php echo esc_attr( $accident->victim_identity_id ); ?>">
	</td>
	<td data-title="Circonstances détaillées" class="padding">
		<?php do_shortcode( '[digi_comment id="' . $accident->id . '" namespace="eoxia" type="comment" display="edit" display_date="false" display_user="false"]' ); ?>
	</td>
	<td data-title="Etat" class="padding">
		<input type="text" name="accident[state]" value="<?php echo esc_attr( $accident->state ); ?>" />
	</td>
	<td data-title="Enquête accident" class="padding">
		<?php do_shortcode( '[wpeo_upload id="' . $accident->id . '" model_name="/digi/' . $accident->get_class() . '" field_name="accident_investigation_id" custom_class="investigation"]' ); ?>
	</td>
	<td data-title="Opt. Avancées">
		<span data-parent="accident-row"
					data-target="popup"
					class="open-popup button grey radius w30"><i class="float-icon fa fa-pencil animated"></i><span class="fa fa-cog"></span></span>
	</td>
	<td data-title="action">
		<?php if ( 0 !== $accident->id ) : ?>
			<div class="action grid-layout w3">
				<div data-parent="accident-row" data-loader="table" class="button w50 green save action-input"><i class="icon fa fa-floppy-o"></i></div>
			</div>
		<?php else : ?>
			<div class="action grid-layout w3">
				<div data-loader="table" data-parent="accident-row" class="button w50 blue add action-input progress"><i class="icon fa fa-plus"></i></div>
			</div>
		<?php endif; ?>
	</td>
</tr>
