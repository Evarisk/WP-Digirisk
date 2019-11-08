/**
 * Initialise l'objet "DUER" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since   6.2.1
 * @version 7.0.0
 */

window.eoxiaJS.digirisk.DUER = {};

/**
 * Méthode obligatoire pour initialiser l'objet DUER avec EO-Framework.
 *
 * @since 6.2.1
 * @version 6.2.1
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.DUER.init = function() {
	window.eoxiaJS.digirisk.DUER.event();
};

/**
 * Méthode pour initialiser tous les évènements.
 *
 * @since   6.2.1
 * @version 7.0.0
 *
 * @return void
 */
window.eoxiaJS.digirisk.DUER.event = function() {
	jQuery( document ).on( 'modal-opened', '.duer-modal', window.eoxiaJS.digirisk.DUER.modalOpened );
	jQuery( document ).on( 'click', '.duer-modal .button-main', window.eoxiaJS.digirisk.DUER.applyValueToTextarea );

	jQuery( document ).on( 'modal-opened', '.generate-duer-modal', window.eoxiaJS.digirisk.DUER.generateDUERModalOpened );
	jQuery( document ).on( 'click', '.generate-duer-modal .button-main', window.eoxiaJS.digirisk.DUER.closeModalGenerateDUER );
};

/**
 * @todo
 * @param  {[type]} event [description]
 * @param  {[type]} data  [description]
 * @return {[type]}       [description]
 */
window.eoxiaJS.digirisk.DUER.modalOpened = function( event, triggeredElement ) {
	jQuery( this ).find( '.modal-content' ).html( '' );

	if ( 'view' !== jQuery( triggeredElement ).data( 'type' ) ) {
		var textareaContent = jQuery( triggeredElement ).closest( 'tr' ).find( '.textarea-content-' + jQuery( triggeredElement ).data( 'src' ) ).val();
		jQuery( this ).find( '.modal-content' ).html( '<textarea data-to="' + jQuery( triggeredElement ).data( 'src' ) + '" rows="8" style="width: 100%; display: inline-block;"></textarea>' );

		jQuery( '.duer-modal' ).find( 'textarea' ).val( textareaContent );
	} else {
		var content = jQuery( triggeredElement ).closest( 'tr' ).find( '.text-content-' + jQuery( triggeredElement ).data( 'src' ) ).html();
		jQuery( this ).find( '.modal-content' ).html( '<p></p>' );

		jQuery( '.duer-modal' ).find( 'p' ).html( content );
	}
};

/**
 * [description]
 *
 * @since 7.0.0
 *
 * @param  {[type]} triggeredElement [description]
 */
window.eoxiaJS.digirisk.DUER.viewInPopup = function( triggeredElement ) {
	return true;
};

/**
 * @todo
 * @param  {[type]} event [description]
 * @return {[type]}       [description]
 */
window.eoxiaJS.digirisk.DUER.applyValueToTextarea = function( event ) {
	var textarea =  jQuery( '.duer-modal' ).find( 'textarea' );

	jQuery( '.table.duer tfoot .textarea-content-' + textarea.attr( 'data-to' ) ).val( textarea.val() );
};

window.eoxiaJS.digirisk.DUER.generateDUERModalOpened = function( event, triggeredElement ) {
	window.eoxiaJS.digirisk.DUER.generateDUER( jQuery( triggeredElement ), {
		data: {
			index: 1
		}
	} );
}

/**
 * Construit, et génères tous les documents ainsi que le DUER.
 *
 * @since   6.2.1
 * @version 7.0.0
 *
 * @param  {HTMLDivElement} triggeredElement [description]
 * @param  {object} preData          [description]
 * @return {void}                   [description]
 */
window.eoxiaJS.digirisk.DUER.generateDUER = function( triggeredElement, preData ) {
	var data = {};
	var i = 0;
	var key;
	var listInput = window.eoxiaJS.arrayForm.getInput( triggeredElement.closest( 'tr' ) );

	for ( i = 0; i < listInput.length; i++ ) {
		if ( listInput[i].name ) {
			data[listInput[i].name] = window.eoxiaJS.arrayForm.getInputValue( listInput[i] );
		}
	}

	for ( key in preData.data ) {
		data[key] = preData.data[key];
	}

	jQuery( '.generate-duer-modal li:nth-child(' + ( preData.data.index ) + ')' ).get_data( function( attributeData ) {
		for( key in attributeData ) {
			data[key] = attributeData[key];
		}

		window.eoxiaJS.request.send( triggeredElement, data );
	} );
};

/**
 * Le callback en cas de réussite à la requête Ajax "generate_DUER".
 * Coches le LI correspondant à index et regénères un DUER.
 * Si la réponse contient "end", stop la génération du DUER, et rend le bouton cliquable.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since   6.2.1
 * @version 6.5.0
 */
window.eoxiaJS.digirisk.DUER.generatedDUERSuccess = function( element, response ) {
	jQuery( '.generate-duer-modal li:nth-child(' + ( response.data.index ) + ')' ).find( 'img' ).remove();
	jQuery( '.generate-duer-modal li:nth-child(' + ( response.data.index ) + ')' ).append( '<span class="dashicons dashicons-yes"></span>' );

	if ( ! response.data.end ) {
		response.data.index++;
		window.eoxiaJS.digirisk.DUER.generateDUER( element, response );
	} else {
		jQuery( '.generate-duer-modal' ).removeClass( 'no-close modal-force-display' );
	}
};

/**
 * @todo
 * @return {[type]} [description]
 */
window.eoxiaJS.digirisk.DUER.callback_generate_duer_error = function() {};

/**
 * Lors de la fermeture de la popup qui génère le DUER.
 *
 * @since   6.2.1
 * @version 6.5.0
 *
 * @param  {HTMLSpanElement} element L'élément déclencheur de l'action.
 * @param  {ClickEvent} event        L'état de la souris
 * @return {void}
 */
window.eoxiaJS.digirisk.DUER.closeModalGenerateDUER = function( element, event ) {
	if ( jQuery( '.digirisk-wrap .tab-element[data-target="digi-list-duer"]' ) ) {
		jQuery( '.digirisk-wrap .tab-element[data-target="digi-list-duer"]' ).click();
	}
};
