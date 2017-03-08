<?php
/**
 * Les titres des variables de l'évaluation complexe de digirisk
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

<?php foreach ( $list_evaluation_method_variable as $key => $value ) :
	$value_input = '';
	if ( ! empty( $risk->evaluation ) && ! empty( $risk->evaluation->quotation_detail ) ) :
		foreach ( $risk->evaluation->quotation_detail as $detail ) :
			if ( ! empty( $detail['variable_id'] ) ) :
				if ( $detail['variable_id'] == $list_evaluation_method_variable[ $key ]->id ) :
					$value_input = $detail['value'];
				endif;
			endif;
		endforeach;
	endif;
	?>
	<th>
		<?php echo esc_html( $value->name ); ?>
		<input 	type="hidden"
						class="variable-<?php echo esc_attr( $list_evaluation_method_variable[ $key ]->id ); ?>"
						variable-id="<?php echo esc_attr( $list_evaluation_method_variable[ $key ]->id ); ?>"
						name="risk[variable][<?php echo esc_attr( $list_evaluation_method_variable[ $key ]->id ); ?>]"
						value="<?php echo esc_attr( $value_input ); ?>" />
	</th>
<?php endforeach; ?>
