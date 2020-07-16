<?php
/**
 * Evaluation d'une causerie: étape 2, permet d'afficher les images associées à la causerie dans un format "slider".
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
}
?>

<div class="wpeo-table table-flex intervention">
	<div class="table-row table-header">
		<div class="table-cell table-100"><?php esc_html_e( 'IdRPP', 'digirisk' ); ?></div> <!--  class="w50 " -->
		<div class="table-cell table-150"><?php esc_html_e( 'Unité de travail', 'digirisk' ); ?></div> <!--  class="w50 " -->
		<div class="table-cell"><?php esc_html_e( 'Description des actions réalisées', 'digirisk' ); ?></div>
		<div class="table-cell table-50" ><?php esc_html_e( 'Risque INRS', 'digirisk' ); ?></div>
		<div class="table-cell table-150"><?php esc_html_e( 'Matériels utilisés', 'digirisk' ); ?></div> <!--  class="w50" -->
		<div class="table-cell table-150 table-end"></div>
	</div>
	<?php
	if ( ! empty( $interventions ) ) :
		foreach ( array_reverse( $interventions ) as $intervention ) :
			\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/step-2-table-intervention-foreach-item', array(
				'intervention' => $intervention
			) );
		endforeach;
	endif;
	?>
	<?php
	\eoxia\View_Util::exec( 'digirisk', 'permis_feu', 'start/step-2-table-intervention-edit', array(
		'permis_feu' => $permis_feu,
		'new_line'   => true
	) );
	?>
</div>
