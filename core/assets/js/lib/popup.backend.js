window.digirisk.popup = {};

window.digirisk.popup.init = function() {
	window.digirisk.popup.event();
};

window.digirisk.popup.event = function() {
  jQuery( document ).on( 'click', '.open-popup', window.digirisk.popup.open );
  jQuery( document ).on( 'click', '.open-popup-ajax', window.digirisk.popup.openAjax );
  jQuery( document ).on( 'click', '.popup .container, .digi-popup-propagation', window.digirisk.popup.stop );
  jQuery( document ).on( 'click', '.popup .container .button.green', window.digirisk.popup.confirm );
  jQuery( document ).on( 'click', '.popup .close', window.digirisk.popup.close );
  jQuery( document ).on( 'click', 'body', window.digirisk.popup.close );
};

window.digirisk.popup.open = function( event ) {
	var triggeredElement = jQuery( this );
	var target = triggeredElement.closest(  '.' + triggeredElement.data( 'parent' ) ).find( '.' + triggeredElement.data( 'target' ) );
	var cbObject, cbFunc = undefined;
	target.addClass( 'active' );

	if ( target.is( ':visible' ) && triggeredElement.data( 'cb-object' ) && triggeredElement.data( 'cb-func' ) ) {
		cbObject = triggeredElement.data( 'cb-object' );
		cbFunc = triggeredElement.data( 'cb-func' );

		// On récupères les "data" sur l'élement en tant qu'args.
		triggeredElement.get_data( function( data ) {
			window.digirisk[cbObject][cbFunc]( triggeredElement, target, event, data );
		} );
	}

  event.stopPropagation();
};

/**
 * Ouvre la popup en envoyant une requête AJAX.
 * Les paramètres de la requête doivent être configurer directement sur l'élement
 * Ex: data-action="load-workunit" data-id="190"
 *
 * @param  {[type]} event [description]
 * @return {[type]}       [description]
 */
window.digirisk.popup.openAjax = function( event ) {
	var element = jQuery( this );
	var target = jQuery( this ).closest(  '.' + jQuery( this ).data( 'parent' ) ).find( '.' + jQuery( this ).data( 'target' ) );
	target.addClass( 'active' );

	jQuery( this ).get_data( function( data ) {
		delete data.parent;
		delete data.target;
		window.digirisk.request.send( element, data );
	});

	event.stopPropagation();
};

window.digirisk.popup.confirm = function( event ) {
	var triggeredElement = jQuery( this );
	var cbObject, cbFunc = undefined;

	if ( ! jQuery( '.popup' ).hasClass( 'no-close' ) ) {
		jQuery( '.popup' ).removeClass( 'active' );

		if ( triggeredElement.data( 'cb-object' ) && triggeredElement.data( 'cb-func' ) ) {
			cbObject = triggeredElement.data( 'cb-object' );
			cbFunc = triggeredElement.data( 'cb-func' );

			// On récupères les "data" sur l'élement en tant qu'args.
			triggeredElement.get_data( function( data ) {
				window.digirisk[cbObject][cbFunc]( triggeredElement, event, data );
			} );
		}
	}
};

window.digirisk.popup.stop = function( event ) {
	event.stopPropagation();
};

window.digirisk.popup.close = function( event ) {
	jQuery( '.popup:not(.no-close)' ).removeClass( 'active' );
	jQuery( '.digi-popup:not(.no-close)' ).removeClass( 'active' );
};
