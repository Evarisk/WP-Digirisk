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
	<h2 style="font-size: 20px; font-weight: normal; margin-bottom: 10px; float:left">
		<?php esc_html_e( sprintf( 'Liste des permis de feu réalisés (%1$d)', ! empty( $list_permis_feu ) ? count( $list_permis_feu ) : '0' ), 'digirisk' ); ?>
	</h2>

	<div class="wpeo-table table-flex closed-permis-feu">
		<div class="table-row table-header">
			<div class="table-cell table-50"><?php esc_html_e( 'Ref.', 'digirisk' ); ?></div>
			<div class="table-cell"><?php esc_html_e( 'Titre', 'digirisk' ); ?></div>
			<div class="table-cell table-100"><?php esc_html_e( 'Début intervention', 'digirisk' ); ?></div>
			<div class="table-cell table-100"><?php esc_html_e( 'Fin intervention', 'digirisk' ); ?></div>
			<!-- <div class=""><?php esc_html_e( 'Formateur', 'digirisk' ); ?></div> -->
			<div class="table-cell table-50 "><?php esc_html_e( 'Maitre d\'oeuvre', 'digirisk' ); ?></div>
			<div class="table-cell table-100"><?php esc_html_e( 'Intervenant (Exterieur)', 'digirisk' ); ?></div>
			<div class="table-cell table-100"><?php esc_html_e( 'P de prévention', 'digirisk' ); ?></div>
			<div class="table-cell table-100"><?php esc_html_e( 'Intervenant(s)', 'digirisk' ); ?></div>
			<div class="table-cell table-100"><?php esc_html_e( 'Intervention(s)', 'digirisk' ); ?></div>
			<div class="table-cell table-150 table-end"></div>
		</div>
		<?php

		if ( ! empty( $list_permis_feu ) ) :
			foreach ( $list_permis_feu as $permis_feu ) :
				\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'dashboard/list-item', array(
					'permis_feu' => Permis_Feu_Class::g()->add_information_to_permis_feu( $permis_feu ),
				) );
			endforeach;
		else :
			?>
			<div class="table-row">
				<div class="table-cell" style="text-align: center;"><?php esc_html_e( 'Aucun permis de feu réalisé pour le moment.', 'digirisk' ); ?></div>
			</div>
			<?php
		endif;
		?>
	</div>
</div>
