"use strict"

var wpeo_gallery = {
	event: function() {
		jQuery( document ).on( 'keyup', function( event ) { wpeo_gallery.keyup( event, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wpeo-gallery', function( event ) { event.preventDefault; return false; } );
		jQuery( document ).on( 'click', '.wpeo-gallery .prev', function( event ) { wpeo_gallery.prev( event, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wpeo-gallery .next', function( event ) { wpeo_gallery.next( event, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wpeo-gallery .set-as-thumbnail', function( event ) { wpeo_gallery.set_thumbnail( event, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wpeo-gallery .close', function( event ) { wpeo_gallery.close( event ); } );

	},

	keyup: function( event, element ) {
		if ( event.keyCode == 37 ) {
			jQuery( '.wpeo-gallery .prev' ).click();
		}
		else if ( event.keyCode == 39 ) {
			jQuery( '.wpeo-gallery .next' ).click();
		}
		else if ( event.keyCode == 27 ) {
			jQuery( '.wpeo-gallery .close' ).click();
		}
	},

	open: function( element ) {
		jQuery( element ).find( '.wpeo-gallery' ).show();
	},

	prev: function( event, element ) {
		event.preventDefault();
		if ( jQuery( element ).closest( 'div' ).find( '.image-list li.current').prev().length <= 0 ) {
			jQuery( element ).closest( 'div' ).find( '.image-list li.current' ).toggleClass( 'current hidden' );
			jQuery( element ).closest( 'div' ).find( '.image-list li:last' ).toggleClass( 'hidden current' );
		}
		else {
			jQuery( element ).closest( 'div' ).find( '.image-list li.current' ).toggleClass( 'current hidden' ).prev().toggleClass( 'hidden current' );
		}
	},

	next: function( event, element ) {
		event.preventDefault();

		if ( jQuery( element ).closest( 'div' ).find( '.image-list li.current').next().length <= 0 ) {
			jQuery( element ).closest( 'div' ).find( '.image-list li.current' ).toggleClass( 'current hidden' );
			jQuery( element ).closest( 'div' ).find( '.image-list li:first' ).toggleClass( 'hidden current' );
		}
		else {
			jQuery( element ).closest( 'div' ).find( '.image-list li.current' ).toggleClass( 'current hidden' ).next().toggleClass( 'hidden current' );
		}
	},

	set_thumbnail: function( event, element ) {
		var data = {
			action: 'eo_set_thumbnail',
			element_id: jQuery( element ).closest( 'div' ).data( 'id' ),
			thumbnail_id: jQuery( element ).closest( 'div' ).find( 'li.current' ).data( 'id' ),
		};

		jQuery.post( ajaxurl, data, function( response ) {
        jQuery( 'span.wpeo-upload-media[data-id="'+ file_management.element_id + '"]' ).find( '.wp-post-image' ).replaceWith( response.data.template );
		} );
	},

	close: function( event ) {
		jQuery( '.wpeo-gallery' ).hide();
	}
}
