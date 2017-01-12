window.digirisk.DUER = {};

window.digirisk.DUER.init = function() {
	window.digirisk.DUER.event();
};

window.digirisk.DUER.event = function() {
};

/**
 * Cette méthode est appelée lors du clique sur une des icones dans le tableau d'édition des DUER.
 *
 * Remplis la popup avec:
 * -la balise <h2> qui est égale au titre data-title de triggeredElement.
 * -la balise <textarea> qui est égale au contenu du textarea de args.src dans le tableau de l'édition d'un DUER.
 * -Modifie le contenu de ".change-content" par un <textarea>. On modifie le contenu car la Popup est utilisé dans d'autres cas.
 * -Rend invisible la balise <p>. Cette balise <p> est utilisé quand on veut voir le contenu de la popup et non le modifier.
 * -Met args.src dans l'attribut data-target du "bouton vert" qui permet de valider l'édition.
 *
 * @param  {HTMLSpanElement} triggeredElement L'icone qui déclenche l'action.
 * @param  {HTMLDivElement}  popupElement     La popup.
 * @param  {MouseEvent}      event            Le clic sur l'icone.
 * @param  {Object}          args             Les données sur l'élement HTMLSpanElement. (l'icone)
 * @return {void}
 *
 * @since 0.1
 * @version 6.2.4.0
 */
window.digirisk.DUER.fill_textarea_in_popup = function( triggeredElement, popupElement, event, args ) {
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

window.digirisk.DUER.view_in_popup = function( triggered_element, popup_element, event, args ) {
	if (args) {
		popup_element.find( 'h2' ).text( args.title );
		popup_element.find( 'textarea' ).hide();
		popup_element.find( '.change-content' ).html( '<p></p>' );
		popup_element.find( 'p' ).text( triggered_element.closest( '.wp-digi-list-item' ).find( '.text-content-' + args['src'] ).text() ).show();
	}
};

window.digirisk.DUER.set_textarea_content = function( triggeredElement, event, args ) {
	if ( args && args['target'] ) {
		var textarea_content = jQuery( '.popup textarea' ).val();

		jQuery( '.textarea-content-' + args['target'] ).val( textarea_content );
	}
};

window.digirisk.DUER.popup_for_generate_DUER = function( triggeredElement, popupElement, event, args ) {
	var data = {
		action: 'display_societies_duer',
		id: args.id,
		_wpnonce: args._wpnonce
	};

	popupElement.find( 'h2' ).text( args.title );
	popupElement.addClass( 'no-close' );
	popupElement.find( 'button.button-primary' ).attr( 'disabled', true );
	popupElement.find( 'button.button-primary' ).attr( 'data-cb-func', 'close_popup_generate_DUER' );

	window.digirisk.request.send( popupElement, data );
};

window.digirisk.DUER.display_societies_duer_success = function( popup, response ) {
	popup.find( '.change-content' ).html( response.data.view );

	window.digirisk.DUER.generate_DUER( jQuery( '.open-popup.dashicons-plus' ), { index: 0 } );
};

window.digirisk.DUER.generate_DUER = function( triggeredElement, preData ) {
	var data = {};
	var i = 0;
	var listInput = window.eva_lib.array_form.get_input( triggeredElement.closest( '.wp-digi-list-item' ) );

	for ( i = 0; i < listInput.length; i++ ) {
		if ( listInput[i].name ) {
			data[listInput[i].name] = window.eva_lib.array_form.get_input_value( listInput[i] );
		}
	}

	for ( i in preData ) {
		data[i] = preData[i];
	}

	data['society_id'] = jQuery( '.popup li:nth-child(' + ( data.index + 1 ) + ')' ).data( 'id' );
	data['duer'] = jQuery( '.popup li:nth-child(' + ( data.index + 1 ) + ')' ).data( 'duer' );
	data['generate_duer'] = jQuery( '.popup li:nth-child(' + ( data.index + 1 ) + ')' ).data( 'generate-duer' );
	data['zip'] = jQuery( '.popup li:nth-child(' + ( data.index + 1 ) + ')' ).data( 'zip' );

	if ( data['zip'] ) {
		data['element_id'] = jQuery( '.popup li:nth-child(3)' ).data( 'id' );
	}

	if ( data['generate_duer'] ) {
		data['element_id'] = jQuery( '.popup li:nth-child(' + ( data.index + 1 ) + ')' ).data( 'element-id' );
		data['parent_id'] = jQuery( '.popup li:nth-child(' + ( data.index + 1 ) + ')' ).data( 'parent-id' );
	}

	window.digirisk.request.send( triggeredElement, data );
};

window.digirisk.DUER.callback_generate_duer_success = function( element, response ) {
	jQuery( '.popup li:nth-child(' + ( response.data.index ) + ')' ).find( 'img' ).remove();
	jQuery( '.popup li:nth-child(' + ( response.data.index ) + ')' ).append( '<span class="dashicons dashicons-yes"></span>' );
	if ( response.data.creation_response.id  ) {
		jQuery( '.popup li:nth-child(' + ( response.data.index + 1 ) + ')' ).attr( 'data-element-id', response.data.creation_response.id );
	}

	if ( ! response.data.end ) {
		window.digirisk.DUER.generate_DUER( element, response.data );
	} else {
		jQuery( '.popup' ).find( 'button' ).attr( 'disabled', false );
	}
};

window.digirisk.DUER.callback_generate_duer_error = function() {};

window.digirisk.DUER.close_popup_generate_DUER = function( element, event ) {
	jQuery( '.wp-digi-group-sheet button[data-action="digi_list_duer"]' ).click();
};
