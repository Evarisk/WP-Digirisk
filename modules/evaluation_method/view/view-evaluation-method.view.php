<?php
/**
 * Affiches la cotation d'un risque
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.3
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php if ( ! empty( $risk->current_equivalence ) && 0 <= $risk->current_equivalence ) : ?>
	<div class="cotation-container grid open-popup-ajax tooltip hover"
		data-id="<?php echo esc_attr( $risk->id ); ?>"
		data-action="historic_risk"
		data-title="<?php echo esc_attr( 'Historique des cotations', 'digirisk' ); ?>"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'historic_risk' ) ); ?>"
		data-parent="risk-row"
		data-target="popup"
		data-class="historic-risk"
		aria-label="<?php esc_html_e( 'Afficher l\'historique des cotations', 'digirisk' ); ?>">

		<div class="action cotation default-cotation level<?php echo esc_attr( $risk->evaluation->scale ); ?>">
			<i class="icon fas fa-chart-line" style="<?php echo ( 0 !== $risk->evaluation->scale ) ? 'display: none;' : ''; ?>"></i>
			<span><?php echo esc_html( $risk->current_equivalence ); ?></span>
		</div>

	</div>
<?php else : ?>
	<div class="button grey h50 tooltip hover red" aria-label="<?php echo esc_attr_e( 'Évaluation du risque corrompue', 'digirisk' ); ?>">
		<i class="fa fa-times icon" aria-hidden="true" />
	</div>
<?php
endif;
