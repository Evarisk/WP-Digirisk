<?php
/**
* L'affichage légal, inclus tous les templates nécessaires
*
* @author Jimmy Latour <jimmy.latour@gmail.com>
* @version 0.1
* @copyright 2015-2016 Eoxia
* @package society
* @subpackage templates
*/

if ( !defined( 'ABSPATH' ) ) exit;


?>
<form action="<?php echo admin_url( 'admin-ajax.php' ); ?>" class="form-legal-display" method="post">
  <input type="hidden" name="action" value="save_legal_display" />
  <input type="hidden" name="parent_id" value="<?php echo $element->id; ?>" />
  <?php  wp_nonce_field( 'save_legal_display' ); ?>

  <div class="gridwrapper2">
    <?php require( LEGAL_DISPLAY_TEMPLATES_MAIN_DIR . 'backend/detective-work.php' ); ?>
    <?php require( LEGAL_DISPLAY_TEMPLATES_MAIN_DIR . 'backend/occupational-health-service.php' ); ?>
  </div>

  <div class="gridwrapper2">
    <?php require( LEGAL_DISPLAY_TEMPLATES_MAIN_DIR . 'backend/emergency-service.php' ); ?>
    <?php require( LEGAL_DISPLAY_TEMPLATES_MAIN_DIR . 'backend/safety-rules.php' ); ?>
  </div>

  <div class="clear">
    <?php require( LEGAL_DISPLAY_TEMPLATES_MAIN_DIR . 'backend/working-hours.php' ); ?>
  </div>

  <div class="gridwrapper2">
	  <?php require( LEGAL_DISPLAY_TEMPLATES_MAIN_DIR . 'backend/derogations-schedules.php' ); ?>
	  <?php require( LEGAL_DISPLAY_TEMPLATES_MAIN_DIR . 'backend/collective-agreement.php' ); ?>
	</div>

  <div class="gridwrapper2">
	  <?php require( LEGAL_DISPLAY_TEMPLATES_MAIN_DIR . 'backend/rule.php' ); ?>
	  <?php require( LEGAL_DISPLAY_TEMPLATES_MAIN_DIR . 'backend/DUER.php' ); ?>
	</div>

  <button class="generate-legal-display wp-digi-bton-fifth dashicons-before dashicons-share-alt2"><?php _e( 'Generate legal display', 'digirisk' ); ?></button>
</form>
