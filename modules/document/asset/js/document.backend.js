window.digirisk.document = {};

window.digirisk.document.init = function() {
	window.digirisk.document.event();
};

window.digirisk.document.event = function() {
	jQuery( ".wp-digi-societytree-right-container" ).on( "click", "#wpdigi-save-element-sheet", window.digirisk.document.save_element_sheet );
	jQuery( ".wp-digi-societytree-right-container" ).on( "click", ".wp-digi-list-document .wp-digi-action-regenerate", window.digirisk.document.regenerate_document );

};

window.digirisk.document.save_element_sheet = function ( event ) {
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

window.digirisk.document.regenerate_document = function ( event ) {
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



// "use strict";
//
//
// var digi_document = {
// 	$: undefined,
//
// 	event: function( $ ) {
// 		digi_document.$ = $;
// 		digi_document.$( ".wp-digi-societytree-right-container" ).on( "click", "#wpdigi-save-element-sheet", function( event ) { digi_document.save_element_sheet( event, digi_document.$( this ) ); } );
//
// 		digi_document.$( ".wp-digi-societytree-right-container" ).on( "click", ".wp-digi-list-document .wp-digi-action-delete", function( event ) { digi_document.delete_element_sheet( event, digi_document.$( this ) ); } );
// 		digi_document.$( document ).on( 'click', '.wp-digi-doc-pagination a', function( event ) { digi_document.pagination( event, digi_document.$( this ) ); } );
// 	},
//
//
// 	regenerate_document: function ( event, element ) {
// 		event.preventDefault();
//
// 		var data = {
// 			action: 'wpdigi_regenerate_document',
// 			element_id: jQuery( this ).data( 'id' ),
// 			parent_id: digi_document.$( element ).data( 'parent-id' ),
// 			model_name: digi_document.$( element ).data( 'model'),
// 			_wpnonce: digi_document.$( element ).data( 'nonce' ),
// 		};
// 		digi_document.$.post( window.ajaxurl, data, function() {
//
// 		} );
// 	},
//
// 	delete_element_sheet: function( event, element ) {
// 		event.preventDefault();
//
// 		var data = {
// 			action: 'wpdigi_delete_sheet',
// 			parent_id: digi_document.$( element ).data( 'parent-id' ),
// 			element_id: digi_document.$( element ).data( 'id' ),
// 			global: digi_document.$( element ).data( 'global' ),
// 		};
//
// 		digi_document.$( element ).closest( 'li' ).fadeOut();
//
// 		digi_document.$.post( window.ajaxurl, data, function() {
//
// 		} );
//  	},
//
// 	/**
// 	 * Lancement de l'enregistrement de la fiche de l'unité de travail
// 	 *
// 	 * @param event Evenement appelé pour le lancement de l'action
// 	 * @param element Element sur lequel on intervient
// 	 */
// 	save_element_sheet : function ( event, element ) {
// 		event.preventDefault();
//
// 		var options = {
// 	        beforeSubmit:  function( formData, jqForm, options ) {
// 	        	digi_document.$( element ).addClass( "wp-digi-loading" );
// 	        },
// 	        success:       function( responseText, statusText, xhr, $form ) {
// 	        	digi_document.$( element ).removeClass( "wp-digi-loading" );
// 	        	if ( responseText.success ) {
// 	        		if ( undefined !== digi_document.$( ".wp-digi-global-sheet-content ul.wp-digi-list-document" ).html() ) {
// 	        			digi_document.$( ".wp-digi-global-sheet-content ul.wp-digi-list-document" ).prepend( responseText.data.output );
// 	        		}
// 	        		else {
// 	        			digi_document.$( ".wp-digi-global-sheet-tab li.wp-digi-sheet-generation-button" ).click();
// 	        		}
// 	        	}
// 	        	else {
//
// 	        	}
// 	        },
// 	        dataType: "json",
// 	        resetForm: true,
// 	    };
// 		digi_document.$( "#wpdigi-save-element-form" ).ajaxSubmit( options );
// 	},
//
// 	pagination: function( event, element ) {
// 		event.preventDefault();
//
// 		var href = digi_evaluator.$( element ).attr( 'href' ).split( '&' );
// 		var next_page = href[1].replace('current_page=', '');
// 		var element_id = href[2].replace('element_id=', '');
//
// 		var data = {
// 			action: 'paginate_document',
// 			element_id: element_id,
// 			next_page: next_page
// 		};
//
// 		digi_evaluator.$.post( window.ajaxurl, data, function( template ) {
// 			digi_evaluator.$( '.doc-content' ).replaceWith( template );
// 		} );
// 	}
// };
