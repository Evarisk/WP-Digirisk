<?php namespace digi;

if ( !defined( 'ABSPATH' ) ) exit;

?>
<form method="post" class="wp-digi-form" id="wpdigi-save-element-form" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" >
	<input type="hidden" name="action" value="wpdigi_generate_duer<?php echo ( !empty( $element ) && !empty( $element->type ) ? '_' . $element->type : '' ); ?>" />
	<?php wp_nonce_field( 'digi_ajax_generate_element_duer' ); ?>
	<input type="hidden" name="element_id" value="<?php echo $element->id; ?>" />
	<input type="hidden" name="element_type" value="<?php echo $element->type; ?>" />

	<div class="gridwrapper4">
		<div class="form-element"><label><?php _e( 'Document name', 'digirisk' ); ?><input type="text" value="<?php echo current_time( 'Ymd', 0 ) . '_document_unique_' . $element->unique_identifier . '_' . str_replace( ' ', '_', trim( strtolower( remove_accents( $element->title ) ) ) ); ?>" name="nomDuDocument" /></label></div>
		<div class="form-element"><label><?php _e( 'Start audit date', 'digirisk' ); ?><input type="text" class="wpdigi_date" value="<?php echo mysql2date( 'd/m/Y', current_time( 'mysql', 0 ), true ); ?>" name="dateDebutAudit" /></label></div>
		<div class="form-element"><label><?php _e( 'End audit date', 'digirisk' ); ?><input type="text" class="wpdigi_date" value="<?php echo mysql2date( 'd/m/Y', current_time( 'mysql', 0 ), true ); ?>" name="dateFinAudit" /></label></div>
		<div class="form-element"><label><?php _e( 'Transmitter', 'digirisk' ); ?><input type="text" value="<?php echo $transmitter_infos; ?>" name="emetteurDUER" /></label></div>
		<div class="form-element"><label><?php _e( 'Company name', 'digirisk' ); ?><input type="text" value="<?php echo $element->title; ?>" name="nomEntreprise" /></label></div>
		<div class="form-element"><label><?php _e( 'Recipient', 'digirisk' ); ?><input type="text" value="" name="destinataireDUER" /></label></div>
		<div class="form-element"><label><?php _e( 'Phone', 'digirisk' ); ?><input type="text" value="" name="telephone" /></label></div>
		<div class="form-element"><label><?php _e( 'Téléphone portable', 'digirisk' ); ?><input type="text" value="" name="portable" /></label></div>
	</div>
	<div class="gridwrapper2">
		<div class="form-element"><label><?php _e( 'Methodology', 'digirisk' ); ?><textarea name="methodologie" ><?php echo $document_unique->document_meta['methodologie']; ?></textarea></label></div>
		<div class="form-element"><label><?php _e( 'Sources', 'digirisk' ); ?><textarea name="sources" ><?php echo $document_unique->document_meta['sources']; ?></textarea></label></div>
		<div class="form-element"><label><?php _e( 'Important note', 'digirisk' ); ?><textarea name="remarqueImportante" ><?php echo $document_unique->document_meta['remarqueImportante']; ?></textarea></label></div>
		<div class="form-element"><label><?php _e( 'Location', 'digirisk' ); ?><textarea name="dispoDesPlans" ><?php echo $document_unique->document_meta['dispoDesPlans']; ?></textarea></label></div>
	</div>

	<button class="wp-digi-sheet-generation-button wp-digi-bton-fifth dashicons-before dashicons-share-alt2 wp-digi-duer-generation-button " ><?php _e( 'Generate DUER', 'digirisk' ); ?></button>
</form>
