<?php
/**
 * Affiches la liste des causeries
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.6.0
 * @version 6.6.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<h2><?php esc_html_e( 'Causerie à démarrer', 'digirisk' ); ?></h2>

<table class="table causerie">
	<thead>
		<tr>
			<th class="w50 padding"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</th>
			<th class="w50 padding"><?php esc_html_e( 'Photo', 'digirisk' ); ?>.</th>
			<th class="w50 padding"><?php esc_html_e( 'Cat', 'digirisk' ); ?>.</th>
			<th class="w50 padding"><?php esc_html_e( 'Titre et description', 'digirisk' ); ?>.</th>
			<th class="w50"></th>
		</tr>
	</thead>

	<tbody>
		<?php
		if ( ! empty( $causeries ) ) :
			foreach ( $causeries as $causerie ) :
				\eoxia\View_Util::exec( 'digirisk', 'causerie', 'start/list-item', array(
					'causerie' => $causerie,
				) );
			endforeach;
		endif;
		?>
	</tbody>
</table>

<h2><?php esc_html_e( 'Causerie en cours', 'digirisk' ); ?></h2>

<table class="table final-causerie">
	<thead>
		<tr>
			<th class="w50 padding"><?php esc_html_e( 'Ref', 'digirisk' ); ?>.</th>
			<th class="w50 padding"><?php esc_html_e( 'Photo', 'digirisk' ); ?>.</th>
			<th class="w50 padding"><?php esc_html_e( 'Cat', 'digirisk' ); ?>.</th>
			<th class="w50 padding"><?php esc_html_e( 'Titre et description', 'digirisk' ); ?>.</th>
			<th class="w50"></th>
		</tr>
	</thead>

	<tbody>
		<?php
		if ( ! empty( $final_causeries ) ) :
			foreach ( $final_causeries as $causerie ) :
				\eoxia\View_Util::exec( 'digirisk', 'causerie', 'start/list-item', array(
					'causerie' => $causerie,
				) );
			endforeach;
		endif;
		?>
	</tbody>
</table>
