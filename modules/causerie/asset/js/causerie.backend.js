/**
 * Initialise l'objet "causerie" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.6.0
 * @version 6.6.0
 */
window.eoxiaJS.digirisk.causerie = {};
window.eoxiaJS.digirisk.causerie.canvas;

window.eoxiaJS.digirisk.causerie.init = function() {
	window.eoxiaJS.digirisk.causerie.event();
	window.eoxiaJS.digirisk.causerie.refresh();
};

window.eoxiaJS.digirisk.causerie.refresh = function() {
	window.eoxiaJS.digirisk.causerie.canvas = document.querySelectorAll("canvas");
	for( var i = 0; i < window.eoxiaJS.digirisk.causerie.canvas.length; i++ ) {
		window.eoxiaJS.digirisk.causerie.canvas[i].signaturePad = new SignaturePad( window.eoxiaJS.digirisk.causerie.canvas[i], {
			penColor: "rgb(66, 133, 244)"
		} );
	}

	jQuery( '.causerie-wrap .owl-carousel' ).owlCarousel( {
		'items': 1
	} );
};

window.eoxiaJS.digirisk.causerie.event = function() {
	jQuery( document ).on ('change', '.search input, .digi-search', window.eoxiaJS.digirisk.causerie.updateModalTitle );
	jQuery( document ).on( 'click', '.modal-signature .button.blue', window.eoxiaJS.digirisk.causerie.saveSignatureURL );
	jQuery( document ).on( 'click', '.causerie-wrap a.disabled', function( event ) {
		event.preventDefault();
		return false;
	} );
};

window.eoxiaJS.digirisk.causerie.updateModalTitle = function( event, data ) {
	var title = '';
	if ( data && data.item ) {
		title = 'Signature de l\'utilisateur: ' + data.item.displayname;

		jQuery( this ).closest( 'tr' ).find( '.modal-signature .modal-title' ).text( title );
		jQuery( this ).closest( 'tr' ).find( '.wpeo-modal-event' ).removeClass( 'disabled' );
	}
};

window.eoxiaJS.digirisk.causerie.saveSignatureURL = function( event ) {
	event.preventDefault();

	jQuery( '.modal-signature' ).find( 'canvas' ).each( function() {
		if ( ! jQuery( this )[0].signaturePad.isEmpty() ) {
			jQuery( this ).closest( 'div' ).find( 'input:first' ).val( jQuery( this )[0].toDataURL() );
			jQuery( '.step-1 .action-input[data-action="next_step_causerie"]' ).removeClass( 'disabled' );
		}
	} );

};

window.eoxiaJS.digirisk.causerie.applySignature = function( element ) {
	if ( ! element.closest( '.wpeo-modal' ).find( 'canvas' )[0].signaturePad.isEmpty() ) {
		element.closest( '.wpeo-modal' ).find( 'input[name="signature_data"]' ).val( element.closest( '.wpeo-modal' ).find( 'canvas' )[0].toDataURL() );
	}

	return true;
};

/**
 * Le callback en cas de réussite à la requête Ajax "edit_causerie".
 * Remplaces le contenu du tableau par la vue renvoyée par la réponse Ajax.
 *
 * @since 6.6.0
 * @version 6.6.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 */
window.eoxiaJS.digirisk.causerie.editedCauserieSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( 'table.add-causerie' ).replaceWith( response.data.form_causerie_view );
	jQuery( '#digi-start-causerie' ).html( response.data.start_table_view );
};

/**
 * Le callback en cas de réussite à la requête Ajax "load_causerie".
 * Remplaces le contenu de la ligne du tableau "causerie" par le template renvoyé par la requête Ajax.
 * @since 6.6.0
 * @version 6.6.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 */
window.eoxiaJS.digirisk.causerie.loadedCauserieSuccess = function( element, response ) {
	jQuery( element ).closest( 'tr' ).replaceWith( response.data.view );
};

/**
 * Le callback en cas de réussite à la requête Ajax "delete_causerie".
 * Supprimes la ligne du tableau.
 *
 * @since 6.6.0
 * @version 6.6.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 */
window.eoxiaJS.digirisk.causerie.deletedCauserieSuccess = function( element, response ) {
	element.closest( 'tr' ).fadeOut();
};

/**
 * Le callback en cas de réussite à la requête Ajax "save_final_causerie_step_1".
 *
 * @since 6.6.0
 * @version 6.6.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 */
window.eoxiaJS.digirisk.causerie.nextStep = function( element, response ) {
	jQuery( '.ajax-content' ).html( response.data.view );

	var currentStep = response.data.current_step;
	var percent     = 0;

	if ( 2 === currentStep ) {
		percent = 50;
	} else if ( 3 === currentStep ) {
		percent = 100;
	}

	if ( jQuery( '.main-content' ).hasClass( 'step-1' ) ) {
		jQuery( '.main-content' ).removeClass( 'step-1' ).addClass( 'step-2' );
	} else if ( jQuery( '.main-content' ).hasClass( 'step-2' ) ) {
		jQuery( '.main-content' ).removeClass( 'step-2' ).addClass( 'step-3' );
	}

	jQuery( '.causerie-wrap .bar .loader' ).css( 'width',  percent + '%' );
	jQuery( '.causerie-wrap .bar .loader' ).attr( 'data-width', percent );
	jQuery( '.causerie-wrap .step-list .step[data-width="' + percent + '"]' ).addClass( 'active' );

	window.eoxiaJS.refresh();
};

window.eoxiaJS.digirisk.causerie.savedParticipant = function( element, response ) {
	jQuery( '.ajax-content' ).html( response.data.view );

	window.eoxiaJS.digirisk.causerie.checkParticipantsSignature();

	window.eoxiaJS.refresh();
};

window.eoxiaJS.digirisk.causerie.checkParticipantsSignature = function() {
	var allSignature = true

	if ( '.step-3 input[name="signature_data"]'.length ) {
		jQuery( '.step-3 input[name="signature_data"]' ).each( function() {
			if ( ! jQuery( this ).val() ) {
				allSignature = false;
				return false;
			}
		} );
	}

	if ( allSignature ) {
		jQuery( '.step-3 a.disabled' ).removeClass( 'disabled tooltip hover' );
	} else {
		jQuery( '.step-3 a.disabled' ).addClass( 'disabled tooltip hover' );
	}
};

window.eoxiaJS.digirisk.causerie.savedSignature = function( element, response ) {
	element.closest( 'tr' ).replaceWith( response.data.view );

	window.eoxiaJS.digirisk.causerie.checkParticipantsSignature();

	window.eoxiaJS.digirisk.causerie.refresh();
};

/**
 * Vérifie que l'utilisateur et que la signature soit bien présente dans le formulaire.
 *
 * @since 6.6.0
 * @version 6.6.0
 *
 * @param  {[type]} element [description]
 * @return {void}
 */
window.eoxiaJS.digirisk.causerie.checkAllData = function( element ) {
	jQuery( '.step-1 .former-tooltip' ).removeClass( 'active' );
	jQuery( '.step-1 .signature-tooltip' ).removeClass( 'active' );

	if ( ! jQuery( '.step-1 input[name="former_id"]' ).val() ) {
		jQuery( '.step-1 .former-tooltip' ).addClass( 'active' );

		return false;
	}

	if ( ! jQuery( '.step-1 input[name="signature_data"]' ).val() ) {
		jQuery( '.step-1 .signature-tooltip' ).addClass( 'active' );

		return false;
	}

	return true;
};

/**
 * Vérifie que l'utilisateur et que la signature soit bien présente dans le formulaire.
 *
 * @since 6.6.0
 * @version 6.6.0
 *
 * @param  {[type]} element [description]
 * @return {void}
 */
window.eoxiaJS.digirisk.causerie.checkUserID = function( element ) {
	element.closest( 'tr' ).find( '.user-tooltip' ).removeClass( 'active' );

	if ( ! element.closest( 'tr' ).find( 'input[name="participant_id"]' ).val() ) {
		element.closest( 'tr' ).find( '.user-tooltip' ).addClass( 'active' );

		return false;
	}

	return true;
};
