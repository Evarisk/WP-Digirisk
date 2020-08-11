<?php
/**
 * Affichage principale pour définir les préfix des odt Causeries / Plan de prévention / Permis de feu
 *
 * @author Evarisk <dev@evarisk.com>
 * @since 7.3.5
 * @copyright 2019 Evarisk
 */


 namespace digi;

 if ( ! defined( 'ABSPATH' ) ) {
 	exit;
 } ?>

<div class="table-row">
	<?php   if ( ! isset( $element['element'] ) ) : ?>
		<div class="table-cell">
			<span for="data-<?php echo $key; ?>"><?php echo esc_attr( $element['description'] ); ?></span>
		</div>
		<div class="table-cell table-150">
			<input type="text" id="data-<?php echo $key; ?>" name="list_default_values[<?php echo $key; ?>][to]" value="<?php echo $element['to']; ?>" />
			<input type="hidden" name="list_default_values[<?php echo $key; ?>][description]" value="<?php echo $element['description']; ?>" />
		</div>
	<?php else : ?>
		<div class="table-cell">
			<span for="data-<?php echo $key; ?>"><?php echo esc_attr( $element['description'] ); ?></span>
		</div>
		<div class="table-cell table-150">
			<input type="text" id="data-<?php echo $key; ?>" name="list_default_values[<?php echo $element['element']; ?>][to]" value="<?php echo $element['to']; ?>" />
			<input type="hidden" name="list_default_values[<?php echo $key; ?>][description]" value="<?php echo $element['description']; ?>" />
		</div>
	<?php endif; ?>
</div>
