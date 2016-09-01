<?php if ( !defined( 'ABSPATH' ) ) exit;

$default_methodology = __( '

* Étape 1 : Récupération des informations
- Visite des locaux
- Récupération des données du personnel

* Étape 2 : Définition de la méthodologie et de document
- Validation des fiches d\'unité de travail standard
- Validation de l\'arborescence des unités

* Étape 3  : Réalisation de l\'étude de risques
- Sensibilisation des personnels aux risques et aux dangers
- Création des unités de travail avec le personnel et le ou les responsables
- Évaluations des risques par unités de travail avec le personnel

* Étape 4
- Traitement et rédaction du document unique', 'digirisk' );
//
// 	/**	Définition du texte par défaut pour la partie méthodologie du document / Define default texte	*/
// 	$default_methodology = __( '* Step 1 : Retrieving information
// - Visit all installation with HSC members
// - Identification of all machine tools
// - Delivery information survey
// - Data processing and incorporation of basic information ( Staff, Training, Groups, WorkShop, Previous accident, ... )', 'digirisk' );
//
// 	$default_methodology .= '
//
// ' . __( '* Step 2 : Approach definition
// - Meeting with CHSCT members for project presentation ( Definition for default risk sheet, validation of standard sheet, ... )', 'digirisk' );
//
// 	$default_methodology .= '
//
// ' . __( '* Step 3 : Validate and create DUER
// - Establishment of risks sheets defined with HSC
// - Validate risks sheets with HSC', 'digirisk' );
//
// 	$default_methodology .= '
//
// ' . __( '* Step 4 : Realization of the risk study
// - Awareness of the risks to operators
// - Creation of work units with workshop leaders and operators
// - Risk assessments per work unit with the workshop leaders and operators', 'digirisk' );
//
// 	$default_methodology .= '
//
// ' . __( '* Step 5
// - Processing and preparation of DUER', 'digirisk' );

	/**	Définition du texte par défaut pour la partie source du document / Define default text for sources part in document	*/
	$default_sources = __( 'Risk awareness is defined in the "ed840" edited by INRS.
In the current document you will find:
- Explanation for what a risk is, what a danger is and an explanatory diagram
- Explanation for the different evaluation method', 'digirisk' );


	/**	Définition des informations de l'émetteur du document unique / Define informations about DUER	*/
	$transmitter_infos = '';
	if ( !empty( $current_user ) && !empty( $current_user->firstname ) ) {
		$transmitter_infos .= $current_user->firstname;
	}
	if ( !empty( $current_user ) && !empty( $current_user->lastname ) ) {
		$transmitter_infos .= $current_user->lastname;
	}
	if ( empty( $transmitter_infos ) ) {
		$transmitter_infos = $current_user->display_name;
	}

?>
<form method="post" class="wp-digi-form" id="wpdigi-save-element-form" action="<?php echo admin_url( 'admin-ajax.php' ); ?>" >
	<input type="hidden" name="action" value="wpdigi_generate_duer<?php echo ( !empty( $element ) && !empty( $element->type ) ? '_' . $element->type : '' ); ?>" />
	<?php wp_nonce_field( 'digi_ajax_generate_element_duer' ); ?>
	<input type="hidden" name="element_id" value="<?php echo $element->id; ?>" />
	<input type="hidden" name="element_type" value="<?php echo $element->type; ?>" />

	<div class="gridwrapper4">
		<div class="form-element"><label><?php _e( 'Document name', 'digirisk' ); ?><input type="text" value="<?php echo current_time( 'Ymd', 0 ) . '_document_unique_' . $element->unique_identifier . '_' . str_replace( ' ', '_', trim( strtolower( remove_accents( $element->title ) ) ) ); ?>" name="wpdigi_duer[document_name]" /></label></div>
		<div class="form-element"><label><?php _e( 'Start audit date', 'digirisk' ); ?><input type="text" class="wpdigi_date" value="<?php echo mysql2date( 'd/m/Y', current_time( 'mysql', 0 ), true ); ?>" name="wpdigi_duer[audit_start_date]" /></label></div>
		<div class="form-element"><label><?php _e( 'End audit date', 'digirisk' ); ?><input type="text" class="wpdigi_date" value="<?php echo mysql2date( 'd/m/Y', current_time( 'mysql', 0 ), true ); ?>" name="wpdigi_duer[audit_end_date]" /></label></div>
		<div class="form-element"><label><?php _e( 'Transmitter', 'digirisk' ); ?><input type="text" value="<?php echo $transmitter_infos; ?>" name="wpdigi_duer[document_transmitter]" /></label></div>
		<div class="form-element"><label><?php _e( 'Company name', 'digirisk' ); ?><input type="text" value="<?php echo $element->title; ?>" name="wpdigi_duer[company_name]" /></label></div>
		<div class="form-element"><label><?php _e( 'Recipient', 'digirisk' ); ?><input type="text" value="" name="wpdigi_duer[document_recipient]" /></label></div>
		<div class="form-element"><label><?php _e( 'Phone', 'digirisk' ); ?><input type="text" value="" name="wpdigi_duer[document_recipient_phone]" /></label></div>
		<div class="form-element"><label><?php _e( 'Cellphone', 'digirisk' ); ?><input type="text" value="" name="wpdigi_duer[document_recipient_cellphone]" /></label></div>
	</div>
	<div class="gridwrapper2">
		<div class="form-element"><label><?php _e( 'Methodology', 'digirisk' ); ?><textarea name="wpdigi_duer[audit_methodology]" ><?php echo $default_methodology; ?></textarea></label></div>
		<div class="form-element"><label><?php _e( 'Sources', 'digirisk' ); ?><textarea name="wpdigi_duer[audit_sources]" ><?php echo $default_sources; ?></textarea></label></div>
		<div class="form-element"><label><?php _e( 'Important note', 'digirisk' ); ?><textarea name="wpdigi_duer[audit_important_note]" ></textarea></label></div>
		<div class="form-element"><label><?php _e( 'Location', 'digirisk' ); ?><textarea name="wpdigi_duer[audit_location]" ></textarea></label></div>
	</div>

	<button class="wp-digi-sheet-generation-button wp-digi-bton-fifth dashicons-before dashicons-share-alt2 wp-digi-duer-generation-button " ><?php _e( 'Generate DUER', 'digirisk' ); ?></button>
</form>
