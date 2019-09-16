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
	<h2 style="font-size: 20px; font-weight: normal; margin-bottom: 10px; float: left;">
		<?php esc_html_e( sprintf( 'Liste des plans de préventions réalisés (%1$d)', ! empty( $preventions ) ? count( $preventions ) : '0' ), 'digirisk' ); ?>
	</h2>
	<a href="<?php echo esc_attr( admin_url( 'admin.php?page=digirisk-setting&tab=digi-define-prefix' ) ); ?>"
		class="wpeo-tooltip-event" aria-label="<?php esc_html_e( 'Référence des plans de préventions', 'digirisk' ); ?>"
		style="float: right;">
		<div class="wpeo-button button-main">
			<span><i class="icon fa fa-cog"></i></span>
		</div>
	</a>

	<table class="table closed-prevention">
		<thead>
			<tr>
				<td class="w50 padding"><?php esc_html_e( 'Ref.', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Titre', 'digirisk' ); ?></td>
				<td class="w100 padding"><?php esc_html_e( 'Début intervention', 'digirisk' ); ?></td>
				<td class="w100 padding"><?php esc_html_e( 'Fin intervention', 'digirisk' ); ?></td>
				<!-- <td class="padding"><?php esc_html_e( 'Formateur', 'digirisk' ); ?></td> -->
				<td class="w50 padding"><?php esc_html_e( 'Maitre d\'oeuvre', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Intervenant (Exterieur)', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Intervenant(s)', 'digirisk' ); ?></td>
				<td class="padding"><?php esc_html_e( 'Intervention(s)', 'digirisk' ); ?></td>
				<td class="w50"></td>
			</tr>
		</thead>
		<?php

		if ( ! empty( $preventions ) ) :
			foreach ( $preventions as $prevention ) :
				\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'dashboard/list-item', array(
					'prevention' => Prevention_Class::g()->add_information_to_prevention( $prevention ),
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
