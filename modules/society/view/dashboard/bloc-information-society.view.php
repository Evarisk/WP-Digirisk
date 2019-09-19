<?php
/**
 * Données principales de la société
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.3.3
 * @version 7.3.3
 * @copyright 2019 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="wpeo-notice bloc-information-society"
	data-edit="false"
	data-element="bloc-information-society-edit"
	data-action="display_edit_view"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_edit_view' ) ); ?>"
	data-id="<?php echo esc_attr( $element->data[ 'id' ] ); ?>">
	<div class="notice-content" style="display: grid;">
		<div class="notice-title">
    		<span>Information primaire de la société</span>
			<span style="float:right;">Grand cercle</span>
		</div>
		<div class="notice-subtitle">Données primaires de la société, indispensable pour la réalisation de Causerie/ Plan de prévention</div>
		<div class="" style="margin-top:20px; margin-bottom:10px; color: rgb(36, 124, 255);; font-size : 15px">
			<span>
				<i class="fas fa-hashtag"></i><b style="color : #3d4052;"><?php echo esc_attr( $element->data['id'] ); ?></b>
			</span>
			<span class="wpeo-tooltip-event" aria-label="Dernière modification" style="margin-left:20px">
				<i class="fas fa-clock"></i>
				<b style="color : #3d4052;">
					 <?php echo esc_attr( date( 'd/m/Y', strtotime( $element->data[ 'date_modified' ][ 'raw' ] ) ) ); ?>
				</b>
			</span>
			<span class="wpeo-tooltip-event" aria-label="Nom de l'entreprise" style="margin-left:20px">
				<i class="fas fa-building"></i><b style="color : #3d4052;"> <?php echo esc_attr( $element->data['title'] ); ?></b>
			</span>
		</div>
		<div class="bloc-content" style="display : block">
		</div>
	</div>
</div>
