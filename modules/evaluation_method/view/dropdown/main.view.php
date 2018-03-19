<?php
/**
 * Affiches le toggle pour sélectionner une cotation avec la méthode d'évaluation simplifiée.
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.2.1
 * @version 6.5.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<input type="hidden" name="evaluation_method_id" value="<?php echo esc_attr( $method_evaluation_simplified->id ); ?>" />
<input type="hidden" name="evaluation_variables[<?php echo esc_attr( $variable_evaluation_simplified->id ); ?>]" value="-1" />
<div class="wpeo-dropdown dropdown-grid dropdown-padding-0 cotation-container">
	<span class="dropdown-toggle cotation level1">
		<span><i class="fas fa-chart-line"></i></span>
	</span>

	<ul class="dropdown-content dropdown-<?php echo esc_attr( $variable_evaluation_simplified->display_type ); ?>">
		<?php
		if ( ! empty( $variable_evaluation_simplified->survey['request'] ) ) :
			foreach ( $variable_evaluation_simplified->survey['request'] as $request ) :
				?>
				<li data-evaluation-id="<?php echo esc_attr( $variable_evaluation_simplified->id ); ?>" data-level="<?php echo esc_attr( $request['seuil'] ); ?>" class="dropdown-item cotation level<?php echo esc_attr( $request['seuil'] ); ?>"><?php echo esc_html( $method_evaluation_simplified->matrix[ $request['seuil'] ] ); ?></li>
				<?php
			endforeach;
		endif;

		echo apply_filters( 'digi_evaluation_method_dropdown_end', '' );
		?>
	</ul>
</div>
