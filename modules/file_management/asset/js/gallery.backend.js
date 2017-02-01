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
		jQuery( '.gallery .navigation .prev' ).click();
	} else if ( 39 === event.keyCode ) {
		jQuery( '.gallery .navigation .next' ).click();
	} else if ( 27 === event.keyCode ) {
		jQuery( '.gallery .close' ).click();
	}
};

window.digirisk.gallery.open = function( element ) {
	element.find( '.gallery' ).show();
};

window.digirisk.gallery.prevPicture = function( event ) {
	// event.preventDefault();
	//
	// if ( jQuery( this ).closest( 'div' ).find( '.image-list li.current' ).prev().length <= 0 ) {
	// 	jQuery( this ).closest( 'div' ).find( '.image-list li.current' ).toggleClass( 'current hidden' );
	// 	jQuery( this ).closest( 'div' ).find( '.image-list li:last' ).toggleClass( 'hidden current' );
	// }	else {
	// 	jQuery( this ).closest( 'div' ).find( '.image-list li.current' ).toggleClass( 'current hidden' ).prev().toggleClass( 'hidden current' );
	// }

	console.log('prev');

	// jQuery( '.gallery .edit-thumbnail-id' ).attr( 'data-thumbnail-id', jQuery( '.gallery .current' ).attr( 'data-id' ) );
};

window.digirisk.gallery.nextPicture = function( event ) {
	event.preventDefault();

	if ( jQuery( this ).closest( 'div' ).find( '.image-list li.current' ).next().length <= 0 ) {
		jQuery( this ).closest( 'div' ).find( '.image-list li.current' ).toggleClass( 'current hidden' );
		jQuery( this ).closest( 'div' ).find( '.image-list li:first' ).toggleClass( 'hidden current' );
	} else {
		jQuery( this ).closest( 'div' ).find( '.image-list li.current' ).toggleClass( 'current hidden' ).next().toggleClass( 'hidden current' );
	}

	jQuery( '.gallery .edit-thumbnail-id' ).attr( 'data-thumbnail-id', jQuery( '.gallery .current' ).attr( 'data-id' ) );
};

window.digirisk.gallery.close = function( event ) {
	jQuery( '.gallery' ).hide();
};

window.digirisk.gallery.dessociate_file_success = function( element, response ) {
	jQuery( '.gallery .image-list .current' ).remove();
	jQuery( '.gallery .prev' ).click();
	jQuery( 'span.wpeo-upload-media[data-id="' + response.data.element_id + '"]' ).replaceWith( response.data.view );
};
