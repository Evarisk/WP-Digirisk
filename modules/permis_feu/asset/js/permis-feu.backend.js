/**
 * Initialise l'objet "permisFeu" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since   6.6.0
 */
window.eoxiaJS.digirisk.permisFeu = {};

/**
 * Gestion des signatures.
 *
 * @type {HTMLCanvasElement}
 */
window.eoxiaJS.digirisk.permisFeu.canvas;

/**
 * Initialise les évènements.
 *
 * @since   6.6.0
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.permisFeu.init = function() {
	window.eoxiaJS.digirisk.permisFeu.event();
	window.eoxiaJS.digirisk.permisFeu.refresh();
};

/**
 * Initialise le canvas, ainsi que owlCarousel.
 *
 * @since   6.6.0
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.permisFeu.refresh = function() {
	window.eoxiaJS.digirisk.permisFeucanvas = document.querySelectorAll("canvas");
	for( var i = 0; i < window.eoxiaJS.digirisk.permisFeucanvas.length; i++ ) {
		window.eoxiaJS.digirisk.permisFeucanvas[i].signaturePad = new SignaturePad( window.eoxiaJS.digirisk.permisFeucanvas[i], {
			penColor: "rgb(66, 133, 244)"
		} );
	}

	jQuery( '.permis-feu-wrap .owl-carousel' ).owlCarousel( {
		'nav': 1,
		'loop': 1,
		'items': 1,
		'dots' : false,
		'navText' : ['<span class="owl-prev"><i class="fa fa-angle-left fa-8x" aria-hidden="true"></i></span>','<span class="owl-next"><i class="fa fa-angle-right fa-8x" aria-hidden="true"></i></span>'],
	} );
}

/**
 * Initialise les évènements principaux des permisFeu.
 *
 * @since   6.6.0
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.permisFeu.event = function() {
	jQuery( document ).on( 'change', '.digi-permis-feu-parent .information-maitre-oeuvre .wpeo-autocomplete', window.eoxiaJS.digirisk.permisFeu.updateModalTitleMaitreOeuvre );

	jQuery( document ).on( 'click', '.digi-permis-feu-parent .select-prevention .autocomplete-result', window.eoxiaJS.digirisk.permisFeu.addPreventionToPermisDeFeu );

	jQuery( document ).on( 'click', '.digi-permis-feu-parent .action-permis-feu-prevention .delete-prevention-from-permis-feu', window.eoxiaJS.digirisk.permisFeu.deletePreventionFromPermisFeu );

	jQuery( document ).on( 'click', '.digi-permis-feu-parent .end-date-element .button-permis-feu-title', window.eoxiaJS.digirisk.permisFeu.updateEndDatePrevention );

};

window.eoxiaJS.digirisk.permisFeu.updateModalTitleMaitreOeuvre = function( event, data ){
	var element  = jQuery( this );

	if ( data && data.element ) {
		var request_data = {};
		request_data.action  = 'permis_feu_display_maitre_oeuvre';
		request_data.user_id = element.closest( '.element-maitre-oeuvre' ).find( 'input[name="user_id"]' ).val();
		request_data.permis_feu_id = element.closest( '.element-maitre-oeuvre' ).find( 'input[name="permis_feu_id"]' ).val();

		window.eoxiaJS.loader.display( jQuery( this ) );
		window.eoxiaJS.request.send( jQuery( this ), request_data, function( triggeredElement, response ) {
			if( response.data.view_name != "" && response.data.view_name != null ){
				triggeredElement.closest( '.information-maitre-oeuvre' ).find( '.content-maitre-oeuvre .maitre-phone-part' ).html( response.data.view_phone );
				triggeredElement.closest( '.information-maitre-oeuvre' ).find( '.content-maitre-oeuvre .maitre-name-part' ).html( response.data.view_name );
			}
			window.eoxiaJS.digirisk.permisFeu.checkIfPermisFeuCanBeFinishMaitreOeuvre( element );
		} );
	}
}

window.eoxiaJS.digirisk.permisFeu.checkIfPermisFeuCanBeFinishMaitreOeuvre = function( element ){
	var parent_element = element.closest( '.digi-permis-feu-parent' );

	var maitre_oeuvre_element = parent_element.find( '.information-maitre-oeuvre' );

	var error = false;
	error = window.eoxiaJS.digirisk.permisFeu.checkIfThisChampsIsValid( maitre_oeuvre_element, 'maitre-oeuvre-name', error );
	error = window.eoxiaJS.digirisk.permisFeu.checkIfThisChampsIsValid( maitre_oeuvre_element, 'maitre-oeuvre-lastname', error );
	error = window.eoxiaJS.digirisk.permisFeu.checkIfThisChampsIsValid( maitre_oeuvre_element, 'maitre-oeuvre-phone', error );
	error = window.eoxiaJS.digirisk.permisFeu.checkIfThisChampsIsValid( maitre_oeuvre_element, 'maitre-oeuvre-signature', error );

	if( ! error ){
		parent_element.find( '.permis-feu-start' ).removeClass( 'button-disable' );
	}else{
		parent_element.find( '.permis-feu-start' ).addClass( 'button-disable' );
	}
}

window.eoxiaJS.digirisk.permisFeu.checkIfThisChampsIsValid = function( parent_element, element, error = false ){
	if( error ){
		return true;
	}
	var content = parent_element.find( '[name="' + element + '"]').val();
	if( content == "" || content == "-1" || content == null ){
		return true;
	}else{
		return false;
	}
}

window.eoxiaJS.digirisk.permisFeu.displaySignatureLastPage = function( triggeredElement, response ){
	var class_parent = '.' + response.data.class_parent;
	var element_parent = triggeredElement.closest( '.digi-permis-feu-parent' );

	var element = jQuery( '.digi-permis-feu-parent' ).find( class_parent );
	console.log( element );
	var a = element.find( '.signature-info-element .signature' );
	console.log( response.data.view );
	a.html( response.data.view );

	if( response.data.class_parent == "information-maitre-oeuvre" ){
		window.eoxiaJS.digirisk.permisFeu.checkIfPermisFeuCanBeFinishMaitreOeuvre( element_parent );
	}else{
		window.eoxiaJS.digirisk.permisFeu.checkIfPPermisFeuCanBeFinishIntervenantExterieur( element_parent );
	}
}

window.eoxiaJS.digirisk.permisFeu.nextStep = function( element, response ) {
	if( response.data.url ){
		window.location.replace( response.data.url );
	}

	jQuery( '.ajax-content' ).html( response.data.view );

	var currentStep = response.data.current_step;
	var percent     = 0;

	if ( 2 === currentStep ) {
		percent = 37;
	} else if ( 3 === currentStep ) {
		percent = 62;
	}else if( 4 === currentStep ) {
		percent = 100;
	}else{
		percent = 0;
	}

	if ( jQuery( '.main-content' ).hasClass( 'step-1' ) ) {
		jQuery( '.main-content' ).removeClass( 'step-1' ).addClass( 'step-2' );
	} else if ( jQuery( '.main-content' ).hasClass( 'step-2' ) ) {
		jQuery( '.main-content' ).removeClass( 'step-2' ).addClass( 'step-3' );
	}else if ( jQuery( '.main-content' ).hasClass( 'step-3' ) ) {
		jQuery( '.main-content' ).removeClass( 'step-3' ).addClass( 'step-4' );
	}

	jQuery( '.permis-feu-wrap .bar .loader' ).css( 'width',  percent + '%' );
	jQuery( '.permis-feu-wrap .bar .loader' ).attr( 'data-width', percent );
	jQuery( '.permis-feu-wrap .step-list .step[data-width="' + percent + '"]' ).addClass( 'active' );

	window.eoxiaJS.refresh();
};


window.eoxiaJS.digirisk.permisFeu.addPreventionToPermisDeFeu = function( event, data ){
	var element  = jQuery( this );
	var parent_element  = jQuery( this ).closest( '.select-prevention' );

	var request_data = {};
	request_data.action  = parent_element.attr( 'data-action' );
	request_data._wpnonce  = parent_element.attr( 'data-nonce' );
	request_data.prevention_id = parent_element.find( 'input[name="prevention_id"]' ).val();
	request_data.permis_feu_id = parent_element.find( 'input[name="permis_feu_id"]' ).val();

	window.eoxiaJS.loader.display( parent_element );
	window.eoxiaJS.request.send( parent_element, request_data );
}

window.eoxiaJS.digirisk.permisFeu.addPreventionToPermisFeuSuccess = function( triggeredElement, response ){
	if( response.data.view != "" ){
		triggeredElement.closest( '.wpeo-gridlayout' ).html( response.data.view );
	}
}

window.eoxiaJS.digirisk.permisFeu.deletePreventionFromPermisFeu = function( event ){

	var request_data = {};
	request_data.action        = jQuery( this ).attr( 'data-action' );
	request_data._wpnonce      = jQuery( this ).attr( 'data-nonce' );
	request_data.id = jQuery( this ).attr( 'data-id' );

	if( confirm( jQuery( this ).attr( 'data-message' ) ) ){
		window.eoxiaJS.loader.display( jQuery( this ) );
		window.eoxiaJS.request.send( jQuery( this ), request_data );
	}
}

window.eoxiaJS.digirisk.permisFeu.deletePreventionFromPermisFeuSuccess = function( triggeredElement, response ){
	if( response.data.view != "" ){
		triggeredElement.closest( '.wpeo-gridlayout' ).html( response.data.view );
	}
}

window.eoxiaJS.digirisk.permisFeu.updateEndDatePrevention = function( event ){
	jQuery( this ).closest( '.end-date-element' ).find( '.wpeo-button' ).removeClass( 'button-blue' ).addClass( 'button-grey' );
	jQuery( this ).removeClass( 'button-grey' ).addClass( 'button-blue' );
	jQuery( this ).closest( '.end-date-element' ).find( 'input[name="date_end__is_define"]' ).val( jQuery( this ).attr( 'data-action' ) );

	var form_element = jQuery( this ).closest( '.end-date-element' ).find( '.form-element' );
	if( jQuery( this ).attr( 'data-action' ) == "undefined" ){
		form_element.addClass( 'form-element-disable' );
	}else{
		form_element.removeClass( 'form-element-disable' );
	}
}
