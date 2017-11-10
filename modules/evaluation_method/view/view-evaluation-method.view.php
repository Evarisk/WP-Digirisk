<?php
/**
 * Affiches la cotation d'un risque
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.2.3
 * @version 6.4.0
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div 	class="cotation-container grid open-popup-ajax tooltip hover"
			data-id="<?php echo esc_attr( $risk->id ); ?>"
			data-action="historic_risk"
			data-title="<?php echo esc_attr( 'Historique des cotations', 'digirisk' ); ?>"
			data-nonce="<?php echo esc_attr( wp_create_nonce( 'historic_risk' ) ); ?>"
			data-parent="risk-row"
			data-target="popup"
			data-class="historic-risk"
			aria-label="<?php esc_html_e( 'Afficher l\'historique des cotations', 'digirisk' ); ?>">

	<div class="action cotation default-cotation level<?php echo esc_attr( $risk->evaluation->scale ); ?>">
		<i class="icon fa fa-line-chart" style="<?php echo ( 0 !== $risk->evaluation->scale ) ? 'display: none;' : ''; ?>"></i>
		<span><?php echo esc_html( $risk->evaluation->risk_level['equivalence'] ); ?></span>
	</div>

</div>
