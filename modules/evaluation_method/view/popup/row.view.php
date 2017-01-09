<?php
/**
 * La ligne des valeurs des variables de l'évaluation complexe de digirisk
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.4.0
 * @copyright 2015-2017 Evarisk
 * @package evaluation_method
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<tr>
	<td class="padding"><?php echo esc_html( $i ); ?></td>

	<?php $variables_number = count( $list_evaluation_method_variable ); ?>
	<?php for ( $x = 0; $x < $variables_number; $x++ ) :
		$active = '';

		if ( ! empty( $risk->evaluation ) && ! empty( $risk->evaluation->quotation_detail ) ) :
			foreach ( $risk->evaluation->quotation_detail as $detail ) :
				if ( ! empty( $detail['variable_id'] ) && $detail['variable_id'] === $list_evaluation_method_variable[ $x ]->id && $detail['value'] === $list_evaluation_method_variable[ $x ]->survey['request'][ $i ]['seuil'] ) :
					$active = 'active';
				endif;
			endforeach;
		endif; ?>

		<td class="<?php echo esc_attr( $active ); ?>" data-variable-id="<?php echo esc_attr( $list_evaluation_method_variable[ $x ]->id ); ?>"
				data-seuil-id="<?php echo esc_attr( $list_evaluation_method_variable[ $x ]->survey['request'][ $i ]['seuil'] ); ?>">
				<?php echo esc_html( ! empty( $list_evaluation_method_variable[ $x ]->survey['request'][ $i ] ) ? $list_evaluation_method_variable[ $x ]->survey['request'][ $i ]['question'] : '' ); ?>
			</td>
	<?php endfor; ?>

</tr>
