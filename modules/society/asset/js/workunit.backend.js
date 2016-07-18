"use strict"

var digi_workunit = {

	/**
	 * Définition de la liste des actions possibles
	 */
	event: function() {
		/**	Quand on demande l'ajout d'une unité de travail	*/
		jQuery( ".wp-digi-societytree-left-container" ).on( "keypress", "input[name='workunit[title]']", function( event) { digi_workunit.call_create_workunit( event ); } );
		jQuery( ".wp-digi-societytree-left-container" ).on( "click", ".wp-digi-new-workunit-action", function( event ){ digi_workunit.create_workunit( event, jQuery( this ) ); } );

		/**	Quand on demande la suppression d'une unité de travail	*/
		jQuery( document ).on( 'click', '.wp-digi-list-workunit .wp-digi-action-delete', function( event ) { digi_workunit.delete_workunit( event, jQuery( this ) ); } );

		jQuery( ".wp-digi-societytree-right-container" ).on( "click", "#wpdigi-save-element-sheet", function( event ) { digi_workunit.save_element_sheet( event, jQuery( this ) ); } );
		jQuery( ".wp-digi-societytree-right-container" ).on( "click", ".wp-digi-list-document .wp-digi-action-delete", function( event ) { digi_workunit.delete_element_sheet( event, jQuery( this ) ); } );

		jQuery( document ).on( 'click', '.wp-digi-sheet-tab-toggle', function() { digi_global.responsive_menu_toggle( jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wp-digi-sheet-tab-responsive-content > li', function() { digi_global.responsive_menu_toggle( jQuery( this ) ); } );
	},

	call_create_workunit: function( event ) {
		if( event.keyCode == 13 ) {
			event.preventDefault();
			jQuery( ".wp-digi-societytree-left-container .wp-digi-new-workunit-action" ).click();
		}
	},

	/**
	 * Création d'une unité de travail au travers du champs en bas de liste
	 *
	 * @param event Evenement appelé pour le lancement de l'action
	 * @param element L'élément cliqué
	 */
	create_workunit: function( event, element ) {
		event.preventDefault();

		jQuery( "#wpdigi-workunit-creation-form" ).ajaxSubmit({
			'dataType': 'json',
			'beforeSubmit' : function( formData, jqForm, options ) {
				jQuery( '.wp-digi-societytree-left-container' ).addClass( "wp-digi-bloc-loading" );
			},
			'success' : function( response, status, xhr, $form ) {
				jQuery( '.wp-digi-societytree-left-container' ).removeClass( "wp-digi-bloc-loading" );
				jQuery( ".wp-digi-list-workunit" ).prepend( response.output );
				jQuery( ".wp-digi-workunit-" + response.element.id + " .wp-digi-global-name" ).click();
			},
		});
	},

	/**
	 * Suppression d'une unité de travail
	 *
	 * @param event Evenement appelé pour le lancement de l'action
	 * @param element L'élément cliqué
	 */
	delete_workunit: function( event, element ) {
		event.preventDefault();

		if( confirm( digi_confirm_delete ) ) {
			var data = {
				action: 'delete_society',
				element_id: jQuery( element ).data( 'id' ),
			};

			jQuery( element ).closest( 'li' ).fadeOut();
			jQuery.post( ajaxurl, data, function( response ) {} );
		}
	},

	delete_element_sheet: function( event, element ) {
		event.preventDefault();

		var data = {
			action: 'wpdigi_delete_sheet',
			parent_id: jQuery( element ).data( 'parent-id' ),
			element_id: jQuery( element ).data( 'id' ),
			global: jQuery( element ).data( 'global' ),
		};

		jQuery( element ).closest( 'li' ).fadeOut();

		jQuery.post( ajaxurl, data, function() {

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
	        	jQuery( element ).addClass( "wp-digi-loading" );
	        },
	        success:       function( responseText, statusText, xhr, $form ) {
	        	jQuery( element ).removeClass( "wp-digi-loading" );
	        	if ( responseText.status && ( undefined != responseText.output ) ) {
	        		if ( undefined != jQuery( ".wp-digi-global-sheet-content ul.wp-digi-list-document" ).html() ) {
	        			jQuery( ".wp-digi-global-sheet-content ul.wp-digi-list-document" ).prepend( responseText.output );
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
	}

};
