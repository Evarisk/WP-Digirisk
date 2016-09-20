"use strict";

var digi_document = {
	$: undefined,

	event: function( $ ) {
		digi_document.$ = $;
		digi_document.$( ".wp-digi-societytree-right-container" ).on( "click", "#wpdigi-save-element-sheet", function( event ) { digi_document.save_element_sheet( event, digi_document.$( this ) ); } );

		digi_document.$( ".wp-digi-societytree-right-container" ).on( "click", ".wp-digi-list-document .wp-digi-action-delete", function( event ) { digi_document.delete_element_sheet( event, digi_document.$( this ) ); } );
		digi_document.$( ".wp-digi-societytree-right-container" ).on( "click", ".wp-digi-list-document .wp-digi-action-regenerate", function( event ) { digi_document.regenerate_document( event, digi_document.$( this ) ); } );

	},


	regenerate_document: function ( event, element ) {
		event.preventDefault();

		var data = {
			action: 'wpdigi_regenerate_document',
			element_id: digi_document.$( element ).data( 'id' ),
			parent_id: digi_document.$( element ).data( 'parent-id' ),
			_wpnonce: digi_document.$( element ).data( 'nonce' ),
		};
		digi_document.$.post( window.ajaxurl, data, function() {

		} );
	},

	delete_element_sheet: function( event, element ) {
		event.preventDefault();

		var data = {
			action: 'wpdigi_delete_sheet',
			parent_id: digi_document.$( element ).data( 'parent-id' ),
			element_id: digi_document.$( element ).data( 'id' ),
			global: digi_document.$( element ).data( 'global' ),
		};

		digi_document.$( element ).closest( 'li' ).fadeOut();

		digi_document.$.post( window.ajaxurl, data, function() {

		} );
 	},

	/**
	 * Lancement de l'enregistrement de la fiche de l'unité de travail
	 *
	 * @param event Evenement appelé pour le lancement de l'action
	 * @param element Element sur lequel on intervient
	 */
	save_element_sheet : function ( event, element ) {
		event.preventDefault();

		var options = {
	        beforeSubmit:  function( formData, jqForm, options ) {
	        	digi_document.$( element ).addClass( "wp-digi-loading" );
	        },
	        success:       function( responseText, statusText, xhr, $form ) {
	        	digi_document.$( element ).removeClass( "wp-digi-loading" );
	        	if ( responseText.success ) {
	        		if ( undefined !== digi_document.$( ".wp-digi-global-sheet-content ul.wp-digi-list-document" ).html() ) {
	        			digi_document.$( ".wp-digi-global-sheet-content ul.wp-digi-list-document" ).prepend( responseText.data.output );
	        		}
	        		else {
	        			digi_document.$( ".wp-digi-global-sheet-tab li.wp-digi-sheet-generation-button" ).click();
	        		}
	        	}
	        	else {

	        	}
	        },
	        dataType: "json",
	        resetForm: true,
	    };
		digi_document.$( "#wpdigi-save-element-form" ).ajaxSubmit( options );
	}
};
