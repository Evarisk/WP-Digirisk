<?php
/**
 * Affiches la liste des causeries
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<h2><?php esc_html_e( 'Causerie à démarrer', 'digirisk' ); ?></h2>

<div class="wpeo-table table-flex start-causerie">
	<div class="table-row table-header">
		<div class="table-cell table-50"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</div>
		<div class="table-cell table-50"><?php esc_html_e( 'Photo', 'digirisk' ); ?>.</div>
		<div class="table-cell table-50"><?php esc_html_e( 'Cat', 'digirisk' ); ?>.</div>
		<div class="table-cell"><?php esc_html_e( 'Titre et description', 'digirisk' ); ?>.</div>
		<div class="table-cell table-100 table-end"></div>
	</div>
	<?php
	if ( ! empty( $causeries ) ) :
		foreach ( $causeries as $causerie ) :
			$causerie = apply_filters( 'digi_add_custom_key_to_causerie', $causerie );
			\eoxia\View_Util::exec( 'digirisk', 'causerie', 'start/list-item', array(
				'causerie' => $causerie,
				'started'  => false,
			) );
		endforeach;
	else :
		?>
		<div class="table-row">
			<div class="table-cell" colspan="5" style="text-align: center;"><?php esc_html_e( 'Aucune causerie à démarrer', 'digirisk' ); ?></div>
		</div>
		<?php
	endif;
	?>
</div>

<h2><?php esc_html_e( 'Causerie en cours', 'digirisk' ); ?></h2>

<div class="wpeo-table table-flex final-causerie">
	<div class="table-row table-header">
		<div class="table-cell table-50"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</div>
		<div class="table-cell table-50"><?php esc_html_e( 'Photo', 'digirisk' ); ?>.</div>
		<div class="table-cell table-50"><?php esc_html_e( 'Cat', 'digirisk' ); ?>.</div>
		<div class="table-cell"><?php esc_html_e( 'Titre et description', 'digirisk' ); ?>.</div>
		<div class="table-cell table-100 table-end"></div>
	</div>

	<?php
	if ( ! empty( $causeries_intervention ) ) :
		foreach ( $causeries_intervention as $causerie_intervention ) :
			$causerie_intervention = apply_filters( 'digi_add_custom_key_to_causerie', $causerie_intervention );
			\eoxia\View_Util::exec( 'digirisk', 'causerie', 'start/list-item', array(
				'causerie' => $causerie_intervention,
				'started'  => true,
			) );
		endforeach;
	else :
		?>
		<div class="table-row">
			<div class="table-cell" colspan="5" style="text-align: center;"><?php esc_html_e( 'Aucune causerie en cours', 'digirisk' ); ?></div>
		</div>
		<?php
	endif;
	?>
</div>
