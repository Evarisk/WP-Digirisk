<?php
/**
* Affiches le champ de recherche
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package search
* @subpackage view
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<label class="wp-list-search">
	<?php if ( !empty( $icon ) ): ?><i class="<?php echo $icon; ?>"></i><?php endif; ?>
	<input type="text"
		placeholder="<?php echo $text; ?>"
		data-target="<?php echo $target; ?>"
		data-type="<?php echo $type; ?>"
		data-field="<?php echo $field; ?>"
		data-class="<?php echo $class; ?>"
		data-next-action="<?php echo $next_action; ?>"
		data-id="<?php echo $element_id; ?>"
		autocomplete="off">
</label>

<?php
if ( !empty( $field ) ):
	?>
	<input type="hidden" name="<?php echo $field; ?>" value="0" />
	<?php
endif;
?>
