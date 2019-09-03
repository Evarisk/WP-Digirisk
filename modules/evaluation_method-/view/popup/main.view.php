<?php
/**
 * La popup qui contient les données de l'évaluation complexe de digirisk
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 6.0.0
 * @version 7.0.0
 * @copyright 2015-2018 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<input type="hidden" class="digi-method-evaluation-id" value="<?php echo esc_attr( ! empty( $evaluation_method->data['id'] ) ? $evaluation_method->data['id'] : 0 ); ?>" />
<textarea style="display: none" class="tmp_evaluation_variable"><?php echo ! empty( $risk->data['evaluation']->data ) ? wp_json_encode( $risk->data['evaluation']->data['variables'], JSON_FORCE_OBJECT ) : '{}'; ?></textarea>
<p><i class="fas fa-info-circle"></i> <?php esc_html_e( 'Cliquez sur les cases du tableau pour remplir votre évaluation', 'digirisk'); ?></p>

<div class="wpeo-table evaluation-method table-flex table-<?php echo esc_attr( $evaluation_method->data['number_variables'] + 1 ); ?>">
	<div class="table-row table-header">
		<?php
		\eoxia\View_Util::exec( 'digirisk', 'evaluation_method', 'popup/header', array(
			'evaluation_method' => $evaluation_method,
		) );
		?>

	</div>

	<?php
	if ( ! empty( $evaluation_method->data['variables'] ) ) :
		foreach ( $evaluation_method->data['variables'] as $key => $variable ) :
			$selected_seuil = isset( $risk->data['evaluation']->data['variables'][ $variable->data['id'] ] ) ? $risk->data['evaluation']->data['variables'][ $variable->data['id'] ] : -1;

			\eoxia\View_Util::exec( 'digirisk', 'evaluation_method', 'popup/row', array(
				'risk'           => $risk,
				'selected_seuil' => $selected_seuil,
				'variable'       => $variable,
				'evaluation_id'  => $evaluation_method->data['id'],
			) );
		endforeach;
	endif;
	?>
</div>
