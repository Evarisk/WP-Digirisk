/**
 * Initialise l'objet "gallery" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 1.0
 * @version 6.2.5.0
 */
window.digirisk.gallery = {};

window.digirisk.gallery.init = function() {
	window.digirisk.gallery.event();
};

window.digirisk.gallery.event = function() {
	jQuery( document ).on( 'keyup', window.digirisk.gallery.keyup );
	jQuery( document ).on( 'click', '.gallery', function( event ) { event.preventDefault(); return false; } );
	jQuery( document ).on( 'click', '.gallery .navigation .prev', window.digirisk.gallery.prevPicture );
	jQuery( document ).on( 'click', '.gallery .navigation .next', window.digirisk.gallery.nextPicture );
	jQuery( document ).on( 'click', '.gallery .close', window.digirisk.gallery.close );
};

window.digirisk.gallery.keyup = function( event ) {
	if ( 37 === event.keyCode ) {
		window.digirisk.gallery.prevPicture();
	} else if ( 39 === event.keyCode ) {
		window.digirisk.gallery.nextPicture();
	} else if ( 27 === event.keyCode ) {
		jQuery( '.gallery .close' ).click();
	}
};

window.digirisk.gallery.open = function( element, elementId, type ) {
	var data = {
		action: 'load_gallery',
		id: elementId,
		type: type
	};

	element.addClass( 'loading' );

	jQuery.post( ajaxurl, data, function( response ) {
		element.removeClass( 'loading' );
		jQuery( '.digirisk-wrap' ).append( response.data.view );
	});
};

window.digirisk.gallery.prevPicture = function( event ) {
	if ( jQuery( '.gallery .image-list li.current' ).prev().length <= 0 ) {
		jQuery( '.gallery .image-list li.current' ).toggleClass( 'current hidden' );
		jQuery( '.gallery .image-list li:last' ).toggleClass( 'hidden current' );
	}	else {
		jQuery( '.gallery .image-list li.current' ).toggleClass( 'current hidden' ).prev().toggleClass( 'hidden current' );
	}

	jQuery( '.gallery .edit-thumbnail-id' ).attr( 'data-thumbnail-id', jQuery( '.gallery .current' ).attr( 'data-id' ) );
};

window.digirisk.gallery.nextPicture = function( event ) {
	if ( jQuery( '.gallery .image-list li.current' ).next().length <= 0 ) {
		jQuery( '.gallery .image-list li.current' ).toggleClass( 'current hidden' );
		jQuery( '.gallery .image-list li:first' ).toggleClass( 'hidden current' );
	} else {
		jQuery( '.gallery .image-list li.current' ).toggleClass( 'current hidden' ).next().toggleClass( 'hidden current' );
	}

	jQuery( '.gallery .edit-thumbnail-id' ).attr( 'data-thumbnail-id', jQuery( '.gallery .current' ).attr( 'data-id' ) );
};

window.digirisk.gallery.close = function( event ) {
	jQuery( '.gallery' ).remove();
};

/**
 * Le callback en cas de réussite à la requête Ajax "dessociate_file".
 * Remplaces les boutons pour ouvrir la popup "galerie"
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.5.0
 */
window.digirisk.gallery.dessociatedFileSuccess = function( element, response ) {
	if ( response.data.closePopup ) {
		jQuery( '.gallery' ).remove();
	}

	jQuery( '.gallery .image-list .current' ).remove();
	jQuery( '.gallery .prev' ).click();
	jQuery( '.main-container .main-header .unit-header .media img' ).replaceWith( response.data.view );
	jQuery( '.navigation-container span[data-id="' + response.data.elementId + '"] img' ).replaceWith( response.data.view );
	jQuery( '.navigation-container .workunit-list span[data-id="' + response.data.elementId + '"] img' ).replaceWith( response.data.view );
};

/**
 * Le callback en cas de réussite à la requête Ajax "eo_set_thumbnail".
 * Remplaces les boutons pour ouvrir la popup "galerie"
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.5.0
 */
window.digirisk.gallery.successfulSetThumbnail = function( element, response ) {
	jQuery( '.main-container .main-header .unit-header .media img' ).replaceWith( response.data.template );
	jQuery( '.navigation-container span[data-id="' + response.data.elementId + '"] img' ).replaceWith( response.data.template );
	jQuery( '.navigation-container .workunit-list span[data-id="' + response.data.elementId + '"] img' ).replaceWith( response.data.template );
};
