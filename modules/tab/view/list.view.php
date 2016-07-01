<?php
/**
* Loop the list_tab for display it.
* Each tab have an attribute data-action for javascript request.
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package establishment
* @subpackage view
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="wp-digi-global-sheet-tab">
	<?php
	if ( !empty( $list_tab ) ):
		foreach ( $list_tab as $key => $tab_array ):
			if ( $key == $type ):
				if ( !empty( $tab_array ) ):
				  foreach ( $tab_array as $sub_key => $element ):
						$class = "";
						if ( "digi-" . $sub_key == $display ) {
							$class = "active";
						}
						?><li class="<?php echo !empty( $element['class'] ) ? $element['class'] : ''; ?> <?php echo $class; ?> wp-digi-list-item" data-action="digi-<?php echo $sub_key; ?>"><?php echo $element['text']; ?></li><?php
					endforeach;
				endif;
			else:
				if ( $key == 'all' ):
					if ( !empty( $tab_array ) ):
					  foreach ( $tab_array as $sub_key => $element ):
							if ( !empty( $element['text'] ) ):
								$class = "";
								if ( "digi-" . $sub_key == $display ) {
									$class = "active";
								}
								?><li class="<?php echo !empty( $element['class'] ) ? $element['class'] : ''; ?> <?php echo $class; ?> wp-digi-list-item" data-action="digi-<?php echo $sub_key; ?>"><?php echo $element['text']; ?></li><?php
							endif;
					  endforeach;
					endif;
				endif;
			endif;
		endforeach;
	endif; ?>
</ul>
