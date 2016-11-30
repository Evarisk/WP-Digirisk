<?php namespace digi;
/**
* Les titres des variables de l'évaluation complexe de digirisk
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package evaluation_method
* @subpackage view
*/

if ( !defined( 'ABSPATH' ) ) exit; ?>

<ul class="header">
  <li></li>
  <?php foreach( $list_evaluation_method_variable as $key => $value ): ?>
    <li>
      <?php
        echo $list_evaluation_method_variable[$key]->name;
        $value = '';
        if ( !empty( $risk->evaluation ) && !empty( $risk->evaluation->quotation_detail ) ):
          foreach( $risk->evaluation->quotation_detail as $detail ) {
						if ( !empty( $detail['variable_id'] ) ):
	            if ( $detail['variable_id'] == $list_evaluation_method_variable[$key]->id ):
	              $value = $detail['value'];
							endif;
						endif;
          }
        endif;
      ?>
      <input type="hidden" class="variable-<?php echo $list_evaluation_method_variable[$key]->id; ?>" variable-id="<?php echo $list_evaluation_method_variable[$key]->id; ?>" name="risk[variable][<?php echo $list_evaluation_method_variable[$key]->id; ?>]" value="<?php echo !empty( $value ) ? $value : ''; ?>" />
    </li>
   <?php endforeach; ?>
</ul>
