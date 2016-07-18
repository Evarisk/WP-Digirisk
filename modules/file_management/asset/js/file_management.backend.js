"use strict"

var file_management = {
  file_frame: undefined,
  element_id: undefined,
  have_thumbnail: undefined,
  object_name: undefined,
  _wpnonce: undefined,

  event: function() {
    jQuery( document ).on( 'click', 'span.wpeo-upload-media, a.wpeo-upload-media', function( event ) { file_management.open_popup( event, jQuery( this ) ); } );
  },

  open_popup: function( event, element ) {
    event.preventDefault();

    file_management.element_id = jQuery( element ).data( 'id' );
    file_management._wpnonce = jQuery( element ).data( 'nonce' );
    file_management.object_name = jQuery( element ).data( 'object-name' );
    file_management.have_thumbnail = jQuery( element ).hasClass( 'wp-digi-element-thumbnail' ) ? true : false;
    wp.media.model.settings.post.id = jQuery( element ).data( 'id' );

    if( jQuery( element ).find( '.wpeo-gallery' ).length == 0 ) {
      if( !file_management.file_frame ) {
        file_management.load_media_upload( element );
      }
      else {
        file_management.open_media_upload();
      }
    }
    else {
      wpeo_gallery.open( element );
    }
  },

  load_media_upload: function( element ) {
    file_management.file_frame = wp.media.frames.file_frame = wp.media( {
      title: jQuery( element ).data( 'uploader_title' ),
      button: {
        text: jQuery( element ).data( 'uploader_button_text' ),
      },
      multiple: false
    } );
    file_management.file_frame.on( "select", function() { file_management.selected_file( element ); } );
    file_management.open_media_upload();
  },

  open_media_upload: function() {
    file_management.file_frame.open();
    return;
  },

  selected_file: function( element ) {
    var selected_file = file_management.file_frame.state().get( 'selection' );
    var selected_JSON = undefined;
    var selected_file_id = undefined;
    selected_file.map( function( attachment ) {
      selected_JSON = attachment.toJSON();
      selected_file_id = attachment.id;
    } );

    if ( file_management.element_id == 0 ) {
      file_management.display_attachment( selected_JSON, element );
    }
    else {
      file_management.associate_file( selected_file_id );
    }
  },

  display_attachment: function( selected_JSON, element ) {
    jQuery( element ).find( 'img' ).attr( 'src', selected_JSON.url ).show();
    jQuery( element ).find( 'i' ).hide();
    jQuery( element ).find( 'input[name="file_id"]' ).val( selected_JSON.id );
  },

  associate_file( selected_file_id ) {
    var data = {
      action: "eo_associate_file",
      file_id: selected_file_id,
      _wpnonce: file_management._wpnonce,
      element_id: file_management.element_id,
      object_name: file_management.object_name,
      thumbnail: file_management.have_thumbnail,
    };

    jQuery.post( ajaxurl, data, function( response ) {
      jQuery( 'span.wpeo-upload-media[data-id="'+ file_management.element_id + '"]' ).replaceWith( response.data.template );
    });
  }
};

//
// jQuery( document ).ready( function( ){       // The click event for the gallery manage button
// 	wpeo_gallery.event();
//
// 	// Uploading files
// 	var file_frame;
// 	var jButton = null;
//
// 	jQuery( document ).on( "click", ".wpeo-upload-media", function( e ) {
// 		e.preventDefault();
//
// 		if ( jQuery( this ).find( ' > i' ).length > 0 ) {
// 			jButton = jQuery( this );
// 	//		jQuery( this ).closest( '.wp-digi-workunit-sheet' ).addClass( 'wp-digi-bloc-loading' );
// 			have_thumbnail = jButton.hasClass( 'wp-digi-element-thumbnail' ) ? true : false;
// 			type = ( undefined != jButton.data( "type" ) ? jButton.data( "type" ) : "" );
//
// 		    // If the media frame already exists, reopen it.
// 		    if ( file_frame ) {
// 		      // Open frame
// 		    	file_frame.open();
// 		      return;
// 		    }
// 		    else {
// 		    	// Set the wp.media post id so the uploader grabs the ID we want when initialised
// 		    	wp.media.model.settings.post.id = jQuery( this ).data( 'id' );
// 		    }
//
// 		    // Create the media frame.
// 		    file_frame = wp.media.frames.file_frame = wp.media({
// 		    	title: jQuery( this ).data( 'uploader_title' ),
// 		    	button: {
// 		    		text: jQuery( this ).data( 'uploader_button_text' ),
// 		    	},
// 		    	multiple: false
// 		    });
//
//
// 		    // When an image is selected, run a callback.
//
//
// 		    // Finally, open the modal on click
// 		    file_frame.open();
// 			}
// 			else {
//
// 				wpeo_gallery.open( jQuery( this ) );
// 			}
// 	});
//
// 	/** Pagination */
// 	jQuery(document).on('click', '.wpeofiles-paginate a', function(e) {
// 		e.preventDefault();
//
// 		jQuery( this ).closest( "div.wp-digi-bloc-loader" ).addClass( "wp-digi-bloc-loading" );
//
// 		var url = jQuery( this ).attr( 'href' );
// 		var data = {
// 			action: 'wpeofiles-paginate-files',
// 		};
//
// 		jQuery.get(url, data, function(response) {
// 			jQuery('.wpeofiles-pics-container').html( response.template );
// 			jQuery('.wpeofiles-paginate').html( response.paginate_link );
// 			jQuery( '.wpeofiles-pics-container' ).closest( "div.wp-digi-bloc-loader" ).removeClass( "wp-digi-bloc-loading" );
// 		}, 'json' );
// 	});
//
// } );
//
// function update_associate_file_digi_workunit( response, attachment ) {
// 	jQuery( '.wp-digi-workunit-sheet[data-id="' + response.data.workunit_id + '"]' ).replaceWith( response.data.sheet_simple );
// 	jQuery( '.wp-digi-list-workunit .wp-digi-workunit-' + response.data.workunit_id ).replaceWith( response.data.list_item_workunit );
// }
//
// function update_associate_file_digi_risk( response, attachment ) {
// 	if( (response.data != undefined) && (response.data.id != undefined && response.data.id != 0) ) {
// 		jQuery( '.wp-digi-risk-item[data-risk-id=' + response.data.id + '] .wp-digi-risk-thumbnail .wp-post-image' ).attr( 'src', attachment.sizes.full.url );
// 		jQuery( '.wp-digi-risk-item[data-risk-id=' + response.data.id + '] .wp-digi-risk-thumbnail .wp-post-image' ).attr( 'srcset', '' );
//
// 		if ( jQuery( '.wp-digi-risk-item[data-risk-id=' + response.data.id + '] .wp-digi-risk-thumbnail .wp-post-image' ) != undefined ) {
// 			jQuery( '.wp-digi-risk-item[data-risk-id=' + response.data.id + '] .wp-digi-risk-thumbnail ').html( response.data.template );
// 		}
//
// 	}
// 	else {
// 		// Ajout d'un thumbnail sur un risque inexistant
// 		jQuery( '.wp-digi-risk-item-new .wp-digi-risk-thumbnail input[type="hidden"]' ).val( attachment.id );
// 		jQuery( '.wp-digi-risk-item-new .wp-digi-risk-thumbnail i' ).hide();
// 		jQuery( '.wp-digi-risk-item-new .wp-digi-risk-thumbnail .wp-post-image' ).attr( 'src', attachment.sizes.full.url ).show();
// 	}
// }
//
