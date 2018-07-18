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


<tr class="item">
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
		<?php do_shortcode( '[wpeo_upload id="' . $causerie->data['id'] . '" model_name="/digi/' . $causerie->data['get_class']() . '" mode="view" single="false" field_name="image" ]' ); ?>
	</td>

	<td data-title="Catégorie" class="padding">
		<?php
		if ( ! empty( $causerie->data['taxonomy'][ Risk_Category_Class::g()->get_type() ] ) ) :
			do_shortcode( '[digi-dropdown-categories-risk id="' . $causerie->data['id'] . '" type="causerie" display="view" category_risk_id="' . max( $causerie->data['taxonomy'][ Risk_Category_Class::g()->get_type() ] ) . '"]' );
		endif;
		?>
	</td>

	<td data-title="Titre et description" class="padding wpeo-grid grid-1">
		<span><?php echo esc_html( $causerie->data['title'] ); ?></span>
		<span><?php echo esc_html( $causerie->data['content'] ); ?></span>
	</td>

	<td data-title="Date début" class="padding">
		<?php
		if ( \eoxia\Config_Util::$init['digirisk']->causerie->steps->CAUSERIE_CLOSED === $causerie->data['current_step'] ) :
			?>
			<span><?php echo esc_html( $causerie->data['date_start']['date_human_readable'] ); ?></span>
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
			<span><?php echo esc_html( $causerie->data['date_end']['date_human_readable'] ); ?></span>
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
			aria-label="<?php echo esc_attr( $causerie->data['former']['rendered']['displayname'] ); ?>"
			style="background-color: #<?php echo esc_attr( $causerie->data['former']['rendered']['avatar_color'] ); ?>;">
				<span><?php echo esc_html( $causerie->data['former']['rendered']['initial'] ); ?></span>
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
		<div class="wpeo-modal-event button grey radius w30 tooltip hover"
			aria-label="<?php echo esc_attr_e( 'Voir les participants', 'digirisk' ); ?>"
			data-title="<?php echo esc_attr_e( 'Liste des participants', 'digirisk' ); ?>"
			data-id="<?php echo esc_attr( $causerie->data['id'] ); ?>"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_modal_participants' ) ); ?>"
			data-action="load_modal_participants"
			data-class="digirisk-wrap wpeo-wrap">
			<i class="float-icon fa fa-eye animated"></i><span class="dashicons dashicons-admin-users"></span>
		</div>
	</td>

	<td>
		<div class="action grid-layout w1">
			<?php if ( ! empty( $causerie->data['document'] ) && ! empty( $causerie->data['document']->data['path'] ) ) : ?>
				<a class="button purple h50" href="<?php echo esc_attr( $causerie->data['document']->data['path'] ); ?>">
					<i class="fa fa-download icon" aria-hidden="true"></i>
				</a>
			<?php else : ?>
				<span class="button grey h50 tooltip hover red" aria-label="<?php echo esc_attr_e( 'ODT Corrompu', 'digirisk' ); ?>">
					<i class="fa fa-times icon" aria-hidden="true"></i>
				</span>
			<?php endif; ?>
		</div>
	</td>
</tr>
