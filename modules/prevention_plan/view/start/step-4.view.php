<?php
/**
 * Affiches la liste des causeries
 *
 * @author    Evarisk <dev@evarisk.com>
 * @since     6.6.0
 * @version   6.6.0
 * @copyright 2018 Evarisk.
 * @package   DigiRisk
 */

namespace digi;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $eo_search; ?>


 <div class="information-intervenant-exterieur wpeo-form" style="background-color: #fff; padding: 1em;">

	 <input type="hidden" name="user-type" value="intervenant_exterieur">

	 <h2>
		 <?php esc_html_e( 'Responsable de la société intervenante', 'digirisk' ); ?>
		 <span class="wpeo-tooltip-event"
		 aria-label="<?php esc_html_e( 'Responsable de la société intervenante', 'digirisk' ); ?>"
		 style="color: dodgerblue; cursor: pointer;">
			 <i class="fas fa-info-circle"></i>
		 </span>
	 </h2>

	 <section class="wpeo-gridlayout padding grid-3" style="margin-bottom: 10px;">
		 <input type='hidden' name="prevention_id" value="<?php echo esc_attr( $prevention->data['id'] ); ?>">
		 <div class="form-element update-mail-auto">
			 <span class="form-label"><?php esc_html_e( 'Nom', 'digirisk' ); ?></span>
			 <label class="form-field-container">
				 <span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
				 <input type="text" name="intervenant-lastname" class="form-field" value="<?php echo esc_attr( $prevention->data['intervenant_exterieur']['lastname'] ); ?>">
			 </label>
		 </div>

		 <div class="form-element update-mail-auto">
			 <span class="form-label"><?php esc_html_e( 'Prénom', 'digirisk' ); ?></span>
			 <label class="form-field-container">
				 <span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
				 <input type="text" name="intervenant-name" class="form-field" value="<?php echo esc_attr( $prevention->data['intervenant_exterieur']['firstname'] ); ?>">
			 </label>
		 </div>

		 <div class="form-element">
			 <span class="form-label"><?php esc_html_e( 'Email', 'digirisk' ); ?></span>
			 <label class="form-field-container">
				 <span class="form-field-icon-prev"><i class="fas fa-user"></i></span>
				 <input type="text" name="intervenant-email" class="form-field" value="<?php echo esc_attr( $prevention->data['intervenant_exterieur']['email'] ); ?>">
			 </label>
		 </div>

		 <div class="form-element element-phone">
			 <span class="form-label"><?php esc_html_e( 'Portable', 'digirisk' ); ?></span>
			 <label class="form-field-container">
				 <span class="form-field-icon-prev"><i class="fas fa-mobile-alt"></i></span>
				 <input type="text" class="form-field element-phone-input" name="intervenant-phone" value="<?php echo esc_attr( $prevention->data['intervenant_exterieur']['phone'] ); ?>">
			 </label>
		 </div>

		 <div>
			 <?php echo do_shortcode( '[digi_signature id="' . $prevention->data['id'] . '" title="Signature" key="intervenant_exterieur_signature_id"]' ); ?>
		 </div>
	 </section>

 </div>
