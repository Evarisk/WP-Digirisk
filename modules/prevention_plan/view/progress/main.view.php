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
	<h2 style="font-size: 20px; font-weight: normal; margin-bottom: 10px;"><?php esc_html_e( 'Listes des plans de préventions brouillons', 'digirisk' ); ?> (<?php echo esc_attr( $nbr ); ?>)</h2>

	<div class="wpeo-table table-flex closed-prevention">
		<div class="table-row table-header">
			<div class="table-cell"><?php esc_html_e( 'Titre', 'digirisk' ); ?></div>
			<div class="table-cell table-150"><?php esc_html_e( 'Date début', 'digirisk' ); ?></div>
			<div class="table-cell table-150"><?php esc_html_e( 'Maitre oeuvre', 'digirisk' ); ?></div>
			<div class="table-cell table-150"><?php esc_html_e( 'Responsable de la société extérieure', 'digirisk' ); ?></div>
			<div class="table-cell table-150"><?php esc_html_e( 'Intervenant(s)', 'digirisk' ); ?></div>
			<div class="table-cell table-150"><?php esc_html_e( 'Intervention(s)	', 'digirisk' ); ?></div>
			<div class="table-cell table-100"><?php esc_html_e( 'Progression', 'digirisk' ); ?></div>
			<div class="table-cell table-50 table-end"></div>
		</div>
		<?php
		if ( ! empty( $preventions ) ) :
			foreach ( $preventions as $prevention ) :
				\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'progress/table-item', array(
					'prevention' => Prevention_Class::g()->add_information_to_prevention( $prevention ),
				) );
			endforeach;
		else :
			?>
			<div class="table-row">
				<div class="table-cell" style="text-align: center;"><?php esc_html_e( 'Aucun plan de prévention réalisé pour le moment.', 'digirisk' ); ?></div>
			</div>
			<?php
		endif;
		?>
	</div>
</div>
