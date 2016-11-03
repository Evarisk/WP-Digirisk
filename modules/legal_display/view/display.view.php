<?php namespace digi;
/**
* L'affichage légal, inclus tous les templates nécessaires
*
* @author Jimmy Latour <jimmy@evarisk.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package society
* @subpackage templates
*/

if ( !defined( 'ABSPATH' ) ) exit;


?>
<form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" class="form-legal-display" method="post">
  <input type="hidden" name="action" value="save_legal_display" />
  <input type="hidden" name="parent_id" value="<?php echo $element_id; ?>" />
  <?php  wp_nonce_field( 'save_legal_display' ); ?>

  <div class="gridwrapper2">
		<?php
			view_util::exec( 'legal_display', 'detective-work', array( 'legal_display' => $legal_display ) );
			view_util::exec( 'legal_display', 'occupational-health-service', array( 'legal_display' => $legal_display ) );
		?>
  </div>

  <div class="gridwrapper2">
		<?php
			view_util::exec( 'legal_display', 'emergency-service', array( 'legal_display' => $legal_display ) );
			view_util::exec( 'legal_display', 'safety-rules', array( 'legal_display' => $legal_display ) );
		?>
  </div>

  <div class="clear">
		<?php
			view_util::exec( 'legal_display', 'working-hours', array( 'legal_display' => $legal_display ) );
		?>
  </div>

  <div class="gridwrapper2">
		<?php
			view_util::exec( 'legal_display', 'derogations-schedules', array( 'legal_display' => $legal_display ) );
			view_util::exec( 'legal_display', 'collective-agreement', array( 'legal_display' => $legal_display ) );
		?>
	</div>

  <div class="gridwrapper2">
		<?php
			view_util::exec( 'legal_display', 'rule', array( 'legal_display' => $legal_display ) );
			view_util::exec( 'legal_display', 'DUER', array( 'legal_display' => $legal_display ) );
		?>
	</div>

  <button class="generate-legal-display wp-digi-bton-fifth submit-form dashicons-before dashicons-share-alt2"><?php _e( 'Generate legal display', 'digirisk' ); ?></button>
</form>
