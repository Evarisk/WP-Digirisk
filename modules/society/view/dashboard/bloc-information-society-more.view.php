<?php
/**
 * Données complementaires de la société
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
	data-element="bloc-information-society-more-edit"
	data-action="display_edit_view"
	data-nonce="<?php echo esc_attr( wp_create_nonce( 'display_edit_view' ) ); ?>"
	data-id="<?php echo esc_attr( $element->data[ 'id' ] ); ?>">
	<div class="notice-content" style="display: grid;">
		<div class="notice-title">
			<span>Information complémentaire de la société</span>
			<span style="float:right;">Grand cercle</span>
		</div>
		<div class="notice-subtitle">Données complémentaires à la société, possiblement utilisé dans la réalisation de Causerie/ Plan de prévention</div>
		<div class="bloc-content" style="display : block">
	</div>
</div>
