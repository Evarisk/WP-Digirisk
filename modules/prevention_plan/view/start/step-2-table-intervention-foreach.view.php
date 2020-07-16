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
		<div class="table-cell table-150"><?php esc_html_e( 'Lieu', 'digirisk' ); ?></div> <!--  class="w50 " -->
		<div class="table-cell"><?php esc_html_e( 'Description des actions', 'digirisk' ); ?></div>
		<div class="table-cell table-50 " ><?php esc_html_e( 'Risque INRS', 'digirisk' ); ?></div>
		<div class="table-cell table-200"><?php esc_html_e( 'Moyens de prévention', 'digirisk' ); ?></div> <!--  class="w50" -->
		<div class="table-cell table-150 table-end"></div> <!-- Actions -->
	</div>
	<?php
	if ( ! empty( $interventions ) ) :
		foreach ( array_reverse( $interventions ) as $intervention ) :
			\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-2-table-intervention-foreach-item', array(
				'intervention' => $intervention,
				'edit'         => $edit
			) );
		endforeach;
	endif;
	?>

	<?php
	if( $edit ):
		\eoxia\View_Util::exec( 'digirisk', 'prevention_plan', 'start/step-2-table-intervention-edit', array(
			'prevention' => $prevention,
			'new_line'   => true
		) );
	endif;
	?>
</div>

<?php
if ( ! $edit && empty( $interventions ) ) :
	?>
	<div class="" style="font-size:15px; color : red; margin-top : 4px">
		<?php esc_html_e( 'Aucunes interventions définies dans ce plan de prévention', 'digirisk' ); ?> <i class="far fa-frown"></i>
	</div>
	<?php
endif;
?>
