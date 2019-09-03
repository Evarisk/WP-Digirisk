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

<span data-scale="<?php echo esc_attr( ! empty( $risk->data['evaluation'] ) ? $risk->data['evaluation']->data['scale'] : '-1' ); ?>" class="cotation">
	<span><?php echo esc_html( ! empty( $risk->data['current_equivalence'] && -1 !== $risk->data['current_equivalence'] ) ? $risk->data['current_equivalence'] : 0 ); ?></span>
</span>

<span class="wpeo-button button-grey modal-close" data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"><span><?php esc_html_e( 'Annuler', 'digirisk' ); ?></span></span>
<span class="wpeo-button <?php echo ! empty( $risk->data['evaluation']->data['id'] ) ? 'button-main' : 'button-disable'; ?>" data-id="<?php echo esc_attr( $risk->data['id'] ); ?>">
	<span><?php esc_html_e( 'Enregistrer la cotation', 'digirisk' ); ?></span>
</span>
