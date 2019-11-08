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

	<table class="table closed-permis-feu">
		<thead>
			<tr>
				<td class="w50 padding"><?php esc_html_e( 'Ref.', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Titre', 'digirisk' ); ?></td>
				<td class="w100 padding"><?php esc_html_e( 'Début intervention', 'digirisk' ); ?></td>
				<td class="w100 padding"><?php esc_html_e( 'Fin intervention', 'digirisk' ); ?></td>
				<!-- <td class="padding"><?php esc_html_e( 'Formateur', 'digirisk' ); ?></td> -->
				<td class="w50 padding"><?php esc_html_e( 'Maitre d\'oeuvre', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Intervenant (Exterieur)', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'P de prévention', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Intervenant(s)', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Intervention(s)', 'digirisk' ); ?></td>
				<td class="w50"></td>
			</tr>
		</thead>
		<?php

		if ( ! empty( $list_permis_feu ) ) :
			foreach ( $list_permis_feu as $permis_feu ) :
				\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'dashboard/list-item', array(
					'permis_feu' => Permis_Feu_Class::g()->add_information_to_permis_feu( $permis_feu ),
				) );
			endforeach;
		else :
			?>
			<tr>
				<td colspan="9" style="text-align: center;"><?php esc_html_e( 'Aucun permis de feu réalisé pour le moment.', 'digirisk' ); ?></td>
			</tr>
			<?php
		endif;
		?>
	</table>
</div>
