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
	<h2 style="font-size: 20px; font-weight: normal; margin-bottom: 10px;"><?php esc_html_e( 'Listes des permis de feu en cours', 'digirisk' ); ?> (<?php echo esc_attr( $nbr ); ?>)</h2>

	<table class="table closed-permis-feu">
		<thead>
			<tr>
				<td class="padding"><?php esc_html_e( 'Titre', 'digirisk' ); ?></td>
				<td class="w150 padding"><?php esc_html_e( 'Date début', 'digirisk' ); ?></td>
				<td class="w150 padding"><?php esc_html_e( 'Maitre oeuvre', 'digirisk' ); ?></td>
				<td class="w150 padding"><?php esc_html_e( 'Intervenant (Exterieur)', 'digirisk' ); ?></td>
				<td class="w150 padding"><?php esc_html_e( 'Intervenant(s)', 'digirisk' ); ?></td>
				<td class="w150 padding"><?php esc_html_e( 'Intervention(s)	', 'digirisk' ); ?></td>
				<td class="w100 padding"><?php esc_html_e( 'Progression', 'digirisk' ); ?></td>
				<td class="w50"></td>
			</tr>
		</thead>
		<?php
		if ( ! empty( $permis_feu ) ) :
			foreach ( $permis_feu as $permis_feu_single ) :
				\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'progress/table-item', array(
					'permis_feu' => Permis_Feu_Class::g()->add_information_to_permis_feu( $permis_feu_single ),
				) );
			endforeach;
		else :
			?>
			<tr>
				<td colspan="9" style="text-align: center;"><?php esc_html_e( 'Aucun plan de prévention réalisé pour le moment.', 'digirisk' ); ?></td>
			</tr>
			<?php
		endif;
		?>
	</table>
</div>
