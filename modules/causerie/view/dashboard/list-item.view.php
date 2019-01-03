<?php
/**
 * Causeries déjà effectuées.
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
} ?>


<tr class="item" data-id="<?php echo esc_attr( $causerie->data['id'] ); ?>">
	<td class="w50 padding">
		<strong>
			<span><?php echo esc_html( $causerie->data['unique_identifier'] ); ?></span>
			<?php
			if ( ! empty( $causerie->data['second_identifier'] ) ) :
				?>
				<span><?php echo esc_html( ' - ' . $causerie->data['second_identifier'] ); ?></span>
				<?php
			endif;
			?>
		</strong>
	</td>

	<td data-title="Photo" class="padding">
		<?php echo do_shortcode( '[wpeo_upload id="' . $causerie->data['id'] . '" model_name="' . $causerie->get_class() . '" mode="view" single="false" field_name="image" ]' ); ?>
	</td>

	<td data-title="Catégorie" class="padding">
		<?php
		if ( ! empty( $causerie->data['taxonomy'][ Risk_Category_Class::g()->get_type() ] ) ) :
			do_shortcode( '[digi_dropdown_categories_risk id="' . $causerie->data['id'] . '" type="causerie" display="view" category_risk_id="' . max( $causerie->data['taxonomy'][ Risk_Category_Class::g()->get_type() ] ) . '"]' );
		endif;
		?>
	</td>

	<td data-title="Titre et description" class="padding causerie-description">
		<span class="row-title"><?php echo esc_html( $causerie->data['title'] ); ?></span>
		<span class="row-subtitle"><?php echo esc_html( $causerie->data['content'] ); ?></span>
	</td>

	<td data-title="Date début" class="padding">
		<?php
		if ( \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_CLOSED === $causerie->data['current_step'] ) :
			?>
			<span><?php echo esc_html( $causerie->data['date_start']['rendered']['date_time'] ); ?></span>
			<?php
		else :
			?>
			<span><?php esc_html_e( 'N/A', 'digirisk' ); ?></span>
			<?php
		endif;
		?>
	</td>

	<td data-title="Date cloture" class="padding">
		<?php
		if ( \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_CLOSED === $causerie->data['current_step'] ) :
			?>
			<span><?php echo esc_html( $causerie->data['date_end']['rendered']['date_time'] ); ?></span>
			<?php
		else :
			?>
			<span><?php esc_html_e( 'N/A', 'digirisk' ); ?></span>
			<?php
		endif;
		?>
	</td>

	<td class="padding">
		<?php
		if ( ! empty( $causerie->data['former']['user_id'] ) && ! empty( $causerie->data['former']['rendered'] ) ) :
			$causerie->data['former']['rendered'] = (array) $causerie->data['former']['rendered'];
			?>
		<div class="avatar tooltip hover"
			aria-label="<?php echo esc_attr( $causerie->data['former']['rendered']['data']['displayname'] ); ?>"
			style="background-color: #<?php echo esc_attr( $causerie->data['former']['rendered']['data']['avatar_color'] ); ?>;">
				<span><?php echo esc_html( $causerie->data['former']['rendered']['data']['initial'] ); ?></span>
		</div>
		<?php
	else :
		?>
		<span><?php esc_html_e( 'N/A', 'digirisk' ); ?></span>
		<?php
	endif;
	?>
	</td>

	<td class="padding">
		<div class="wpeo-modal-event wpeo-button-pulse tooltip hover"
			aria-label="<?php echo esc_attr_e( 'Voir les participants', 'digirisk' ); ?>"
			data-title="<?php echo esc_attr_e( 'Liste des participants', 'digirisk' ); ?>"
			data-id="<?php echo esc_attr( $causerie->data['id'] ); ?>"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_modal_participants' ) ); ?>"
			data-action="load_modal_participants"
			data-class="digirisk-wrap wpeo-wrap">
			<i class="button-icon fas fa-user"></i>
			<span class="button-float-icon animated"><i class="fas fa-eye"></i></span>
		</div>
	</td>

	<td>
		<div class="action">
			<?php if ( $causerie->data['sheet_intervention']->data['file_generated'] ) : ?>
				<a class="wpeo-button button-purple button-square-50" href="<?php echo esc_attr( $causerie->data['sheet_intervention']->data['link'] ); ?>">
					<i class="fas fa-download icon" aria-hidden="true"></i>
				</a>
			<?php else : ?>
				<?php if ( $causerie->data['sheet_intervention'] ) : ?>
					<span class="action-attribute wpeo-button button-grey button-square-50 wpeo-tooltip-event"
						data-id="<?php echo esc_attr( $causerie->data['sheet_intervention']->data['id'] ); ?>"
						data-model="<?php echo esc_attr( $causerie->data['sheet_intervention']->get_class() ); ?>"
						data-action="generate_document"
						data-color="red"
						data-direction="left"
						aria-label="<?php echo esc_attr_e( 'Corrompu. Cliquer pour regénérer.', 'digirisk' ); ?>">
						<i class="far fa-times icon" aria-hidden="true"></i>
					</span>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</td>
</tr>
