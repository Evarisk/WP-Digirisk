window.digirisk.gallery = {};

window.digirisk.gallery.init = function() {
	window.digirisk.gallery.event();
};

window.digirisk.gallery.event = function() {
	jQuery( document ).on( 'keyup', window.digirisk.gallery.keyup );
	jQuery( document ).on( 'click', '.gallery', function( event ) { event.preventDefault(); return false; } );
	jQuery( document ).on( 'click', '.gallery .prev', window.digirisk.gallery.prev );
	jQuery( document ).on( 'click', '.gallery .next', window.digirisk.gallery.next );
	jQuery( document ).on( 'click', '.gallery .set-as-thumbnail', window.digirisk.gallery.set_thumbnail );
	jQuery( document ).on( 'click', '.gallery .close', window.digirisk.gallery.close );
};

window.digirisk.gallery.keyup = function( event ) {
	if ( event.keyCode == 37 ) {
		jQuery( '.gallery .prev' ).click();
	}
	else if ( event.keyCode == 39 ) {
		jQuery( '.gallery .next' ).click();
	}
	else if ( event.keyCode == 27 ) {
		jQuery( '.gallery .close' ).click();
	}
};

window.digirisk.gallery.open = function( element ) {
	element.find( '.gallery' ).show();
};

window.digirisk.gallery.prev = function( event ) {
	event.preventDefault();
	if ( jQuery( this ).closest( 'div' ).find( '.image-list li.current' ).prev().length <= 0 ) {
		jQuery( this ).closest( 'div' ).find( '.image-list li.current' ).toggleClass( 'current hidden' );
		jQuery( this ).closest( 'div' ).find( '.image-list li:last' ).toggleClass( 'hidden current' );
	}	else {
		jQuery( this ).closest( 'div' ).find( '.image-list li.current' ).toggleClass( 'current hidden' ).prev().toggleClass( 'hidden current' );
	}

	jQuery( '.gallery .wp-digi-bton-third' ).attr( 'data-thumbnail-id', jQuery( '.gallery .current' ).attr( 'data-id' ) );
};

window.digirisk.gallery.next = function( event ) {
	event.preventDefault();

	if ( jQuery( this ).closest( 'div' ).find( '.image-list li.current' ).next().length <= 0 ) {
		jQuery( this ).closest( 'div' ).find( '.image-list li.current' ).toggleClass( 'current hidden' );
		jQuery( this ).closest( 'div' ).find( '.image-list li:first' ).toggleClass( 'hidden current' );
	} else {
		jQuery( this ).closest( 'div' ).find( '.image-list li.current' ).toggleClass( 'current hidden' ).next().toggleClass( 'hidden current' );
	}

	jQuery( '.gallery .wp-digi-bton-third' ).attr( 'data-thumbnail-id', jQuery( '.gallery .current' ).attr( 'data-id' ) );
};

window.digirisk.gallery.set_thumbnail = function( event ) {
	var data = {
		action: 'eo_set_thumbnail',
		element_id: jQuery( this ).closest( 'div' ).data( 'id' ),
		thumbnail_id: jQuery( this ).closest( 'div' ).find( 'li.current' ).data( 'id' )
	};

	jQuery.post( window.ajaxurl, data, function( response ) {
      jQuery( 'span.wpeo-upload-media[data-id="'+ response.data.element_id + '"]' ).find( '.wp-post-image' ).replaceWith( response.data.template );
			jQuery( '.gallery' ).hide();
	} );
};

window.digirisk.gallery.close = function( event ) {
	jQuery( '.gallery' ).hide();
};

window.digirisk.gallery.dessociate_file_success = function( element, response ) {
	jQuery( '.gallery .image-list .current' ).remove();
	jQuery( '.gallery .prev' ).click();
	jQuery( 'span.wpeo-upload-media[data-id="'+ response.data.element_id + '"]' ).replaceWith( response.data.view );
};
