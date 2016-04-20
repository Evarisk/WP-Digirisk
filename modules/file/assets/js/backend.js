jQuery( document ).ready( function( ){       // The click event for the gallery manage button
	wpeo_gallery.event();

	// Uploading files
	var file_frame;
	var jButton = null;

	jQuery( document ).on( "click", ".wpeo-upload-media", function( e ) {
		e.preventDefault();

		if ( jQuery( this ).find( ' > i' ).length > 0 ) {
			jButton = jQuery( this );
	//		jQuery( this ).closest( '.wp-digi-workunit-sheet' ).addClass( 'wp-digi-bloc-loading' );
			have_thumbnail = jButton.hasClass( 'wp-digi-element-thumbnail' ) ? true : false;
			type = ( undefined != jButton.data( "type" ) ? jButton.data( "type" ) : "" );

		    // If the media frame already exists, reopen it.
		    if ( file_frame ) {
		      // Open frame
		    	file_frame.open();
		      return;
		    }
		    else {
		    	// Set the wp.media post id so the uploader grabs the ID we want when initialised
		    	wp.media.model.settings.post.id = jQuery( this ).data( 'id' );
		    }

		    // Create the media frame.
		    file_frame = wp.media.frames.file_frame = wp.media({
		    	title: jQuery( this ).data( 'uploader_title' ),
		    	button: {
		    		text: jQuery( this ).data( 'uploader_button_text' ),
		    	},
		    	multiple: false
		    });


		    // When an image is selected, run a callback.
		    file_frame.on( 'select', function() {
		    	var selection = file_frame.state().get('selection');
		    	var files_to_associate = new Array;
		    	var list_attachment = undefined;
		    	selection.map( function( attachment ) {
		    		list_attachment = attachment.toJSON();
		    		files_to_associate.push( list_attachment.id );
		    	});

		    	var data = {
		    		action: "wpfile_associate_file_" + type,
		    		_wpnonce: jButton.data( "nonce" ),
		    		files_to_associate: files_to_associate,
		    		element_id: jButton.data( "id" ),
		    		thumbnail: have_thumbnail,
		    	};
		    	jQuery.post( ajaxurl, data, function( response ) {
		    		window['update_associate_file_' + type.replace( '-', '_' ) ]( response, list_attachment );
		    	}, "json");
		    });

		    // Finally, open the modal on click
		    file_frame.open();
			}
			else {

				wpeo_gallery.open( jQuery( this ) );
			}
	});

	/** Pagination */
	jQuery(document).on('click', '.wpeofiles-paginate a', function(e) {
		e.preventDefault();

		jQuery( this ).closest( "div.wp-digi-bloc-loader" ).addClass( "wp-digi-bloc-loading" );

		var url = jQuery( this ).attr( 'href' );
		var data = {
			action: 'wpeofiles-paginate-files',
		};

		jQuery.get(url, data, function(response) {
			jQuery('.wpeofiles-pics-container').html( response.template );
			jQuery('.wpeofiles-paginate').html( response.paginate_link );
			jQuery( '.wpeofiles-pics-container' ).closest( "div.wp-digi-bloc-loader" ).removeClass( "wp-digi-bloc-loading" );
		}, 'json' );
	});

} );

function update_associate_file_digi_workunit( response, attachment ) {
	jQuery( '.wp-digi-workunit-sheet[data-id="' + response.data.workunit_id + '"]' ).replaceWith( response.data.sheet_simple );
	jQuery( '.wp-digi-list-workunit .wp-digi-workunit-' + response.data.workunit_id ).replaceWith( response.data.list_item_workunit );
}

function update_associate_file_digi_risk( response, attachment ) {
	if( (response.data != undefined) && (response.data.id != undefined && response.data.id != 0) ) {
		jQuery( '.wp-digi-risk-item[data-risk-id=' + response.data.id + '] .wp-digi-risk-thumbnail .wp-post-image' ).attr( 'src', attachment.sizes.full.url );
		jQuery( '.wp-digi-risk-item[data-risk-id=' + response.data.id + '] .wp-digi-risk-thumbnail .wp-post-image' ).attr( 'srcset', '' );

		if ( jQuery( '.wp-digi-risk-item[data-risk-id=' + response.data.id + '] .wp-digi-risk-thumbnail .wp-post-image' ) != undefined ) {
			jQuery( '.wp-digi-risk-item[data-risk-id=' + response.data.id + '] .wp-digi-risk-thumbnail ').html( response.data.template );
		}

	}
	else {
		// Ajout d'un thumbnail sur un risque inexistant
		jQuery( '.wp-digi-risk-item-new .wp-digi-risk-thumbnail input[type="hidden"]' ).val( attachment.id );
		jQuery( '.wp-digi-risk-item-new .wp-digi-risk-thumbnail i' ).hide();
		jQuery( '.wp-digi-risk-item-new .wp-digi-risk-thumbnail .wp-post-image' ).attr( 'src', attachment.sizes.full.url ).show();
	}
}

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
		jQuery( element ).parent().find( '.wpeo-gallery' ).show();
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
			action: 'wpeo_file_set_thumbnail',
			element_id: jQuery( element ).closest( 'div' ).data( 'id' ),
			thumbnail_id: jQuery( element ).closest( 'div' ).find( 'li.current' ).data( 'id' ),
		};

		jQuery.post( ajaxurl, data, function( response ) {
				jQuery( element ).closest( '.wp-digi-element-thumbnail' ).find( '.wp-post-image' ).replaceWith( response.data.template );
		} );
	},

	close: function( event ) {
		jQuery( '.wpeo-gallery' ).hide();
	}
}
