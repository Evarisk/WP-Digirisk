/**
 * Initialise l'objet "upload" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 0.1.0-alpha
 * @version 1.0.0
 * @copyright 2017
 * @author Jimmy Latour <jimmy@eoxia.com>
 */

window.eoxiaJS.upload = {};

/**
 * Keep the button in memory.
 *
 * @type {Object}
 */
window.eoxiaJS.upload.currentButton;

/**
 * Keep the media frame in memory.
 * @type {Object}
 */
window.eoxiaJS.upload.mediaFrame;

/**
 * Keep the selected media in memory.
 * @type {Object}
 */
window.eoxiaJS.upload.selectedInfos = {
	JSON: undefined,
	fileID: undefined
};

/**
 * Init func.
 *
 * @return void
 *
 * @since 0.1.0-alpha
 * @version 0.1.0-alpha
 */
window.eoxiaJS.upload.init = function() {
	window.eoxiaJS.upload.event();
};

/**
 * Event func.
 *
 * @return void
 *
 * @since 0.1.0-alpha
 * @version 1.0.0
 */
window.eoxiaJS.upload.event = function() {
	jQuery( document ).on( 'click', '.media:not(.loading), .upload:not(.loading)', window.eoxiaJS.upload.openPopup );
	jQuery( document ).on( 'click', '.media-modal-content, .media-toolbar, .media-modal-close, .media-button-insert', function( event ) { event.stopPropagation(); } );
};

/**
 * Open the media frame from WordPress or the custom gallery.
 *
 * @param  {MouseEvent} event  The mouse state.
 * @return void
 *
 * @since 0.1.0-alpha
 * @version 1.0.0
 */
window.eoxiaJS.upload.openPopup = function( event ) {
	if ( window.eoxiaJS.upload.currentButton ) {
		var tmp = window.eoxiaJS.upload.currentButton;
	}
	window.eoxiaJS.upload.currentButton = jQuery( this );

	if ( tmp ) {
		window.eoxiaJS.upload.currentButton[0].initialButton = tmp;
	}

	event.preventDefault();

	if ( jQuery( this ).hasClass( 'no-file' ) || jQuery( this ).is( "a" ) ) {
		window.eoxiaJS.upload.openMediaFrame();
	} else {
		window.eoxiaJS.gallery.open();
	}
};

/**
 * Open the media frame from WordPress.
 *
 * @return void
 *
 * @since 0.1.0-alpha
 * @version 1.0.0
 */
window.eoxiaJS.upload.openMediaFrame = function() {
	window.eoxiaJS.upload.mediaFrame = new window.wp.media.view.MediaFrame.Post({
		multiple: false,
		library: {
			type: window.eoxiaJS.upload.currentButton.data( 'mime-type' )
		}
	}).open();
	console.log(window.eoxiaJS.upload.mediaFrame );
	window.eoxiaJS.upload.mediaFrame.on( 'insert', function() { window.eoxiaJS.upload.selectedFile(); } );
};

/**
 * Get the media selected and call associateFile.
 *
 * @return void
 *
 * @since 0.1.0-alpha
 * @version 1.0.0
 */
window.eoxiaJS.upload.selectedFile = function() {
	window.eoxiaJS.upload.mediaFrame.state().get( 'selection' ).map( function( attachment ) {
		window.eoxiaJS.upload.selectedInfos.JSON = attachment.toJSON();
		window.eoxiaJS.upload.selectedInfos.id = attachment.id;
	} );
	window.eoxiaJS.upload.associateFile();
};

/**
 * Make request for associate file
 *
 * @return void
 *
 * @since 0.1.0-alpha
 * @version 1.0.0
 */
window.eoxiaJS.upload.associateFile = function() {
	var data = {
		action: 'eo_upload_associate_file',
		file_id: window.eoxiaJS.upload.selectedInfos.id,
		_wpnonce: window.eoxiaJS.upload.currentButton.attr( 'data-nonce' ),
	};
	var key = '';
	window.eoxiaJS.upload.currentButton.get_data( function( attrData ) {
		for ( key in attrData ) {
			data[key] = attrData[key];
		}
	} );
	window.eoxiaJS.loader.display( window.eoxiaJS.upload.currentButton  );

	jQuery.post( window.ajaxurl, data, function( response ) {
		window.eoxiaJS.upload.currentButton.removeClass( 'loading' );

		window.eoxiaJS.upload.refreshButton( response.data );

		if ( 'box' === response.data.display_type && 0 !== response.data.id ) {
			window.eoxiaJS.gallery.open( false );
		}

		window.eoxiaJS.cb( 'eoUploadAssociatedFile', {
			element: window.eoxiaJS.upload.currentButton,
			data: data,
			response: response
		} );
	} );
};

/**
 * Update the view of the button
 *
 * @param  {Object} data Data of button.
 * @return {void}
 *
 * @since 0.1.0-alpha
 * @version 1.0.0
 */
window.eoxiaJS.upload.refreshButton = function( data ) {
	jQuery( window.eoxiaJS.upload.currentButton ).removeClass( 'no-file loading wpeo-loader' );
	if( window.eoxiaJS.upload.currentButton.is( 'a' ) ) {
		window.eoxiaJS.loader.remove( window.eoxiaJS.upload.currentButton );
		window.eoxiaJS.upload.currentButton.closest( 'div' ).find( 'ul li.no-file-attached' ).remove();
		window.eoxiaJS.upload.currentButton.closest( 'div' ).find( 'ul' ).append( data.view );
	} else {
		if ( data.view ) {
			if ( window.eoxiaJS.upload.currentButton.data( 'custom-class' ) ) {
				jQuery( 'span.media[data-id="' + window.eoxiaJS.upload.currentButton.data( 'id' ) + '"].' + window.eoxiaJS.upload.currentButton.data( 'custom-class' ) ).replaceWith( data.view );
			} else {
				jQuery( 'span.media[data-id="' + window.eoxiaJS.upload.currentButton.data( 'id' ) + '"]' ).replaceWith( data.view );
			}
		} else if ( data.document_view ) {
			window.eoxiaJS.upload.currentButton.find( '.default' ).replaceWith( data.document_view );
			window.eoxiaJS.upload.currentButton.find( 'input[type="hidden"]' ).val( window.eoxiaJS.upload.selectedInfos.JSON.id );
		} else {
			if ( data.media ) {
				if ( window.eoxiaJS.upload.currentButton[0] && window.eoxiaJS.upload.currentButton[0].initialButton ) {
					window.eoxiaJS.upload.currentButton[0].initialButton.find( 'img' ).replaceWith( data.media );
				}
				window.eoxiaJS.upload.currentButton.find( 'img' ).replaceWith( data.media );
				window.eoxiaJS.upload.currentButton.find( '.default-image.fa-image' ).hide();

				window.eoxiaJS.upload.currentButton.find( 'input[type="hidden"]' ).val( window.eoxiaJS.upload.selectedInfos.JSON.id );
			}
		}
	}
};

window.eoxiaJS.gallery = {};

/**
 * Init func.
 *
 * @return void
 *
 * @since 0.1.0-alpha
 * @version 1.0.0
 */
window.eoxiaJS.gallery.init = function() {
	window.eoxiaJS.gallery.event();
};

/**
 * Event func.
 *
 * @return void
 *
 * @since 0.1.0-alpha
 * @version 1.0.0
 */
window.eoxiaJS.gallery.event = function() {
	jQuery( document ).on( 'keyup', '.wpeo-gallery', window.eoxiaJS.gallery.keyup );
	jQuery( document ).on( 'click', '.wpeo-gallery .modal-footer .button-main', window.eoxiaJS.gallery.close );
	jQuery( document ).on( 'click', '.wpeo-gallery .navigation .prev', window.eoxiaJS.gallery.prevPicture );
	jQuery( document ).on( 'click', '.wpeo-gallery .navigation .next', window.eoxiaJS.gallery.nextPicture );
};

/**
 * Make request for open gallery
 *
 * @return void
 *
 * @since 0.1.0-alpha
 * @version 1.0.0
 */
window.eoxiaJS.gallery.open = function( append = true ) {
	var currentButton = window.eoxiaJS.upload.currentButton;
	var data = {
		action: 'eo_upload_load_gallery'
	};
	var key = '';
	currentButton.get_data( function( attrData ) {
		for ( key in attrData ) {
			data[key] = attrData[key];
		}
	} );

	currentButton.addClass( 'loading' );

	if ( append ) {
		jQuery( '.wpeo-gallery' ).remove();
	} else {
		data['_wpnonce'] = currentButton.closest( '.wpeo-gallery' ).data( 'nonce' );
	}

	jQuery.post( ajaxurl, data, function( response ) {
		if ( append ) {
			jQuery( '#wpwrap' ).append( response.data.view );
		} else {
			jQuery( '.wpeo-gallery' ).replaceWith( response.data.view );
		}
		currentButton.removeClass( 'loading' );
	});
};

/**
 * Next and Previous picture in gallery
 *
 * @param  {KeyEvent} event Keyboard state.
 * @return void
 *
 * @since 0.1.0-alpha
 * @version 1.0.0
 */
window.eoxiaJS.gallery.keyup = function( event ) {
	if ( 37 === event.keyCode ) {
		window.eoxiaJS.gallery.prevPicture();
	} else if ( 39 === event.keyCode ) {
		window.eoxiaJS.gallery.nextPicture();
	} else if ( 27 === event.keyCode ) {
		jQuery( '.wpeo-gallery .modal-close' ).click();
	}
};

/**
 * Close the popup
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @param  {ClickEvent} event L'évènement lors du clic.
 * @return {void}
 */
window.eoxiaJS.gallery.close = function( event ) {
	jQuery( '.wpeo-gallery .modal-close' ).click();
};

/**
 * Prev picture func.
 *
 * @param  {KeyEvent} event Keyboard state.
 * @return void
 *
 * @since 0.1.0-alpha
 * @version 1.0.0
 */
window.eoxiaJS.gallery.prevPicture = function( event ) {
	if ( jQuery( '.wpeo-gallery .image-list li.current' ).prev().length <= 0 ) {
		jQuery( '.wpeo-gallery .image-list li.current' ).toggleClass( 'current hidden' );
		jQuery( '.wpeo-gallery .image-list li:last' ).toggleClass( 'hidden current' );
	}	else {
		jQuery( '.wpeo-gallery .image-list li.current' ).toggleClass( 'current hidden' ).prev().toggleClass( 'hidden current' );
	}

	jQuery( '.wpeo-gallery .edit-thumbnail-id' ).attr( 'data-file-id', jQuery( '.wpeo-gallery .current' ).attr( 'data-id' ) );

	window.eoxiaJS.gallery.changeURL( jQuery( '.wpeo-gallery .current' ).attr( 'data-id' ) );
	window.eoxiaJS.gallery.checkIsFeaturedMedia( jQuery( '.wpeo-gallery .current' ).attr( 'data-id' ) );
};

/**
 * Next picture func.
 *
 * @param  {KeyEvent} event Keyboard state.
 * @return void
 *
 * @since 0.1.0-alpha
 * @version 0.1.0-alpha
 */
window.eoxiaJS.gallery.nextPicture = function( event ) {
	if ( jQuery( '.wpeo-gallery .image-list li.current' ).next().length <= 0 ) {
		jQuery( '.wpeo-gallery .image-list li.current' ).toggleClass( 'current hidden' );
		jQuery( '.wpeo-gallery .image-list li:first' ).toggleClass( 'hidden current' );
	} else {
		jQuery( '.wpeo-gallery .image-list li.current' ).toggleClass( 'current hidden' ).next().toggleClass( 'hidden current' );
	}

	jQuery( '.wpeo-gallery .edit-thumbnail-id' ).attr( 'data-file-id', jQuery( '.wpeo-gallery .current' ).attr( 'data-id' ) );

	window.eoxiaJS.gallery.changeURL( jQuery( '.wpeo-gallery .current' ).attr( 'data-id' ) );
	window.eoxiaJS.gallery.checkIsFeaturedMedia( jQuery( '.wpeo-gallery .current' ).attr( 'data-id' ) );
};

/**
 * Change edit link URL with the current file ID.
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @param  {integer} fileID The current file ID.
 * @return {void}
 */
window.eoxiaJS.gallery.changeURL = function( fileID ) {
	var href = jQuery( '.wpeo-gallery .edit-link' ).attr( 'href' );
	var tmpHREF = href.split( '?' );
	href = tmpHREF[0] += "?item=" + fileID + "&mode=edit";
	jQuery( '.wpeo-gallery .edit-link' ).attr( 'href', href );
};

window.eoxiaJS.gallery.checkIsFeaturedMedia = function( fileID ) {
	var mainFeaturedMediaID = jQuery( '.wpeo-gallery input.main-thumbnail-id' ).val();

	if ( mainFeaturedMediaID == fileID ) {
		jQuery( '.wpeo-gallery .featured-thumbnail i' ).removeClass( 'fa-star-o' );
		jQuery( '.wpeo-gallery .featured-thumbnail i' ).addClass( 'fa-star' );
	} else {
		jQuery( '.wpeo-gallery .featured-thumbnail i' ).removeClass( 'fa-star' );
		jQuery( '.wpeo-gallery .featured-thumbnail i' ).addClass( 'fa-star-o' );
	}
}

/**
 * Le callback en cas de réussite à la requête Ajax "dissociate_file".
 * Remplaces les boutons pour ouvrir la popup "galerie"
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.1.0-alpha
 * @version 1.0.0
 */
window.eoxiaJS.gallery.dissociatedFileSuccess = function( element, response ) {
	if ( response.data.close_popup ) {
		jQuery( '.wpeo-gallery' ).remove();
	} else {
		jQuery( '.wpeo-gallery .image-list .current' ).remove();
		jQuery( '.wpeo-gallery .next' ).click();
		jQuery( '.wpeo-gallery input.main-thumbnail-id' ).val( jQuery( '.wpeo-gallery .current' ).attr( 'data-id' ) );
		window.eoxiaJS.gallery.checkIsFeaturedMedia( jQuery( '.wpeo-gallery .current' ).attr( 'data-id' ) );
	}
	window.eoxiaJS.upload.refreshButton( response.data );

};

/**
 * Le callback en cas de réussite à la requête Ajax "eo_set_thumbnail".
 * Remplaces les boutons pour ouvrir la popup "galerie"
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.1.0-alpha
 * @version 0.1.0-alpha
 */
window.eoxiaJS.gallery.successfulSetThumbnail = function( element, response ) {
	window.eoxiaJS.upload.refreshButton( response.data );
	jQuery( '.wpeo-gallery input.main-thumbnail-id' ).val( response.data.file_id );
	window.eoxiaJS.gallery.checkIsFeaturedMedia( response.data.file_id );
};
