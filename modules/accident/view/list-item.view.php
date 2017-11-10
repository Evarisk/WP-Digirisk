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

<div class="col">
	<div data-title="Ref." class="cell padding">
		<ul>
			<li><strong><?php echo esc_attr( $accident->modified_unique_identifier ); ?></strong></li>
			<li><?php echo esc_attr( $accident->registration_date_in_register['date_input']['fr_FR']['date'] ); ?></li>
		</ul>
	</div>
	<div data-title="<?php esc_attr_e( 'Nom., Prénom.. victime', 'digirisk' ); ?>" class="cell padding"><?php echo ! empty( $accident->victim_identity->id ) ? User_Digi_Class::g()->element_prefix . $accident->victim_identity->id . ' ' . $accident->victim_identity->login : ''; ?></div>
	<div data-title="<?php esc_attr_e( 'Date et heure', 'digirisk' ); ?>" class="cell padding"><?php echo esc_html( $accident->accident_date['date_input']['fr_FR']['date_time'] ); ?></div>
	<div data-title="<?php esc_attr_e( 'Lieu', 'digirisk' ); ?>" class="cell padding"><?php echo esc_attr( $accident->place ); ?></div>
	<div data-title="<?php esc_attr_e( 'Circonstances', 'digirisk' ); ?>" class="cell padding"><?php do_shortcode( '[digi_comment id="' . $accident->id . '" namespace="eoxia" type="comment" display="view" display_date="false" display_user="false"]' ); ?></div>
	<div data-title="<?php esc_attr_e( 'Indiciateurs', 'digirisk' ); ?>" class="cell padding"><span class="number-field"><?php echo esc_attr( $accident->number_field_completed ); ?></span>/13</div>
	<div data-title="<?php esc_attr_e( 'action', 'digirisk' ); ?>" class="cell w150">
		<div class="action grid-layout w3">
			<a class="button red h50" href="<?php echo esc_attr( Document_Class::g()->get_document_path( $accident->document ) ); ?>">
				<i class="icon fa fa-download" aria-hidden="true"></i>
				<span>
					<?php esc_html_e( 'AT ', 'digirisk' ); ?>
					<?php echo esc_html( strtoupper( substr( $accident->document->type, 16, 2 ) ) ); ?>
				</span>
			</a>
			<div 	class="button light w50 edit action-attribute"
						data-action="load_accident"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'load_accident' ) ); ?>"
						data-id="<?php echo esc_attr( $accident->id ); ?>"><i class="icon fa fa-pencil"></i></div>
			<div 	class="button light w50 delete action-delete"
						data-action="delete_accident"
						data-nonce="<?php echo esc_attr( wp_create_nonce( 'delete_accident' ) ); ?>"
						data-id="<?php echo esc_attr( $accident->id ); ?>"
						data-message-delete="<?php esc_attr_e( 'Supprimer cet accident', 'digirisk' ); ?>"><i class="icon fa fa-times"></i></div>
		</div>
	</div>
</div>
