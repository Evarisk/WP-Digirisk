window.eoxiaJS.digirisk.document = {};

window.eoxiaJS.digirisk.document.init = function() {
	window.eoxiaJS.digirisk.document.event();
};

window.eoxiaJS.digirisk.document.event = function() {
	jQuery( ".wp-digi-societytree-right-container" ).on( "click", "#wpdigi-save-element-sheet", window.eoxiaJS.digirisk.document.save_element_sheet );
	jQuery( ".wp-digi-societytree-right-container" ).on( "click", ".wp-digi-list-document .wp-digi-action-regenerate", window.eoxiaJS.digirisk.document.regenerate_document );
	jQuery( document ).on( 'click', '.wp-digi-doc-pagination a', window.eoxiaJS.digirisk.document.pagination );

};

window.eoxiaJS.digirisk.document.save_element_sheet = function ( event ) {
	event.preventDefault();

	jQuery( this ).addClass( "wp-digi-loading" );


	var options = {
        beforeSubmit:  function( formData, jqForm, options ) {
        },
        success:       function( responseText, statusText, xhr, $form ) {
        	jQuery( this ).removeClass( "wp-digi-loading" );
        	if ( responseText.success ) {
        		if ( undefined !== jQuery( ".wp-digi-global-sheet-content ul.wp-digi-list-document" ).html() ) {
        			jQuery( ".wp-digi-global-sheet-content ul.wp-digi-list-document" ).prepend( responseText.data.output );
        		}
        		else {
        			jQuery( ".wp-digi-global-sheet-tab li.wp-digi-sheet-generation-button" ).click();
        		}
        	}
        	else {

        	}
        },
        dataType: "json",
        resetForm: true,
    };
	jQuery( "#wpdigi-save-element-form" ).ajaxSubmit( options );
};

window.eoxiaJS.digirisk.document.regenerate_document = function ( event ) {
	event.preventDefault();

	var data = {
		action: 'wpdigi_regenerate_document',
		element_id: jQuery( this ).data( 'id' ),
		parent_id: jQuery( this ).data( 'parent-id' ),
		model_name: jQuery( this ).data( 'model'),
		_wpnonce: jQuery( this ).data( 'nonce' ),
	};
	jQuery.post( window.ajaxurl, data, function() {} );
};

window.eoxiaJS.digirisk.document.pagination = function( event ) {
	event.preventDefault();

	var href = jQuery( this ).attr( 'href' ).split( '&' );
	var next_page = href[1].replace('current_page=', '');
	var element_id = href[2].replace('element_id=', '');

	var data = {
		action: 'paginate_document',
		element_id: element_id,
		next_page: next_page
	};

	jQuery.post( window.ajaxurl, data, function( template ) {
		jQuery( '.doc-content' ).replaceWith( template );
	} );
};
