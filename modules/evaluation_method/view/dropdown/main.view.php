<?php
/**
 * Affiches le toggle pour sélectionner une cotation avec la méthode d'évaluation simplifiée.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<input type="hidden" name="evaluation_method_id" value="<?php echo esc_attr( $method_evaluation_simplified->data['id'] ); ?>" />

<?php
if ( ! empty( $variables ) ) :
	foreach ( $variables as $variable ) :
		?>
		<input type="hidden" name="evaluation_variables[<?php echo esc_attr( $variable->data['id'] ); ?>]" value="<?php echo esc_attr( ! empty( $risk->data['evaluation']->data['variables'][ $variable->data['id'] ] ) ? $risk->data['evaluation']->data['variables'][ $variable->data['id'] ] : -1 ); ?>" />
		<?php
	endforeach;
endif;
?>
<div class="wpeo-dropdown dropdown-grid dropdown-padding-0 cotation-container">
	<span class="dropdown-toggle cotation level<?php echo esc_attr( $risk->data['evaluation']->data['scale'] ); ?>">
		<?php
		if ( 0 !== $risk->data['id'] ) :
			?>
			<span><?php echo esc_html( $risk->data['current_equivalence'] ); ?></span>
			<?php
		else :
			?>
			<span><i class="fas fa-chart-line"></i></span>
			<?php
		endif;
		?>
	</span>

	<ul class="dropdown-content dropdown-<?php echo esc_attr( $variables[0]->data['display_type'] ); ?>">
		<?php
		if ( ! empty( $variables[0]->data['survey']['request'] ) ) :
			foreach ( $variables[0]->data['survey']['request'] as $request ) :
				?>
				<li data-evaluation-id="<?php echo esc_attr( $variables[0]->data['id'] ); ?>" data-level="<?php echo esc_attr( $request['seuil'] ); ?>" class="dropdown-item cotation level<?php echo esc_attr( $request['seuil'] ); ?>"><?php echo esc_html( $method_evaluation_simplified->data['matrix'][ $request['seuil'] ] ); ?></li>
				<?php
			endforeach;
		endif;

		echo apply_filters( 'digi_evaluation_method_dropdown_end', '' );
		?>
	</ul>
</div>
