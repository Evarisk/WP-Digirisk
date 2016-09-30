<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit; ?>

<li>
	<label for="accronym-<?php echo $key; ?>"><?php echo $key; ?>
		<span>(<?php echo $element['description']; ?>)</span>
		<input type="text" id="accronym-<?php echo $key; ?>" name="list_accronym[<?php echo $key; ?>][to]" value="<?php echo $element['to']; ?>" />
	</label>
	<input type="hidden" name="list_accronym[<?php echo $key; ?>][description]" value="<?php echo $element['description']; ?>" />
</li>
