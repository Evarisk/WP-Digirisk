/**
 * Initialise l'objet "causerie" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since   6.6.0
 */
window.eoxiaJS.digirisk.causerie = {};

/**
 * Gestion des signatures.
 *
 * @type {HTMLCanvasElement}
 */
window.eoxiaJS.digirisk.causerie.canvas;

/**
 * Initialise les évènements.
 *
 * @since   6.6.0
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.causerie.init = function() {
	window.eoxiaJS.digirisk.causerie.event();
	window.eoxiaJS.digirisk.causerie.refresh();
};

/**
 * Initialise le canvas, ainsi que owlCarousel.
 *
 * @since   6.6.0
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.causerie.refresh = function() {
	window.eoxiaJS.digirisk.causerie.canvas = document.querySelectorAll("canvas");
	for( var i = 0; i < window.eoxiaJS.digirisk.causerie.canvas.length; i++ ) {
		window.eoxiaJS.digirisk.causerie.canvas[i].signaturePad = new SignaturePad( window.eoxiaJS.digirisk.causerie.canvas[i], {
			penColor: "rgb(66, 133, 244)"
		} );
	}

	jQuery( '.causerie-wrap .owl-carousel' ).owlCarousel( { 'items': 1 } );
};

/**
 * Initialise les évènements principaux des causeries.
 *
 * @since   6.6.0
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.causerie.event = function() {
	// Gestion du titre de la modal.
	jQuery( document ).on( 'change', '.wpeo-autocomplete', window.eoxiaJS.digirisk.causerie.updateModalTitle );

	jQuery( document ).on( 'click', '.modal-signature .wpeo-button.button-blue', window.eoxiaJS.digirisk.causerie.saveSignatureURL );

	jQuery( document ).on( 'click', '.causerie-wrap a.disabled', function( event ) {
		event.preventDefault();
		return false;
	} );
};

/**
 * Met à jour le titre de la modal lors du clic sur le bouton pour que l'utilisateur effectue sa signature.
 *
 * @since   6.6.0
 *
 * @param  {MouseEvent} event  Les données du clic.
 * @param  {Object}     data   Contient les données de la requête XHR.
 */
window.eoxiaJS.digirisk.causerie.updateModalTitle = function( event, data ) {
	var title = '';
	var element  = jQuery( this );

	if ( data && data.element ) {
		var request_data = {};
		request_data.action  = 'causerie_save_former';
		request_data.id      = jQuery( this ).closest( 'tr' ).find( 'input[name="causerie_id"]' ).val();
		request_data.user_id = jQuery( this ).closest( 'tr' ).find( 'input[name="former_id"]' ).val();

		window.eoxiaJS.loader.display( jQuery( this ) );
		window.eoxiaJS.request.send( jQuery( this ), request_data, function( triggeredElement, resposne) {
			title = 'Signature de l\'utilisateur: ' + data.element.data( 'result' );
			element.closest( 'tr' ).find( '.wpeo-modal-event' ).attr( 'data-title', title );
			element.closest( 'tr' ).find( '.wpeo-modal-event' ).removeClass( 'button-disable' );
		} );
	}
};

/**
 * Enregistres dans un champ caché
 *
 * @since   6.6.0
 *
 * @param  {MouseEvent} event Les données du clic.
 *
 * @TODO: Mieux définir cette méthode.
 */
window.eoxiaJS.digirisk.causerie.saveSignatureURL = function( event ) {
	event.preventDefault();

	jQuery( '.modal-signature' ).find( 'canvas' ).each( function() {
		if ( ! jQuery( this )[0].signaturePad.isEmpty() ) {
			jQuery( this ).closest( 'div' ).find( 'input:first' ).val( jQuery( this )[0].toDataURL() );
			jQuery( '.step-1 .action-input[data-action="next_step_causerie"]' ).removeClass( 'button-disable' );
			jQuery( '.step-3 a.button-disable' ).removeClass( 'button-disable' );
		}
	} );
};

/**
 * Appliques la signature.
 *
 * @since   6.6.0
 *
 * @param  {[type]} element [description]
 * @return {boolean}         [description]
 *
 * @TODO: Mieux définir cette méthode.
 */
window.eoxiaJS.digirisk.causerie.applySignature = function( element ) {
	if ( ! element.closest( '.wpeo-modal' ).find( 'canvas' )[0].signaturePad.isEmpty() ) {
		element.closest( '.wpeo-modal' ).find( 'input[name="signature_data"]' ).val( element.closest( '.wpeo-modal' ).find( 'canvas' )[0].toDataURL() );
	}

	return true;
};

/**
 * Vérifie que la catégorie de risque soit sélectionné avant d'enregistrer la causerie.
 *
 * @since 6.6.0
 *
 * @param  {HTMLDivElement} triggeredElement L'élément déclenchant l'action.
 *
 * @return {boolean}                         True pour continuer l'action. False pour stopper l'action.
 */
window.eoxiaJS.digirisk.causerie.beforeSaveCauserie = function( triggeredElement ) {
	window.eoxiaJS.tooltip.remove( triggeredElement.closest( '.causerie-row' ).find( '.category-danger.wpeo-tooltip-event' ) );

	// Vérification du danger.
	if ( '-1' === triggeredElement.closest( '.causerie-row' ).find( 'input[name="risk_category_id"]' ).val() ) {
		window.eoxiaJS.tooltip.display( triggeredElement.closest( '.causerie-row' ).find( '.category-danger.wpeo-tooltip-event' ) );
		return false;
	}

	return true;
};

/**
 * Le callback en cas de réussite à la requête Ajax "edit_causerie".
 * Remplaces le contenu du tableau par la vue renvoyée par la réponse Ajax.
 *
 * @since   6.6.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 */
window.eoxiaJS.digirisk.causerie.editedCauserieSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.tab-content' ).html( response.data.view );
};

/**
 * Le callback en cas de réussite à la requête Ajax "load_causerie".
 * Remplaces le contenu de la ligne du tableau "causerie" par le template renvoyé par la requête Ajax.
 *
 * @since   6.6.0
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
 * @since   6.6.0
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
 * @since   6.6.0
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
window.eoxiaJS.digirisk.causerie.savedParticipant = function( element, response ) {
	jQuery( '.ajax-content' ).html( response.data.view );

	window.eoxiaJS.digirisk.causerie.checkParticipantsSignature();

	window.eoxiaJS.refresh();
};

/**
 * Vérifie si toutes les signatures sont présentes dans le tableau.
 * Si toutes les signatures sont présentes, le bouton pour cloturer la causerie est cliquable.
 * Sinon, si une signature est manquante, le bouton est grisé.
 *
 * @since   6.6.0
 *
 * @return {boolean}
 */
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
		jQuery( '.step-3 a.disabled' ).removeClass( 'disabled wpeo-tooltip-event' );
	} else {
		jQuery( '.step-3 a.disabled' ).addClass( 'disabled wpeo-tooltip-event' );
	}
};

/**
 * Remplaces le contenu de la ligne déclenchant cette action.
 * Cette action est déclenché lorsqu'un participant signe dans la modal.
 *
 * Cette méthode appelle la méthode "checkParticipantsSignature" afin de vérifier
 * si le bouton "cloturer la causerie" peut être cliquable.
 *
 * @since   6.6.0
 * @version 6.6.0
 *
 * @param  {HTMLDivElement} element  Le bouton déclenchant l'action.
 * @param  {Object}         response La réponse de la requête avec la vue.
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.causerie.savedSignature = function( element, response ) {
	element.closest( 'tr' ).replaceWith( response.data.view );

	window.eoxiaJS.digirisk.causerie.checkParticipantsSignature();

	window.eoxiaJS.digirisk.causerie.refresh();
};

/**
 * Remplaces le contenu de la ligne déclenchant cette action.
 * Cette action est déclenché lorsqu'un participant signe dans la modal.
 *
 * Cette méthode appelle la méthode "checkParticipantsSignature" afin de vérifier
 * si le bouton "cloturer la causerie" peut être cliquable.
 *
 * @since   6.6.0
 * @version 6.6.0
 *
 * @param  {HTMLDivElement} element  Le bouton déclenchant l'action.
 * @param  {Object}         response La réponse de la requête avec la vue.
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.causerie.savedFormerSignature = function( element, response ) {
	element.closest( 'tr' ).find( 'td.signature' ).replaceWith( response.data.view );

	window.eoxiaJS.digirisk.causerie.refresh();
};

/**
 * Vérifie que l'utilisateur et que la signature soit bien présente dans le formulaire.
 *
 * @since   6.6.0
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

	if ( jQuery( '.step-1 input[name="signature_data"]' ).length ) {
		jQuery( '.step-1 .signature-tooltip' ).addClass( 'active' );

		return false;
	}

	return true;
};

/**
 * Vérifie que l'ID de l'utilisateur soit bien présente dans le formulaire.
 *
 * @since   6.6.0
 *
 * @param  {HTMLDivElement} element Le bouton déclenchant cette méthode.
 *
 * @return {boolean}                True si le formateur à été choisi, sinon false pour stopper la requête XHR.
 */
window.eoxiaJS.digirisk.causerie.checkUserID = function( element ) {
	element.closest( 'tr' ).find( '.user-tooltip' ).removeClass( 'active' );

	if ( ! element.closest( 'tr' ).find( 'input[name="participant_id"]' ).val() ) {
		element.closest( 'tr' ).find( '.user-tooltip' ).addClass( 'active' );

		return false;
	}

	return true;
};
