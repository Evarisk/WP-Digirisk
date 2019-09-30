<?php
/**
 * Affiches la cotation d'un risque
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.3
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<?php if ( isset( $risk->data['current_equivalence'] ) && 0 <= $risk->data['current_equivalence'] ) : ?>
	<div class="cotation-container grid wpeo-modal-event tooltip hover"
		data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"
		data-action="historic_risk"
		data-title="<?php echo esc_attr( 'Historique des cotations', 'digirisk' ); ?>"
		data-nonce="<?php echo esc_attr( wp_create_nonce( 'historic_risk' ) ); ?>"
		data-class="wpeo-wrap historic-risk"
		aria-label="<?php esc_html_e( 'Afficher l\'historique des cotations', 'digirisk' ); ?>">

		<div class="action cotation default-cotation" data-scale="<?php echo esc_attr( $risk->data['evaluation']->data['scale'] ); ?>">
			<span><?php echo esc_html( $risk->data['current_equivalence'] ); ?></span>
		</div>

	</div>
<?php else : ?>
	<div class="wpeo-button button-square-40 wpeo-tooltip-event button-disable button-event" data-direction="top" data-color="red" aria-label="<?php echo esc_attr_e( 'Évaluation du risque corrompue', 'digirisk' ); ?>">
		<i class="button-icon fas fa-times" aria-hidden="true" />
	</div>
<?php
endif;
