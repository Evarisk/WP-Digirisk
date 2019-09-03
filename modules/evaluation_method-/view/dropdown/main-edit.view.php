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

<input type="hidden" name="evaluation_method_id" value="<?php echo esc_attr( $evaluation_method_id ); ?>" />
<textarea style="display: none;" name="evaluation_variables"><?php echo ! empty( $risk->data['evaluation']->data ) ? wp_json_encode( $risk->data['evaluation']->data['variables'], JSON_FORCE_OBJECT ) : '{}'; ?></textarea>

<div class="wpeo-dropdown dropdown-grid dropdown-padding-0 cotation-container wpeo-tooltip-event"
	aria-label="<?php esc_attr_e( 'Veuillez remplir la cotation', 'digirisk' ); ?>"
	data-color="red"
	data-tooltip-persist="true">
	<span data-scale="<?php echo ! empty( $risk->data['evaluation'] ) ? esc_attr( $risk->data['evaluation']->data['scale'] ) : 0; ?>" class="dropdown-toggle cotation">
		<?php
		if ( 0 !== $risk->data['id'] && -1 !== $risk->data['current_equivalence'] ) :
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


</div>
