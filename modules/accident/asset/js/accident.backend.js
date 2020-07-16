/**
 * Initialise l'objet "accident" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.1.5
 */
window.eoxiaJS.digirisk.accident = {};
window.eoxiaJS.digirisk.accident.canvas = [];

window.eoxiaJS.digirisk.accident.init = function() {
	window.eoxiaJS.digirisk.accident.event();
	// window.eoxiaJS.digirisk.accident.refresh();
};

window.eoxiaJS.digirisk.accident.refresh = function() {
	/*alert('ok');
	window.eoxiaJS.digirisk.accident.canvas = document.querySelectorAll("canvas");
	for( var i = 0; i < window.eoxiaJS.digirisk.accident.canvas.length; i++ ) {
		window.eoxiaJS.digirisk.accident.canvas[i].signaturePad = new SignaturePad( window.eoxiaJS.digirisk.accident.canvas[i], {
			penColor: "rgb(66, 133, 244)"
		} );
	}

	window.eoxiaJS.digirisk.accident.resizeCanvas();*/
}

/**
 * Initialise les évènements
 *
 * @since 6.4.0
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.accident.event = function() {
	jQuery( document ).on( 'change', '.wpeo-table.table-accident .table-row-advanced input[type="checkbox"]', window.eoxiaJS.digirisk.accident.changeSelectAccidentInvestigation );
	jQuery( document ).on( 'click', '.wpeo-table.table-accident .table-row-advanced .fa-eraser', window.eoxiaJS.digirisk.accident.clearCanvas );
	jQuery( document ).on( 'keyup', '.wpeo-table.table-accident .table-row-advanced.table-add input, textarea', window.eoxiaJS.digirisk.accident.callFunctionCheckCanAdd );
	jQuery( document ).on( 'click', '.wpeo-table.table-accident .table-row-advanced.table-add .autocomplete-search-list li', window.eoxiaJS.digirisk.accident.callFunctionCheckCanAdd );
	jQuery( document ).on( 'click', '.flex-table.accident .col.advanced .edit-work-stopping-communication-link', window.eoxiaJS.digirisk.accident.editAccidentWorkStoppingCommunication );

	window.addEventListener( "resize", window.eoxiaJS.digirisk.accident.resizeCanvas );
};

/**
 * Affiches le champs 'upload' quand la select box est sur 'true'.
 *
 * @since 6.4.0
 *
 * @param  {Event} event L'évènement lors du changement de la select box.
 * @return {void}
 */
window.eoxiaJS.digirisk.accident.changeSelectAccidentInvestigation = function( event ) {
	jQuery( this ).closest( '.investigation-group' ).find( '.investigation-media' ).addClass( 'hidden' );
	if ( jQuery( this ).is( ':checked' ) ) {
		jQuery( this ).closest( '.investigation-group' ).find( '.investigation-media' ).removeClass( 'hidden' );
	}
};

window.eoxiaJS.digirisk.accident.editAccidentWorkStoppingCommunication = function( event ) {
		jQuery( this ).closest('.work-stopping-communication').find( '.work-stop' ).removeClass( 'hidden' );
		jQuery( this ).closest('.work-stopping-communication').find( '.work-stop' ).addClass( 'text' );
		jQuery( this ).remove();
};
/**
 * Clear le canvas.
 *
 * @since 6.4.0
 *
 * @param  {Event} event L'état de l'évènement à ce moment T.
 * @return {void}
 */
window.eoxiaJS.digirisk.accident.clearCanvas = function( event ) {
	var canvas = jQuery( this ).closest( 'div' ).find( 'canvas' );
	canvas[0].signaturePad.clear();
};

window.eoxiaJS.digirisk.accident.callFunctionCheckCanAdd = function( event ) {
	window.eoxiaJS.digirisk.accident.checkCanAdd( jQuery( this ) );
}
window.eoxiaJS.digirisk.accident.checkCanAdd = function( element ) {
	var accidentRow = element.closest( '.table-row-advanced' );
	if ( accidentRow.find( 'input[name="accident[victim_identity_id]"]' ).val() && accidentRow.find( 'input[name="accident[parent_id]"]' ).val() && accidentRow.find( 'textarea' ).val() ) {
		accidentRow.find( '.action-input' ).removeClass( 'button-disable' );
	} else {
		accidentRow.find( '.action-input' ).addClass( 'button-disable' );
	}
};

/**
 * Quand on "resize" la fenêtre, adapte le canvas.
 *
 * @since 6.4.0
 *
 * @param  {Event} event L'état de l'évènement à ce moment T.
 * @return {void}
 */
window.eoxiaJS.digirisk.accident.resizeCanvas = function( event ) {
	var ratio =  Math.max( window.devicePixelRatio || 1, 1 );

	for( var i = 0; i < window.eoxiaJS.digirisk.accident.canvas.length; i++ ) {
		window.eoxiaJS.digirisk.accident.canvas[i].width = window.eoxiaJS.digirisk.accident.canvas[i].offsetWidth * ratio;
		window.eoxiaJS.digirisk.accident.canvas[i].height = window.eoxiaJS.digirisk.accident.canvas[i].offsetHeight * ratio;
		window.eoxiaJS.digirisk.accident.canvas[i].getContext( "2d" ).scale( ratio, ratio );
		window.eoxiaJS.digirisk.accident.canvas[i].signaturePad.clear();
	}
};

/**
 * Le callback en cas de réussite à la requête Ajax "edit_accident".
 * Remplaces le contenu du tableau par la vue renvoyée par la réponse Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.1.5
 */
window.eoxiaJS.digirisk.accident.editedAccidentSuccess = function( triggeredElement, response ) {
	if ( response.data.add ) {
		// console.log(triggeredElement.closest( '.wpeo-table.table-accident' ).find( '.table-row-advanced' ));
		triggeredElement.closest( '.wpeo-table.table-accident' ).find( '.table-row-advanced' ).first().prepend( response.data.view );
		jQuery( '.wpeo-table.table-accident .table-row-advanced:first input[type="text"]:first' ).focus();
	} else {
		triggeredElement.closest( '.digirisk-wrap' ).replaceWith( response.data.view );
	}
	// window.eoxiaJS.digirisk.accident.refresh();
};

/**
 * Le callback en cas de réussite à la requête Ajax "load_accident".
 * Remplaces le contenu de la ligne du tableau "accident" par le template renvoyé par la requête Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.1.5
 */
window.eoxiaJS.digirisk.accident.loadedAccidentSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.table-row-advanced' ).replaceWith( response.data.view );
	// window.eoxiaJS.digirisk.accident.refresh();
	jQuery( '.table-row-advanced[data-id=' + response.data.id + '] canvas' ).each( function() {
		jQuery( this )[0].signaturePad.clear();
		if ( jQuery( this ).closest( 'div' ).find( '.url' ).val() ) {
			jQuery( this )[0].signaturePad.fromDataURL( jQuery( this ).closest( 'div' ).find( '.url' ).val() );
		}
	} );
};

/**
 * Le callback en cas de réussite à la requête Ajax "delete_accident".
 * Supprimes la ligne du tableau.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.1.5
 */
window.eoxiaJS.digirisk.accident.deletedAccidentSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( '.table-row-advanced' ).fadeOut();
};

/**
 * Le callback en cas de réussite à la requête Ajax "generate_accident".
 * Remplace la vue du tableau
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.3.0
 */
window.eoxiaJS.digirisk.accident.generatedAccidentBenin = function( element, response ) {
	jQuery( '.document-accident-benins' ).replaceWith( response.data.view );
};

/**
 * Le callback en cas de réussite à la requête Ajax "generate_registre_accidents_travail_benins".
 * Cliques automatiquement sur l'onglet 'Registre accidents'
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.3.0
 */
window.eoxiaJS.digirisk.accident.generatedRegistreATBenin = function( element, response ) {
	jQuery( '.tab-list .tab-element[data-target="digi-registre-accident"]' ).click();
};

/**
 * Le callback en cas de réussite à la requête Ajax "edit_stopping_day".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.4.0
 */
window.eoxiaJS.digirisk.accident.editedStoppingDaySuccess = function( triggeredElement, response ) {
	triggeredElement.closest( 'div' ).html( response.data.view );
};

/**
 * Le callback en cas de réussite à la requête Ajax "delete_stopping_day".
 * Cliques automatiquement sur l'onglet 'Registre accidents'
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.4.0
 */

window.eoxiaJS.digirisk.accident.deletedStoppingDay = function( triggeredElement, response ) {
	triggeredElement.closest( '.comment' ).fadeOut();
};

window.eoxiaJS.digirisk.accident.checkStoppingDayData = function( element ) {
	// element.closest( '.wpeo-tooltip-eventtooltip.active' ).removeClass( 'active' );
	window.eoxiaJS.tooltip.remove( jQuery( element.closest( '.wpeo-tooltip-event' ) ) );

	if ( isNaN( element.closest( '.comment' ).find( '.is-number' ).val() ) || '' == element.closest( '.comment' ).find( '.is-number' ).val() ) {
		// element.closest( '.tooltip' ).addClass( 'active' );
		window.eoxiaJS.tooltip.display( jQuery( element.closest( '.wpeo-tooltip-event' ) ) );
		return false;
	}

	return true;
}

window.eoxiaJS.digirisk.accident.checkDataBeforeAdd = function( element ) {
	var accidentRow = element.closest( '.table-row-advanced' );

	accidentRow.find( '.tooltip' ).removeClass( 'active' );

	if ( '' === accidentRow.find( 'input[name="accident[victim_identity_id]"]' ).val() ) {
		accidentRow.find( 'input[name="accident[victim_identity_id]"]' ).closest( '.tooltip' ).addClass( 'active' );
		return false;
	}

	if ( '' === accidentRow.find( 'input[name="accident[parent_id]"]' ).val() ) {
		accidentRow.find( 'input[name="accident[parent_id]"]' ).closest( '.tooltip' ).addClass( 'active' );
		return false;
	}

	if ( '' === accidentRow.find( 'textarea' ).val() ) {
		accidentRow.find( 'textarea' ).closest( '.tooltip' ).addClass( 'active' );
		return false;
	}

	return true;
};

window.eoxiaJS.digirisk.accident.checkAllData = function( element ) {
	var isNumber = true;
	jQuery( '.wpeo-table.table-accident .tooltip.active' ).removeClass( 'active' );

	jQuery( '.wpeo-table.table-accident .comment:not(.new) .is-number' ).each( function() {
		if ( isNaN( jQuery( this ).val() ) || '' == jQuery( this ).val() ) {
			jQuery( this ).closest( '.tooltip' ).addClass( 'active' );
			isNumber = false;
		}
	} );

	jQuery( '.wpeo-table.table-accident .comment.new .is-number' ).each( function() {
		if ( isNaN( jQuery( this ).val() ) ) {
			jQuery( this ).closest( '.tooltip' ).addClass( 'active' );
			isNumber = false;
		}
	} );

	if ( ! isNumber ) {
		return false;
	}

	var id = jQuery( element ).closest( '.table-row-advanced' ).attr( 'data-id' );
	var accidentRow = jQuery( element ).closest( '.table-row-advanced[data-id="' + id + '"]' );

	accidentRow.find( 'canvas' ).each( function() {
		if ( ! jQuery( this )[0].signaturePad.isEmpty() ) {
			jQuery( this ).closest( 'div' ).find( 'input:first' ).val( jQuery( this )[0].toDataURL() );
		}
	} );

	return true;
}
