/**
 * Initialise l'objet "preventionPlan" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since   6.6.0
 */
window.eoxiaJS.digirisk.preventionPlan = {};

/**
 * Gestion des signatures.
 *
 * @type {HTMLCanvasElement}
 */
window.eoxiaJS.digirisk.preventionPlan.canvas;

/**
 * Initialise les évènements.
 *
 * @since   6.6.0
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.preventionPlan.init = function() {
	window.eoxiaJS.digirisk.preventionPlan.event();
	// window.eoxiaJS.digirisk.preventionPlan.refresh();
};

/**
 * Initialise les évènements principaux des preventionPlans.
 *
 * @since   6.6.0
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.preventionPlan.event = function() {
	jQuery( document ).on( 'change', '.digi-prevention-plan-parent .information-maitre-oeuvre .wpeo-autocomplete', window.eoxiaJS.digirisk.preventionPlan.setMaitreOeuvre );
	jQuery( document ).on( 'saved-signature-success', '.digi-prevention-plan-parent.step-1 .button-signature', window.eoxiaJS.digirisk.preventionPlan.updatedMaitreOeuvreSignature );
	jQuery( document ).on( 'saved-signature-success', '.digi-prevention-plan-parent.step-4 .button-signature', window.eoxiaJS.digirisk.preventionPlan.updatedIntervenantExterieurSignature );

	// Recherche GP/UT
	jQuery( document ).on( 'click', '.digi-prevention-plan-parent .unite-de-travail-element .autocomplete-search-list .autocomplete-result',  window.eoxiaJS.digirisk.preventionPlan.displayButtonUniteDeTravail );

	jQuery( document ).on( 'click', '.digi-prevention-plan-parent .readonly .display-modal-unite',  window.eoxiaJS.digirisk.preventionPlan.displayModalUniteDeTravail );

	/*jQuery( document ).on( 'keyup', '.digi-prevention-plan-parent .information-element-society input',  window.eoxiaJS.digirisk.preventionPlan.displayButtonSaveInformation );*/

	jQuery( document ).on( 'keyup', '.digi-prevention-plan-parent .update-mail-auto input',  window.eoxiaJS.digirisk.preventionPlan.preShotEmailUser );

	jQuery( document ).on( 'click', '.digi-prevention-plan-parent .unite-de-travail-class .risque-element .dropdown-content .item',  window.eoxiaJS.digirisk.preventionPlan.selectRisqueInDropdown );

	jQuery( document ).on( 'keyup', '.digi-prevention-plan-parent .unite-de-travail-class [name="moyen-de-prevention"]',  window.eoxiaJS.digirisk.preventionPlan.checkIfInterventionCanBeAdd );

	jQuery( document ).on( 'keyup', '.digi-prevention-plan-parent .unite-de-travail-class [name="description-des-actions"]',  window.eoxiaJS.digirisk.preventionPlan.checkIfInterventionCanBeAdd );

	jQuery( document ).on( 'click', '.digi-prevention-plan-parent .unite-de-travail-class .button-add-row-intervention',  window.eoxiaJS.digirisk.preventionPlan.addInterventionLine );

	jQuery( document ).on( 'keyup', '.digi-prevention-plan-parent .information-maitre-oeuvre input[type="text"]', window.eoxiaJS.digirisk.preventionPlan.preventionPlanCanBeFinishMaitreOeuvre );

	jQuery( document ).on( 'keyup', '.digi-prevention-plan-parent .information-intervenant-exterieur input[type="text"]', window.eoxiaJS.digirisk.preventionPlan.PreventionPlanCanBeFinishIntervenantExterieur );

	jQuery( document ).on( 'click', '.wrap-prevention .closed-prevention .avatar-info-prevention .avatar', window.eoxiaJS.digirisk.preventionPlan.displayUserInfo );

	jQuery( document ).on( 'click', '.wrap-prevention .closed-prevention .action .delete-this-prevention-plan', window.eoxiaJS.digirisk.preventionPlan.deleteThisPreventionPlan );

	jQuery( document ).on( 'click', '.digi-prevention-plan-parent .end-date-element .action-button-end-date', window.eoxiaJS.digirisk.preventionPlan.updateEndDatePrevention );

	jQuery( document ).on( 'click', '.digi-prevention-plan-parent .title-information-option .action-button-title', window.eoxiaJS.digirisk.preventionPlan.updateTitleOption );
};

window.eoxiaJS.digirisk.preventionPlan.setMaitreOeuvre = function( event, data ) {
	var element  = jQuery( this );

	if ( data && data.element ) {
		var request_data = {};
		request_data.action        = 'prevention_display_maitre_oeuvre';
		request_data.user_id       = element.closest( '.information-maitre-oeuvre' ).find( 'input[name="user_id"]' ).val();
		request_data.prevention_id = element.closest( '.prevention-plan-wrap' ).find( 'input[name="prevention_id"]' ).val();

		window.eoxiaJS.loader.display( jQuery( this ) );

		window.eoxiaJS.request.send( jQuery( this ), request_data, function( triggeredElement, response ) {
			triggeredElement.closest( '.prevention-plan-wrap' ).replaceWith( response.data.view );
			window.eoxiaJS.digirisk.preventionPlan.checkIfPreventionPlanCanBeFinishMaitreOeuvre( jQuery( '.prevention-plan-wrap' ) );
		} );
	}
};

window.eoxiaJS.digirisk.preventionPlan.updatedMaitreOeuvreSignature = function( triggeredElement, response ) {
	var element = jQuery( this );
	window.eoxiaJS.digirisk.preventionPlan.checkIfPreventionPlanCanBeFinishMaitreOeuvre( jQuery( '.prevention-plan-wrap' ) );
};

window.eoxiaJS.digirisk.preventionPlan.updatedIntervenantExterieurSignature = function( triggeredElement, response ) {
	window.eoxiaJS.digirisk.preventionPlan.checkIfPreventionPlanCanBeFinishIntervenantExterieur( jQuery( '.prevention-plan-wrap' ) );
};

window.eoxiaJS.digirisk.preventionPlan.nextStep = function( element, response ) {
	if( response.data.url ) {
		window.location = response.data.url;
	} else {

		jQuery( '.prevention-plan-wrap' ).replaceWith( response.data.view );

		var currentStep = response.data.current_step;
		var percent     = 0;

		if ( 2 === currentStep ) {
			percent = 50;
		} else if ( 3 === currentStep ) {
			percent = 100;
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

		jQuery( '.prevention-wrap .bar .loader' ).css( 'width',  percent + '%' );
		jQuery( '.prevention-wrap .bar .loader' ).attr( 'data-width', percent );
		jQuery( '.prevention-wrap .step-list .step[data-width="' + percent + '"]' ).addClass( 'active' );
	}

	// window.eoxiaJS.refresh();
};

window.eoxiaJS.digirisk.preventionPlan.preventionLoadTabSuccess = function( element, response ){
	element.closest( '.main-content' ).html( response.data.view );
}

/**
 * Ajoutes la nouvelle ligne du participant dans le tableau.
 *
 * @since   6.6.0
 *
 * @param  {HTMLDivElement} element  Le bouton déclencahd l'action AJAX.
 * @param  {Object}         response Les données reçu dans le formulaire.
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.preventionPlan.savedParticipant = function( element, response ) {
	jQuery( '.ajax-content' ).html( response.data.view );

	window.eoxiaJS.digirisk.causerie.checkParticipantsSignature();

	// window.eoxiaJS.refresh();
};

window.eoxiaJS.digirisk.preventionPlan.displayButtonUniteDeTravail = function( event ){
	window.eoxiaJS.digirisk.preventionPlan.checkIfInterventionCanBeAdd( '', jQuery( this ) );
}

window.eoxiaJS.digirisk.preventionPlan.displayButtonUniteDeTravailSuccess = function( trigerredElement, response ){
	trigerredElement.closest( '.unite-de-travail-class' ).find( '.button-unite-de-travail' ).html( response.data.view );
	var error = window.eoxiaJS.digirisk.preventionPlan.checkIfInterventionCanBeAdd( '', trigerredElement );
	if( ! error ){
		var parent_element = trigerredElement.closest( '.unite-de-travail-class' );
		parent_element.find( '.button-add-row-intervention' ).removeClass( 'button-disable' ).addClass( 'button-blue' );
	}
}

window.eoxiaJS.digirisk.preventionPlan.displayModalUniteDeTravail = function( event ){
	jQuery( this ).closest( '.button-unite-de-travail' ).find( '.digirisk-modal-unite' ).addClass( 'modal-active' );
}

/*window.eoxiaJS.digirisk.preventionPlan.displayButtonSaveInformation = function( event ){
	jQuery( this ).closest( '.information-society' ).find( '.button-save-information-society' ).show( 'slow' );
}*/

window.eoxiaJS.digirisk.preventionPlan.saveUserToSociety = function( trigerredElement, response ){
	trigerredElement.closest( '.wpeo-table' ).replaceWith( response.data.view );
}

window.eoxiaJS.digirisk.preventionPlan.preShotEmailUser = function( event ){
	var parent_element = jQuery( this ).closest( '.table-row' );
	if (! parent_element.length) {
		parent_element = jQuery( this ).closest( '.wpeo-gridlayout' );
	}

	var name     = parent_element.find( 'input[name="name"]' ).length ? parent_element.find( 'input[name="name"]' ).val() : parent_element.find( 'input[name="intervenant-name"]' ).val();
	var lastname = parent_element.find( 'input[name="lastname"]' ).length ? parent_element.find( 'input[name="lastname"]' ).val() : parent_element.find( 'input[name="intervenant-lastname"]' ).val();
	var email = lastname.trim() + '.' + name.trim() + '@demo.com';

	if ( parent_element.find( '[name="mail"]' ).length ) {
		parent_element.find( '[name="mail"]' ).val( email );
	} else if ( parent_element.find( '[name="intervenant-email"]' ).length ) {
		parent_element.find( '[name="intervenant-email"]' ).val( email );

	}
}

window.eoxiaJS.digirisk.preventionPlan.selectRisqueInDropdown = function( event ){
	var parent_element = jQuery( this ).closest( '.form-element' );
	var info_element = parent_element.find( '.category-danger .dropdown-toggle' );
	info_element.css( 'padding', '0' );
	info_element.find( 'span' ).hide();
	info_element.find( '.button-icon' ).hide();

	parent_element.find( '[name="risk_category_id"]' ).val( jQuery( this ).attr( 'data-id' ) );
	var img_src = jQuery( this ).find( 'img' ).attr( 'src' );
	info_element.find( 'img' ).attr( 'src', img_src );
	info_element.find( 'img' ).removeClass( 'hidden' ).removeClass( 'wpeo-tooltip-event' ).addClass( 'wpeo-tooltip-event' );

	info_element.find( 'img' ).attr( 'aria-label', jQuery( this ).attr( 'aria-label' ) );
	var error = window.eoxiaJS.digirisk.preventionPlan.checkIfInterventionCanBeAdd( '', jQuery( this ) );
	if( ! error ){
		var parent_element = jQuery( this ).closest( '.unite-de-travail-class' );
		parent_element.find( '.button-add-row-intervention' ).removeClass( 'button-disable' ).addClass( 'button-blue' );
	}
}


window.eoxiaJS.digirisk.preventionPlan.checkIfInterventionCanBeAdd = function( event, element ){
	if ( ! element ) {
		element = "";
	}

	if( element == "" ){
		element = jQuery( this );
	}

	var parent_element = element.closest( '.unite-de-travail-class' );
	var error = false;

	error = window.eoxiaJS.digirisk.preventionPlan.checkIfThisChampsIsValid( parent_element, 'unitedetravail', error );
	error = window.eoxiaJS.digirisk.preventionPlan.checkIfThisChampsIsValid( parent_element, 'description-des-actions', error );
	error = window.eoxiaJS.digirisk.preventionPlan.checkIfThisChampsIsValid( parent_element, 'moyen-de-prevention', error );
	error = window.eoxiaJS.digirisk.preventionPlan.checkIfThisChampsIsValid( parent_element, 'risk_category_id', error );

	if( ! error ){
		parent_element.find( '.button-add-row-intervention' ).removeClass( 'button-disable' ).addClass( 'button-blue' );
	}else{
		parent_element.find( '.button-add-row-intervention' ).removeClass( 'button-blue' ).addClass( 'button-disable' );
	}


	return error;
}

window.eoxiaJS.digirisk.preventionPlan.checkIfThisChampsIsValid = function( parent_element, element, error ){
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

window.eoxiaJS.digirisk.preventionPlan.addInterventionLine = function( event ){
	var parent_element = jQuery( this ).closest( '.unite-de-travail-class' );
	var data = {};
	data.unite             = parent_element.find( '[name="unitedetravail"]').val();
	data.descriptionaction = parent_element.find( '[name="description-des-actions"]').val();
	data.prevention        = parent_element.find( '[name="moyen-de-prevention"]').val();
	data.riskid            = parent_element.find( '[name="risk_category_id"]').val();
	data.parentid          = jQuery( this ).attr( 'data-parentid' );
	data.id                = jQuery( this ).attr( 'data-id' );
	data.action            = jQuery( this ).attr( 'data-action' );
	data._wpnonce          = jQuery( this ).attr( 'data-nonce' );

	window.eoxiaJS.loader.display( parent_element );
	window.eoxiaJS.request.send( jQuery( this ), data );
}

window.eoxiaJS.digirisk.preventionPlan.addInterventionLineSuccess = function( triggeredElement, response ){
	triggeredElement.closest( '.intervention-content' ).html( response.data.table_view );
}

window.eoxiaJS.digirisk.preventionPlan.editInterventionLineSuccess = function( triggeredElement, response ){
	triggeredElement.closest( '.intervention-row' ).replaceWith( response.data.view );
}

window.eoxiaJS.digirisk.preventionPlan.addIntervenantToPrevention = function( triggeredElement, response ){
	triggeredElement.closest( '.wpeo-table' ).replaceWith( response.data.view );
}

window.eoxiaJS.digirisk.preventionPlan.editIntervenantPrevention = function( triggeredElement, response ){
	triggeredElement.closest( '.table-row' ).replaceWith( response.data.view );
}

window.eoxiaJS.digirisk.preventionPlan.preventionPlanCanBeFinishMaitreOeuvre = function( event ){
	window.eoxiaJS.digirisk.preventionPlan.checkIfPreventionPlanCanBeFinishMaitreOeuvre( jQuery( this ) );
}

window.eoxiaJS.digirisk.preventionPlan.PreventionPlanCanBeFinishIntervenantExterieur = function( event ){
	window.eoxiaJS.digirisk.preventionPlan.checkIfPreventionPlanCanBeFinishIntervenantExterieur( jQuery( this ) );
}

window.eoxiaJS.digirisk.preventionPlan.checkIfPreventionPlanCanBeFinishMaitreOeuvre = function( element ){
	var parent_element = element;
	var maitre_oeuvre_element = element.find( '.information-maitre-oeuvre' );

	var error = false;
	error = window.eoxiaJS.digirisk.preventionPlan.checkIfThisChampsIsValid( maitre_oeuvre_element, 'user_id', error );
	error = window.eoxiaJS.digirisk.preventionPlan.checkIfThisChampsIsValid( maitre_oeuvre_element, 'user_signature', error );

	if( ! error ) {
		parent_element.find( '.prevention-start' ).removeClass( 'button-disable' );
	} else {
		parent_element.find( '.prevention-start' ).addClass( 'button-disable' );
	}
}

window.eoxiaJS.digirisk.preventionPlan.checkIfPreventionPlanCanBeFinishIntervenantExterieur = function( element ){
	var parent_element = element.closest( '.digi-prevention-plan-parent' );

	var intervenant_exterieur_element = parent_element.find( '.information-intervenant-exterieur' );
	var error = false;

	error = window.eoxiaJS.digirisk.preventionPlan.checkIfThisChampsIsValid( intervenant_exterieur_element, 'intervenant-name', error );
	error = window.eoxiaJS.digirisk.preventionPlan.checkIfThisChampsIsValid( intervenant_exterieur_element, 'intervenant-lastname', error );
	error = window.eoxiaJS.digirisk.preventionPlan.checkIfThisChampsIsValid( intervenant_exterieur_element, 'intervenant-phone', error );
	error = window.eoxiaJS.digirisk.preventionPlan.checkIfThisChampsIsValid( intervenant_exterieur_element, 'intervenant-email', error );
	error = window.eoxiaJS.digirisk.preventionPlan.checkIfThisChampsIsValid( intervenant_exterieur_element, 'user_signature', error );

	if( ! error ){
		parent_element.find( '.prevention-start' ).removeClass( 'button-disable' );
	}else{
		parent_element.find( '.prevention-start' ).addClass( 'button-disable' );
	}
}

window.eoxiaJS.digirisk.preventionPlan.generateDocumentPreventionSuccess = function( triggeredElement, response ){
	if( response.data.link != "" ){
		var element = document.createElement('a');
		element.setAttribute('href', response.data.link );
		element.setAttribute('download', response.data.filename);

		element.style.display = 'none';
		document.body.appendChild(element);

		element.click();
		document.body.removeChild(element);
	}
}

window.eoxiaJS.digirisk.preventionPlan.displayUserInfo = function( event ){
	var element = jQuery( this ).closest( '.avatar-info-prevention' ).find( '.info-text' );

	if( jQuery( element ).css( 'display' ) == "none" ){
		element.show();
	}else{
		element.hide();
	}

}

window.eoxiaJS.digirisk.preventionPlan.deleteThisPreventionPlan = function( event ){
	var message = jQuery( this ).attr( 'data-message' );
	if( confirm( message ) ){
		var data = {};

		data.action = jQuery( this ).attr( 'data-action' );
		data._wpnonce = jQuery( this ).attr( 'data-nonce' );
		data.id = jQuery( this ).attr( 'data-id' );

		window.eoxiaJS.loader.display( jQuery( this ).closest( '.item' ) );
		window.eoxiaJS.request.send( jQuery( this ), data );
	}
}

window.eoxiaJS.digirisk.preventionPlan.deleteDocumentPreventionSuccess = function( trigerredElement, response ){
	trigerredElement.closest( '.main-content' ).html( response.data.dashboard_view );
}

window.eoxiaJS.digirisk.preventionPlan.updateEndDatePrevention = function( event ){
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

window.eoxiaJS.digirisk.preventionPlan.updateTitleOption = function( event ){
	// jQuery( this ).closest( '.title-information-option' ).find( '.wpeo-button' ).removeClass( 'button-blue' ).addClass( 'button-grey' );3
	var type = jQuery( this ).attr( 'data-type' );
	if( jQuery( this ).closest( '.title-information-option' ).find( 'input[name="' + type + '"]' ).val() == "1" ){
		jQuery( this ).closest( '.title-information-option' ).find( 'input[name="' + type + '"]' ).val( '0' );
		jQuery( this ).removeClass( 'button-blue' ).addClass( 'button-grey' );
		jQuery( this ).find( '.button-icon' ).removeClass( 'fa-check-square' ).addClass( 'fa-square' );
	}else{
		jQuery( this ).closest( '.title-information-option' ).find( 'input[name="' + type + '"]' ).val( '1' );
		jQuery( this ).removeClass( 'button-grey' ).addClass( 'button-blue' );
		jQuery( this ).find( 'input[name="' + type + '"]' ).val( '1' );
		jQuery( this ).find( '.button-icon' ).removeClass( 'fa-square' ).addClass( 'fa-check-square' );
	}
}

window.eoxiaJS.digirisk.preventionPlan.editThisPreventionSuccess = function( trigerredElement, response ){
	if( response.data.url ){
		window.location.replace( response.data.url );
	}
}
