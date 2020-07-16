<?php
/**
 * La page principale des causeries.
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

<div>
	<h2 style="float: left"><?php esc_html_e( 'Dernières causeries réalisées', 'digirisk' ); ?></h2>

	<div class="wpeo-table table-flex closed-causerie">
		<div class="table-row table-header">
			<div class="table-cell table-50"><?php esc_html_e( 'Ref.', 'digirisk' ); ?></div>
			<div class="table-cell table-50"><?php esc_html_e( 'Photo', 'digirisk' ); ?></div>
			<div class="table-cell table-50"><?php esc_html_e( 'Cat.', 'digirisk' ); ?></div>
			<div class="table-cell"><?php esc_html_e( 'Titre et description', 'digirisk' ); ?></div>
			<div class="table-cell table-100"><?php esc_html_e( 'Date début', 'digirisk' ); ?></div>
			<div class="table-cell table-100"><?php esc_html_e( 'Date cloture', 'digirisk' ); ?></div>
			<div class="table-cell table-50"><?php esc_html_e( 'Formateur', 'digirisk' ); ?></div>
			<div class="table-cell table-50"><?php esc_html_e( 'Participants', 'digirisk' ); ?></div>
			<div class="table-cell table-50 table-end"></div>
		</div>
		<?php
		if ( ! empty( $causeries_intervention ) ) :
			foreach ( $causeries_intervention as $causerie ) :
				$causerie = apply_filters( 'digi_add_custom_key_to_causerie', $causerie );
				\eoxia\View_Util::exec( 'digirisk', 'causerie', 'dashboard/list-item', array(
					'causerie' => $causerie,
				) );
			endforeach;
		else :
			?>
			<div class="table-row">
				<div class="table-cell" colspan="9" style="text-align: center;"><?php esc_html_e( 'Aucune causerie réalisée pour le moment.', 'digirisk' ); ?></div>
			</div>
			<?php
		endif;
		?>
	</div>
</div>
