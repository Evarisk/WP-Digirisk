<?php
/**
 * Les titres des variables de l'évaluation complexe de digirisk
 *
 * @author Jimmy Latour <jimmy@evarisk.com>
 * @since 0.1
 * @version 6.2.3.0
 * @copyright 2015-2017 Evarisk
 * @package evaluation_method
 * @subpackage view
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php foreach ( $list_evaluation_method_variable as $key => $value ) :
	$value_input = '';
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
