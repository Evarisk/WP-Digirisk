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
	<i class="dashicons dashicons-search"></i>
	<input type="text"
		placeholder="<?php echo $text; ?>"
		data-target="<?php echo $target; ?>"
		data-type="<?php echo $type; ?>"
		data-next-action="<?php echo $next_action; ?>"
		data-id="<?php echo $element_id; ?>"
		autocomplete="off">
</label>
