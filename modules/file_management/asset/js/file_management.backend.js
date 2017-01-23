window.digirisk.media = {
  file_frame: undefined,
  element_id: undefined,
  have_thumbnail: undefined,
  object_name: undefined,
  _wpnonce: undefined
};

window.digirisk.media.init = function() {
  window.digirisk.media.event();
};

window.digirisk.media.event = function() {
  jQuery( document ).on( 'click', '.media', window.digirisk.media.open_popup );
};

window.digirisk.media.open_popup = function( event ) {
	var element = jQuery( this );

  event.preventDefault();

  window.digirisk.media.element_id = element.data( 'id' );
  window.digirisk.media._wpnonce = element.data( 'nonce' );
  window.digirisk.media.title = element.data( 'title' );
  window.digirisk.media.object_name = element.data( 'object-name' );
  window.digirisk.media.type = element.data( 'type' );
  window.digirisk.media.action = element.data( 'action' );
  window.digirisk.media.have_thumbnail = element.hasClass( 'wp-digi-element-thumbnail' ) ? true : false;
  window.wp.media.model.settings.post.id = element.data( 'id' );

  if( element.find( '.gallery' ).length === 0 ) {
    window.digirisk.media.load_media_upload( element, element.data( 'id' )  );
  }
  else {
    window.digirisk.gallery.open( element );
  }
};

window.digirisk.media.load_media_upload = function( element, post_id ) {
  if ( !window.digirisk.media.file_frame ) {
    window.digirisk.media.file_frame = new window.wp.media.view.MediaFrame.Post( {
      title: jQuery( element ).data( 'uploader_title' ),
      button: {
        text: jQuery( element ).data( 'uploader_button_text' ),
      },
      multiple: false
    } );
    window.digirisk.media.file_frame.el.className += ' digi-upload-' + post_id;
    window.digirisk.media.file_frame.on( "insert", function() { window.digirisk.media.selected_file( element ); } );
  }

  window.digirisk.media.open_media_upload();
};

window.digirisk.media.open_media_upload = function() {
  window.digirisk.media.file_frame.open();
  return;
};

window.digirisk.media.selected_file = function( element ) {
  var selected_file = window.digirisk.media.file_frame.state().get( 'selection' );
  var selected_JSON;
  var selected_file_id;
  selected_file.map( function( attachment ) {
    selected_JSON = attachment.toJSON();
    selected_file_id = attachment.id;
  } );

  if ( window.digirisk.media.element_id === 0 && window.digirisk.media.action != 'eo_set_model' ) {
    window.digirisk.media.display_attachment( selected_JSON, element );
  }
  else {
    window.digirisk.media.associate_file( selected_file_id );
  }
};

window.digirisk.media.display_attachment = function( selected_JSON, element ) {
  jQuery( element ).find( 'img' ).attr( 'src', selected_JSON.url ).show();
  jQuery( element ).find( 'i' ).hide();
  jQuery( element ).find( 'input.input-file-image' ).val( selected_JSON.id );
};

window.digirisk.media.associate_file = function( selectedFileId ) {
	if ( 'eo_set_model' === window.digirisk.media.action ) {
		jQuery( '.upload[data-type="' + window.digirisk.media.type + '"]' ).addClass( 'loading' );
	} else {
		jQuery( 'span.media[data-id="' + window.digirisk.media.element_id + '"]' ).addClass( 'loading' );
	}

  var data = {
    action: window.digirisk.media.action,
    file_id: selectedFileId,
    _wpnonce: window.digirisk.media._wpnonce,
    title: window.digirisk.media.title,
    type: window.digirisk.media.type,
    element_id: window.digirisk.media.element_id,
    object_name: window.digirisk.media.object_name,
    thumbnail: window.digirisk.media.have_thumbnail,
  };

  jQuery.post( window.ajaxurl, data, function( response ) {
    if ( response.data.type == 'set_model' ) {
      jQuery( '#digi-handle-model' ).html( response.data.template );
    }
    else {
      jQuery( 'span.media[data-id="'+ window.digirisk.media.element_id + '"]' ).replaceWith( response.data.template );
    }
  });
};
