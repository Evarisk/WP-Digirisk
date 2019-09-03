<?php
/**
 * Les titres des variables de la méthode d'évaluation
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

<div class="table-cell">
	<span></span>
</div>

<?php
for ( $i = 0; $i < $evaluation_method->data['number_variables']; $i++ ) :
	?>
	<div class="table-cell">
		<span><?php echo esc_attr( $i ); ?></span>
	</div>
	<?php
endfor;
