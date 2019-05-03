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
		if ( null !== $risk->data['id'] && -1 !== $risk->data['current_equivalence'] ) :
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

	<ul class="dropdown-content wpeo-gridlayout grid-5 grid-gap-0 dropdown-<?php echo esc_attr( $variables[0]->data['display_type'] ); ?>">
		<?php
		if ( ! empty( $variables[0]->data['survey']['request'] ) ) :
			foreach ( $variables[0]->data['survey']['request'] as $request ) :
				?>
				<li data-id="<?php echo esc_attr( $risk->data['id'] ); ?>"
						data-evaluation-id="<?php echo esc_attr( $method_evaluation_simplified->data['id'] ); ?>"
						data-variable-id="<?php echo esc_attr( $variables[0]->data['id'] ); ?>"
						data-seuil="<?php echo esc_attr( $request['seuil'] ); ?>"
						data-scale="<?php echo esc_attr( $request['seuil'] ); ?>"
						class="dropdown-item cotation"><?php echo esc_html( $method_evaluation_simplified->data['matrix'][ $request['seuil'] ] ); ?></li>
				<?php
			endforeach;
		endif;

		if ( null === $risk->data['id'] || $can_edit_type_cotation || $preset ) :
			echo wp_kses( apply_filters( 'digi_evaluation_method_dropdown_end', $risk->data['id'] ), array(
				'li'  => array(
					'class'          => array(),
					'aria-label'     => array(),
					'data-action'    => array(),
					'data-class'     => array(),
					'data-title'     => array(),
					'data-nonce'     => array(),
					'data-id'        => array(),
					'data-risk-id'   => array(),
					'wpeo-before-cb' => array(),
				),
				'svg' => array(),
				'i'   => array(
					'class' => array(),
				),
			) );
		endif;
		?>
	</ul>
</div>
