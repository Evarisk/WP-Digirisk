"use strict";

var wpeo_gallery = {
	$: undefined,
	event: function( $ ) {
		wpeo_gallery.$ = $;

		wpeo_gallery.$( document ).on( 'keyup', function( event ) { wpeo_gallery.keyup( event, wpeo_gallery.$( this ) ); } );
		wpeo_gallery.$( document ).on( 'click', '.wpeo-gallery', function( event ) { event.preventDefault(); return false; } );
		wpeo_gallery.$( document ).on( 'click', '.wpeo-gallery .prev', function( event ) { wpeo_gallery.prev( event, wpeo_gallery.$( this ) ); } );
		wpeo_gallery.$( document ).on( 'click', '.wpeo-gallery .next', function( event ) { wpeo_gallery.next( event, wpeo_gallery.$( this ) ); } );
		wpeo_gallery.$( document ).on( 'click', '.wpeo-gallery .set-as-thumbnail', function( event ) { wpeo_gallery.set_thumbnail( event, wpeo_gallery.$( this ) ); } );
		wpeo_gallery.$( document ).on( 'click', '.wpeo-gallery .close', function( event ) { wpeo_gallery.close( event ); } );

	},

	keyup: function( event, element ) {
		if ( event.keyCode == 37 ) {
			wpeo_gallery.$( '.wpeo-gallery .prev' ).click();
		}
		else if ( event.keyCode == 39 ) {
			wpeo_gallery.$( '.wpeo-gallery .next' ).click();
		}
		else if ( event.keyCode == 27 ) {
			wpeo_gallery.$( '.wpeo-gallery .close' ).click();
		}
	},

	open: function( element ) {
		wpeo_gallery.$( element ).find( '.wpeo-gallery' ).show();
	},

	prev: function( event, element ) {
		event.preventDefault();
		if ( wpeo_gallery.$( element ).closest( 'div' ).find( '.image-list li.current').prev().length <= 0 ) {
			wpeo_gallery.$( element ).closest( 'div' ).find( '.image-list li.current' ).toggleClass( 'current hidden' );
			wpeo_gallery.$( element ).closest( 'div' ).find( '.image-list li:last' ).toggleClass( 'hidden current' );
		}
		else {
			wpeo_gallery.$( element ).closest( 'div' ).find( '.image-list li.current' ).toggleClass( 'current hidden' ).prev().toggleClass( 'hidden current' );
		}
	},

	next: function( event, element ) {
		event.preventDefault();

		if ( wpeo_gallery.$( element ).closest( 'div' ).find( '.image-list li.current').next().length <= 0 ) {
			wpeo_gallery.$( element ).closest( 'div' ).find( '.image-list li.current' ).toggleClass( 'current hidden' );
			wpeo_gallery.$( element ).closest( 'div' ).find( '.image-list li:first' ).toggleClass( 'hidden current' );
		}
		else {
			wpeo_gallery.$( element ).closest( 'div' ).find( '.image-list li.current' ).toggleClass( 'current hidden' ).next().toggleClass( 'hidden current' );
		}
	},

	set_thumbnail: function( event, element ) {
		var data = {
			action: 'eo_set_thumbnail',
			element_id: wpeo_gallery.$( element ).closest( 'div' ).data( 'id' ),
			thumbnail_id: wpeo_gallery.$( element ).closest( 'div' ).find( 'li.current' ).data( 'id' ),
		};

		wpeo_gallery.$.post( window.ajaxurl, data, function( response ) {
        wpeo_gallery.$( 'span.wpeo-upload-media[data-id="'+ window.file_management.element_id + '"]' ).find( '.wp-post-image' ).replaceWith( response.data.template );
		} );
	},

	close: function( event ) {
		wpeo_gallery.$( '.wpeo-gallery' ).hide();
	}
};
