<?php
/**
 * Le footer de la modal des méthodes d'évaluations complexe.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<span class="cotation level<?php echo esc_attr( ! empty( $risk->data['evaluation'] ) ? $risk->data['evaluation']->data['scale'] : '-1' ); ?>">
	<span><?php echo esc_html( ! empty( $risk->data['evaluation'] ) ? $risk->data['evaluation']->data['risk_level']['equivalence'] : 0 ); ?></span>
</span>

<span class="wpeo-button button-secondary" data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"><span><?php esc_html_e( 'Annuler', 'digirisk' ); ?></span></span>
<span class="wpeo-button button-disable" data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"><span><?php esc_html_e( 'Enregistrer la cotation', 'digirisk' ); ?></span></span>
