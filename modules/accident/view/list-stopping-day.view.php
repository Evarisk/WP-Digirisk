<?php
/**
 * La liste des jour d'arrêt.
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.4.0
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<label for="champs1"><?php esc_html_e( 'Nombre jours d\'arrêts', 'digirisk' ); ?></label>
<p><?php esc_html_e( 'Total des jours d\'arrêt:', 'digirisk' ); ?>&nbsp;<strong><?php echo esc_html( $accident->compiled_stopping_days ); ?></strong></p>

<ul class="comment-container">
	<?php
	$i = 0;
	if ( ! empty( $accident->stopping_days ) ) :
		foreach ( $accident->stopping_days as $i => $stopping_day ) :
			?>
			<li class="comment tooltip red" aria-label="<?php esc_attr_e( 'Le champ doit être au format numérique', 'digirisk-epi' ); ?>">
				<input type="hidden" name="accident_stopping_day[<?php echo esc_attr( $i ); ?>][id]" value="<?php echo esc_attr( $stopping_day->id ); ?>" />
				<input type="hidden" name="accident_stopping_day[<?php echo esc_attr( $i ); ?>][parent_id]" value="<?php echo esc_attr( $accident->id ); ?>" />
				<input type="hidden" name="accident_stopping_day[<?php echo esc_attr( $i ); ?>][date]" value="<?php echo esc_attr( $stopping_day->date['date_input']['date'] ); ?>" />
				<input class="is-number" type="text" name="accident_stopping_day[<?php echo esc_attr( $i ); ?>][content]" value="<?php echo esc_attr( $stopping_day->content ); ?>" />
				<?php do_shortcode( '[wpeo_upload id="' . $stopping_day->id . '" field_name="document" single="true" title="' . $accident->modified_unique_identifier . ' : ' . __( "jour d'arrêt", 'digirisk' ) . '" model_name="/digi/Accident_Travail_Stopping_Day_Class" mime_type="application"]' ); ?>
				<span class="button delete action-delete"
							data-id="<?php echo esc_attr( $stopping_day->id ); ?>"
							data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_stopping_day' ) ); ?>"
							data-action="delete_stopping_day"
							data-message-delete="<?php echo esc_attr_e( 'Supprimer', 'digirisk' ); ?>"><i class="icon fa fa-times"></i></span>
			</li>
			<?php
		endforeach;
	endif;
	$i++;
	?>
	<li class="new comment tooltip red" aria-label="<?php esc_attr_e( 'Le champ doit être au format numérique', 'digirisk-epi' ); ?>">
		<input type="hidden" name="accident_stopping_day[<?php echo esc_attr( $i ); ?>][parent_id]" value="<?php echo esc_attr( $accident->id ); ?>" />
		<input type="hidden" name="accident_stopping_day[<?php echo esc_attr( $i ); ?>][date]" value="<?php echo esc_attr( current_time( 'mysql' ) ); ?>" />
		<input class="is-number" type="text" name="accident_stopping_day[<?php echo esc_attr( $i ); ?>][content]" />
		<?php do_shortcode( '[wpeo_upload id="0" model_name="/digi/Accident_Travail_Stopping_Day_Class" field_name="document" single="true" mime_type="application"]' ); ?>
		<span data-namespace="digirisk"
					data-module="accident"
					data-before-method="checkStoppingDayData"
					data-parent="comment"
					data-accident-id="<?php echo esc_attr( $accident->id ); ?>"
					data-action="save_stopping_day"
					class="button add action-input"><i class="icon fa fa-plus"></i></span>
	</li>
</ul>
