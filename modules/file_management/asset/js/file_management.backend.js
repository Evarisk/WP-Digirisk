"use strict";

var file_management = {
  file_frame: undefined,
  element_id: undefined,
  have_thumbnail: undefined,
  object_name: undefined,
  _wpnonce: undefined,
	$: undefined,

  event: function( $ ) {
		file_management.$ = $;

    file_management.$( document ).on( 'click', 'span.wpeo-upload-media, a.wpeo-upload-media', function( event ) { file_management.open_popup( event, file_management.$( this ) ); } );
  },

  open_popup: function( event, element ) {
    event.preventDefault();

    file_management.element_id = file_management.$( element ).data( 'id' );
    file_management._wpnonce = file_management.$( element ).data( 'nonce' );
    file_management.object_name = file_management.$( element ).data( 'object-name' );
    file_management.have_thumbnail = file_management.$( element ).hasClass( 'wp-digi-element-thumbnail' ) ? true : false;
    window.wp.media.model.settings.post.id = file_management.$( element ).data( 'id' );
    if( file_management.$( element ).find( '.wpeo-gallery' ).length === 0 ) {
      file_management.load_media_upload( element, file_management.$( element ).data( 'id' )  );
    }
    else {
      window.wpeo_gallery.open( element );
    }
  },

  load_media_upload: function( element, post_id ) {
    file_management.file_frame = window.wp.media.frames.file_frame = window.wp.media( {
      title: file_management.$( element ).data( 'uploader_title' ),
      button: {
        text: file_management.$( element ).data( 'uploader_button_text' ),
      },
      multiple: false
    } );
		file_management.file_frame.el.className += ' digi-upload-' + post_id;
    file_management.file_frame.on( "select", function() { file_management.selected_file( element ); } );
    file_management.open_media_upload();
  },

  open_media_upload: function() {
    file_management.file_frame.open();
    return;
  },

  selected_file: function( element ) {
    var selected_file = file_management.file_frame.state().get( 'selection' );
    var selected_JSON;
    var selected_file_id;
    selected_file.map( function( attachment ) {
      selected_JSON = attachment.toJSON();
      selected_file_id = attachment.id;
    } );

    if ( file_management.element_id === 0 ) {
      file_management.display_attachment( selected_JSON, element );
    }
    else {
      file_management.associate_file( selected_file_id );
    }
  },

  display_attachment: function( selected_JSON, element ) {
    file_management.$( element ).find( 'img' ).attr( 'src', selected_JSON.url ).show();
    file_management.$( element ).find( 'i' ).hide();
    file_management.$( element ).find( 'input[name="file_id"]' ).val( selected_JSON.id );
  },

  associate_file: function( selected_file_id ) {

		file_management.$( 'span.wpeo-upload-media[data-id="'+ file_management.element_id + '"]' ).addClass( 'wp-digi-bloc-loading' );
    var data = {
      action: "eo_associate_file",
      file_id: selected_file_id,
      _wpnonce: file_management._wpnonce,
      element_id: file_management.element_id,
      object_name: file_management.object_name,
      thumbnail: file_management.have_thumbnail,
    };

    file_management.$.post( window.ajaxurl, data, function( response ) {
      file_management.$( 'span.wpeo-upload-media[data-id="'+ file_management.element_id + '"]' ).replaceWith( response.data.template );
    });
  }
};
