<?php
/**
 * Etape du liste des intervenants
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2019 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

<div class="table-row edit">
   <div class="table-cell update-mail-auto">
	   <div class="wpeo-form">
		   <div class="form-element">
			   <label class="form-field-container">
				   <input type="text" name="name" class="form-field" value="<?php echo esc_attr( $user[ 'name' ] ); ?>">
			   </label>
		   </div>
	   </div>
   </div>
   <div class="table-cell update-mail-auto">
	   <div class="wpeo-form">
		   <div class="form-element">
			   <label class="form-field-container">
				   <input type="text" name="lastname" class="form-field" value="<?php echo esc_attr( $user[ 'lastname' ] ); ?>">
			   </label>
		   </div>
	   </div>
   </div>
   <div class="table-cell">
	   <div class="wpeo-form">
		   <div class="form-element">
			   <label class="form-field-container">
				   <input type="text" name="mail" class="form-field" value="<?php echo esc_attr( $user[ 'mail' ] ); ?>">
			   </label>
		   </div>
	   </div>
   </div>
   <div class="table-cell">
	  <div class="wpeo-form phone-bloc digi-phone-user">
		  <div class="form-element">
			  <label class="form-field-container">
				  <input type="text" name="phone" class="form-field" value="<?php echo $user['phone']; ?>">
			  </label>
		  </div>
	  </div>
   </div>

   <div class="table-cell table-50 table-end">
	   <div class="wpeo-button button-green save button-square-50 action-input"
		   data-key="<?php echo esc_attr( $key ); ?>"
		   data-id="<?php echo esc_attr( $id ); ?>"
		   data-parent="table-row"
		   data-action="add_intervenant_to_prevention"
		   data-nonce="<?php echo esc_attr( wp_create_nonce( 'add_intervenant_to_prevention' ) ); ?>">
		   <i class="fas fa-save"></i>
	   </div>
   </div>
</div>
