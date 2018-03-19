/**
 * Initialise l'objet "DUER" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.2.1
 * @version 6.5.0
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
 * @since 6.2.1
 * @version 6.2.1
 *
 * @return void
 */
window.eoxiaJS.digirisk.DUER.event = function() {};

/**
 * Cette méthode est appelée lors du clique sur une des icones dans le tableau d'édition des DUER.
 *
 * Remplis la popup avec:
 * -la balise <h2> qui est égale au titre data-title de triggeredElement.
 * -la balise <textarea> qui est égale au contenu du textarea de args.src dans le tableau de l'édition d'un DUER.
 * -Modifie le contenu de ".change-content" par un <textarea>. On modifie le contenu car la Popup est utilisé dans d'autres cas.
 * -Rend invisible la balise <p>. Cette balise <p> est utilisé quand on veut voir le contenu de la popup et non le modifier.
 *
 * -Met args.src dans l'attribut data-target du "bouton vert" qui permet de valider l'édition.
 *
 * @param  {HTMLSpanElement} triggeredElement L'icone qui déclenche l'action.
 * @param  {HTMLDivElement}  popupElement     La popup.
 * @param  {MouseEvent}      event            Le clic sur l'icone.
 * @param  {Object}          args             Les données sur l'élement HTMLSpanElement. (l'icone)
 * @return {void}
 *
 * @since 6.2.1
 * @version 6.2.4
 */
window.eoxiaJS.digirisk.DUER.fill_textarea_in_popup = function( triggeredElement, popupElement, event, args ) {
	var textareaContent = '';

	if ( args ) {
		popupElement.find( 'h2' ).text( args.title );
		popupElement.find( '.change-content' ).html( '<textarea class="hidden" rows="8" style="width: 100%; display: inline-block;"></textarea>' );

		// On récupères le textarea caché avec le contenu actuel.
		textareaContent = triggeredElement.closest( 'tr' ).find( '.textarea-content-' + args.src ).val();
		popupElement.find( 'textarea' ).show();
		popupElement.find( 'p' ).hide();
		popupElement.find( 'textarea' ).val( textareaContent );
		popupElement.find( '.button' ).attr( 'data-target', args.src );
	}
};

/**
 * Cette méthode est appelée lors du clique sur une des icones dans le tableau d'édition des DUER.
 *
 * Remplis la popup avec:
 * -la balise <h2> qui est égale au titre data-title de triggeredElement.
 * -Cache la balise <textarea>.
 * -Modifie le contenu de ".change-content" par un paragraphe vide pour ensuite ajouter le contenu.
 *
 * @param  {HTMLSpanElement} triggeredElement L'icone qui déclenche l'action.
 * @param  {HTMLDivElement}  popupElement     La popup.
 * @param  {MouseEvent}      event            Le clic sur l'icone.
 * @param  {Object}          args             Les données sur l'élement HTMLSpanElement. (l'icone)
 * @return {void}
 *
 * @since 6.2.1
 * @version 6.2.4
 */
window.eoxiaJS.digirisk.DUER.view_in_popup = function( triggeredElement, popupElement, event, args ) {
	if ( args ) {
		popupElement.find( 'h2' ).text( args.title );
		popupElement.find( 'textarea' ).hide();
		popupElement.find( '.change-content' ).html( '<p></p>' );
		popupElement.find( 'p' ).html( triggeredElement.closest( 'tr' ).find( '.text-content-' + args.src ).html() ).show();
	}
};

window.eoxiaJS.digirisk.DUER.set_textarea_content = function( triggeredElement, event, args ) {
	if ( args && args['target'] ) {
		var textarea_content = jQuery( '.popup textarea' ).val();

		jQuery( '.textarea-content-' + args['target'] ).val( textarea_content );
	}
};

window.eoxiaJS.digirisk.DUER.popup_for_generate_DUER = function( triggeredElement, popupElement, event, args ) {
	var data = {
		action: 'display_societies_duer',
		id: args.id,
		_wpnonce: args._wpnonce
	};

	popupElement.find( 'h2' ).text( args.title );
	popupElement.addClass( 'duer' );
	popupElement.find( '.change-content' ).html( '<p></p>' );
	popupElement.find( '.button.green' ).attr( 'data-cb-func', 'close_popup_generate_DUER' );

	window.eoxiaJS.request.send( popupElement, data );
};

window.eoxiaJS.digirisk.DUER.displayedSocietyDUERSuccess = function( popup, response ) {
	popup.find( '.change-content' ).html( response.data.view );

	window.eoxiaJS.digirisk.DUER.generateDUER( jQuery( '.open-popup.add' ), { data: { index: 1 } } );
};

/**
 * Construit, et génères tous les documents ainsi que le DUER.
 *
 * @since 6.2.1
 * @version 6.5.0
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

	jQuery( '.popup.duer li:nth-child(' + ( preData.data.index ) + ')' ).get_data( function( attributeData ) {
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
 * @since 6.2.1
 * @version 6.5.0
 */
window.eoxiaJS.digirisk.DUER.generatedDUERSuccess = function( element, response ) {
	jQuery( '.popup li:nth-child(' + ( response.data.index ) + ')' ).find( 'img' ).remove();
	jQuery( '.popup li:nth-child(' + ( response.data.index ) + ')' ).append( '<span class="dashicons dashicons-yes"></span>' );

	if ( ! response.data.end ) {
		response.data.index++;
		window.eoxiaJS.digirisk.DUER.generateDUER( element, response );
	} else {
		jQuery( '.popup' ).removeClass( 'no-close' );
	}
};

window.eoxiaJS.digirisk.DUER.callback_generate_duer_error = function() {};

/**
 * Lors de la fermeture de la popup qui génère le DUER.
 *
 * @since 6.2.1
 * @version 6.5.0
 *
 * @param  {HTMLSpanElement} element L'élément déclencheur de l'action.
 * @param  {ClickEvent} event        L'état de la souris
 * @return {void}
 */
window.eoxiaJS.digirisk.DUER.close_popup_generate_DUER = function( element, event ) {
	if ( jQuery( '.digirisk-wrap .tab-element[data-target="digi-list-duer"]' ) ) {
		jQuery( '.digirisk-wrap .tab-element[data-target="digi-list-duer"]' ).click();
	}
};
