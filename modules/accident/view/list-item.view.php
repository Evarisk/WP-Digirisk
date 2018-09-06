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

<div class="col">
	<div data-title="Ref." class="cell padding w150">
		<ul>
			<li><strong><?php echo esc_attr( $accident->data['modified_unique_identifier'] ); ?></strong></li>
			<li><?php echo esc_attr( $accident->data['registration_date_in_register']['rendered']['date'] ); ?></li>
		</ul>
	</div>
	<div data-title="<?php esc_attr_e( 'Nom., Prénom.. victime', 'digirisk' ); ?>" class="cell padding w200"><?php echo ! empty( $accident->data['victim_identity']->data['id'] ) ? '<strong>' . User_Digi_Class::g()->element_prefix . $accident->data['victim_identity']->data['id'] . '</strong> ' . $accident->data['victim_identity']->data['login'] : ''; ?></div>
	<div data-title="<?php esc_attr_e( 'Date et heure', 'digirisk' ); ?>" class="cell padding w150"><i class="icon far fa-calendar-alt"></i> <?php echo esc_html( $accident->data['accident_date']['rendered']['date'] ); ?></div>
	<div data-title="<?php esc_attr_e( 'Lieu', 'digirisk' ); ?>" class="cell padding w200"><?php echo esc_attr( $accident->data['place']->data['modified_unique_identifier'] . ' ' . $accident->data['place']->data['title'] ); ?></div>
	<div data-title="<?php esc_attr_e( 'Circonstances', 'digirisk' ); ?>" class="cell padding"><?php do_shortcode( '[digi_comment id="' . $accident->data['id'] . '" namespace="eoxia" type="comment" display="view" display_date="false" display_user="false"]' ); ?></div>
	<div data-title="<?php esc_attr_e( 'Indicateurs', 'digirisk' ); ?>" class="cell padding w70"><span class="number-field"><?php echo esc_attr( $accident->data['number_field_completed'] ); ?></span>/13</div>
	<div data-title="<?php esc_attr_e( 'Actions', 'digirisk' ); ?>" class="cell w150">
		<div class="action wpeo-gridlayout grid-3">
			<?php if ( $accident->data['document']->data['file_generated'] ) : ?>
				<a class="button purple h50" href="<?php echo esc_attr( $accident->data['document']->data['link'] ); ?>">
					<i class="fas fa-download icon" aria-hidden="true"></i>
				</a>
			<?php else : ?>
				<span class="action-attribute button grey h50 wpeo-tooltip-event"
					data-id="<?php echo esc_attr( $accident->data['document']->data['id'] ); ?>"
					data-model="<?php echo esc_attr( $accident->data['document']->get_class() ); ?>"
					data-action="generate_document"
					data-color="red"
					data-direction="left"
					aria-label="<?php echo esc_attr_e( 'Corrompu. Cliquer pour regénérer.', 'digirisk' ); ?>">
					<i class="far fa-times icon" aria-hidden="true"></i>
				</span>
			<?php endif; ?>
			<div class="button light w50 edit action-attribute"
				data-action="load_accident"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_accident' ) ); ?>"
				data-id="<?php echo esc_attr( $accident->data['id'] ); ?>"><i class="icon fas fa-pencil"></i></div>
			<div class="button light w50 delete action-delete"
				data-action="delete_accident"
				data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_accident' ) ); ?>"
				data-id="<?php echo esc_attr( $accident->data['id'] ); ?>"
				data-message-delete="<?php esc_attr_e( 'Êtes-vous sûr(e) de vouloir supprimer cet accident ?', 'digirisk' ); ?>"><i class="icon far fa-times"></i></div>
		</div>
	</div>
</div>
