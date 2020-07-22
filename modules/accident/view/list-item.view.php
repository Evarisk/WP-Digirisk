<?php
/**
 * Affichage d'un accident
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.3.0
 * @version   7.0.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="table-row-advanced">
	<div class="table-row">
		<div data-title="Ref." class="table-cell table-150">
			<strong><?php echo esc_attr( $accident->data['unique_identifier'] ); ?></strong><br>
			<?php echo esc_attr( $accident->data['registration_date_in_register']['rendered']['date'] ); ?>
		</div>
		<div data-title="<?php esc_attr_e( 'Name., Surname.. victim', 'digirisk' ); ?>" class="table-cell table-150"><?php echo ! empty( $accident->data['victim_identity']->data['id'] ) ? '<strong>' . User_Class::g()->element_prefix . $accident->data['victim_identity']->data['id'] . '</strong> ' . $accident->data['victim_identity']->data['login'] : ''; ?></div>
		<div data-title="<?php esc_attr_e( 'Date & hour', 'digirisk' ); ?>" class="table-cell table-100"><i class="icon fas fa-calendar-alt"></i> <?php echo esc_html( $accident->data['accident_date']['rendered']['date_time'] ); ?></div>
		<div data-title="<?php esc_attr_e( 'Place', 'digirisk' ); ?>" class="table-cell table-150"><?php echo ! empty( $accident->data['place'] ) ? '<strong>' . esc_attr( $accident->data['place']->data['unique_identifier'] ) . '</strong> ' . esc_attr( $accident->data['place']->data['title'] ) : __( 'N/A', 'digirisk' ); ?></div>
		<div data-title="<?php esc_attr_e( 'Circumstances', 'digirisk' ); ?>" class="table-cell"><?php do_shortcode( '[digi_comment id="' . $accident->data['id'] . '" namespace="digi" type="accident_comment" display="view" display_date="false" display_user="false"]' ); ?></div>
		<div data-title="<?php esc_attr_e( 'Indicators', 'digirisk' ); ?>" class="table-cell table-75"><span class="number-field"><?php echo esc_attr( $accident->data['number_field_completed'] ); ?></span>/13</div>
		<div data-title="<?php esc_attr_e( 'Actions', 'digirisk' ); ?>" class="table-cell table-150">
			<div class="action wpeo-gridlayout grid-3 grid-gap-0">
				<?php if ( $accident->data['document']->data['file_generated'] ) : ?>
					<a class="wpeo-button button-purple button-square-50" href="<?php echo esc_attr( $accident->data['document']->data['link'] ); ?>">
						<i class="fas fa-download button-icon" aria-hidden="true"></i>
					</a>
				<?php else : ?>
					<span class="action-attribute wpeo-button button-grey button-square-50 wpeo-tooltip-event"
						  data-id="<?php echo esc_attr( $accident->data['document']->data['id'] ); ?>"
						  data-model="<?php echo esc_attr( $accident->data['document']->get_class() ); ?>"
						  data-action="generate_document"
						  data-color="red"
						  data-direction="left"
						  aria-label="<?php echo esc_attr_e( 'Corrupt. Click to regenerate.', 'digirisk' ); ?>">
					<i class="fas fa-times icon" aria-hidden="true"></i>
				</span>
				<?php endif; ?>
				<div class="wpeo-button button-transparent button-square-50 edit action-attribute"
					 data-action="load_accident"
					 data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_accident' ) ); ?>"
					 data-id="<?php echo esc_attr( $accident->data['id'] ); ?>"><i class="icon fas fa-pencil-alt"></i></div>
				<div class="wpeo-button button-transparent button-square-50 delete action-delete"
					 data-action="delete_accident"
					 data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_accident' ) ); ?>"
					 data-id="<?php echo esc_attr( $accident->data['id'] ); ?>"
					 data-message-delete="<?php esc_attr_e( 'Are you sure you want to delete this accident?', 'digirisk' ); ?>"><i class="icon fas fa-trash"></i></div>
			</div>
		</div>
	</div>
</div>
