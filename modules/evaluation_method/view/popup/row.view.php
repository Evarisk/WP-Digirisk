<?php
/**
 * La ligne des valeurs des variables de l'évaluation complexe de digirisk
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 6.0.0
 * @version 6.4.4
 * @copyright 2015-2017 Evarisk
 * @package DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<tr>
	<td class="padding"><?php echo esc_html( $current_var_index ); ?></td>

	<?php
	for ( $x = 0; $x < $number_variables; $x++ ) :
		$active = '';

		if ( ! empty( $risk->evaluation ) && ! empty( $risk->evaluation->quotation_detail ) ) :
			foreach ( $risk->evaluation->quotation_detail as $detail ) :
				if ( ! empty( $detail['variable_id'] ) && $detail['variable_id'] == $list_evaluation_method_variable[ $x ]->id && $detail['value'] == $list_evaluation_method_variable[ $x ]->survey['request'][ $current_var_index ]['seuil'] ) :
					$active = 'active';
				endif;
			endforeach;
		endif;
		?>

		<td data-slug="<?php echo esc_attr( sanitize_title( $list_evaluation_method_variable[ $x ]->survey['request'][ $current_var_index ]['question'] ) ); ?>" class="<?php echo esc_attr( $active ); ?>" data-variable-id="<?php echo esc_attr( $list_evaluation_method_variable[ $x ]->id ); ?>"
				data-seuil-id="<?php echo esc_attr( $list_evaluation_method_variable[ $x ]->survey['request'][ $current_var_index ]['seuil'] ); ?>">
				<?php echo esc_html( ! empty( $list_evaluation_method_variable[ $x ]->survey['request'][ $current_var_index ] ) ? $list_evaluation_method_variable[ $x ]->survey['request'][ $current_var_index ]['question'] : '' ); ?>
			</td>
	<?php endfor; ?>

</tr>
