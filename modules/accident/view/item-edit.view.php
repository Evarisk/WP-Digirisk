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

<tr class="accident-row edit" data-id="<?php echo esc_attr( $accident->id ); ?>">

	<!-- Les champs obligatoires pour le formulaire -->
	<input type="hidden" name="action" value="edit_accident" />
	<?php wp_nonce_field( 'edit_accident' ); ?>
	<input type="hidden" name="accident[id]" value="<?php echo esc_attr( $accident->id ); ?>" />
	<input type="hidden" name="accident[parent_id]" value="<?php echo esc_attr( $main_society->id ); ?>" />

	<td data-title="Ref." class="padding">
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'accident', 'popup-edit', array(
			'accident' => $accident,
		) );
		?>

		<span>
			<strong><?php echo esc_html( $accident->modified_unique_identifier ); ?></strong>
			<span><?php echo esc_html( $accident->registration_date_in_register['date_input']['fr_FR']['date'] ); ?></span>
		</span>
	</td>
	<td data-title="Identité victime" class="padding">
		<input type="text" data-field="accident[victim_identity_id]" data-type="user" placeholder="" class="digi-search" value="<?php echo ! empty( $accident->victim_identity->id ) ? User_Digi_Class::g()->element_prefix . $accident->victim_identity->id . ' ' . $accident->victim_identity->login : ''; ?>" dir="ltr">
		<input type="hidden" name="accident[victim_identity_id]" value="<?php echo esc_attr( $accident->victim_identity_id ); ?>">
	</td>
	<td data-title="Date et heure" class="group-date padding">
		<input type="text" class="mysql-date" style="width: 0px; padding: 0px; border: none;" name="accident[accident_date]" value="<?php echo esc_attr( $accident->accident_date['date_input']['date'] ); ?>" />
		<input type="text" class="date-time" placeholder="04/01/2017 00:00" value="<?php echo esc_html( $accident->accident_date['date_input']['fr_FR']['date_time'] ); ?>" />
	</td>
	<td data-title="Lieu" class="padding">
		<input name="accident[place]" type="text" value="<?php echo esc_attr( $accident->place ); ?>">
	</td>
	<td data-title="Circonstances détaillées" class="padding">
		<?php do_shortcode( '[digi_comment id="' . $accident->id . '" namespace="eoxia" type="comment" display="edit" display_date="false" display_user="false"]' ); ?>
	</td>
	<td data-title="NB. Jours arrêts" class="padding">
		<ul class="comment-container">
			<?php
			$i = 0;

			if ( ! empty( $accident->number_of_stopping_days ) ) :
				foreach ( $accident->number_of_stopping_days as $i => $stopping_days ) :
					?>
					<li class="comment">
						<span><?php echo '#' . esc_html( $i ); ?></span>
						<input type="hidden" name="accident[number_of_stopping_days][<?php echo esc_attr( $i ); ?>][date]" value="<?php echo esc_attr( $stopping_days['date'] ); ?>" />
						<input type="text" name="accident[number_of_stopping_days][<?php echo esc_attr( $i ); ?>][stopping_days]" value="<?php echo esc_attr( $stopping_days['stopping_days'] ); ?>" />
					</li>
					<?php
				endforeach;
			endif;
			$i++;
			?>
			<li class="comment">
				<span><?php echo '#' . esc_html( $i ); ?></span>
				<input type="hidden" name="accident[number_of_stopping_days][<?php echo esc_attr( $i ); ?>][date]" value="<?php echo esc_attr( current_time( 'mysql' ) ); ?>" />
				<input type="text" name="accident[number_of_stopping_days][<?php echo esc_attr( $i ); ?>][stopping_days]" />
			</li>
		</ul>

	</td>
	<td data-title="Enquête accident" class="padding">
		<select name="accident[have_investigation]">
			<option <?php echo ( ! $accident->have_investigation ) ? 'selected="selected"' : ''; ?> value="0"><?php esc_html_e( 'Non', 'digirisk' ); ?></option>
			<option <?php echo ( $accident->have_investigation ) ? 'selected="selected"' : ''; ?> value="1"><?php esc_html_e( 'Oui', 'digirisk' ); ?></option>
		</select>

		<span class="<?php echo ( ! $accident->have_investigation ) ? 'hidden' : ''; ?>">
			<?php do_shortcode( '[wpeo_upload id="' . $accident->id . '" model_name="/digi/' . $accident->get_class() . '" field_name="accident_investigation_id" custom_class="investigation"]' ); ?>
		</span>
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
