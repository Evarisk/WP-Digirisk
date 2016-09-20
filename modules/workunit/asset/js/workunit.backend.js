"use strict";

var digi_workunit = {

	$: undefined,
	event: function( $ ) {
		digi_workunit.$ = $;
		/**	Quand on demande l'ajout d'une unité de travail	*/
		digi_workunit.$( ".wp-digi-societytree-main-container" ).on( "keypress", "input[name='workunit[title]']", function( event) { digi_workunit.call_create_workunit( event ); } );
		digi_workunit.$( ".wp-digi-societytree-main-container" ).on( "click", ".wp-digi-new-workunit-action", function( event ){ digi_workunit.create_workunit( event, digi_workunit.$( this ) ); } );

		/**	Quand on demande la suppression d'une unité de travail	*/
		digi_workunit.$( document ).on( 'click', '.wp-digi-list-workunit .wp-digi-action-delete', function( event ) { digi_workunit.delete_workunit( event, digi_workunit.$( this ) ); } );

		digi_workunit.$( document ).on( 'click', '.wp-digi-sheet-tab-toggle', function() { window.digi_global.responsive_menu_toggle( digi_workunit.$( this ) ); } );
		digi_workunit.$( document ).on( 'click', '.wp-digi-sheet-tab-responsive-content > li', function() { window.digi_global.responsive_menu_toggle( digi_workunit.$( this ) ); } );
	},

	call_create_workunit: function( event ) {
		if( event.keyCode == 13 ) {
			event.preventDefault();
			digi_workunit.$( ".wp-digi-societytree-main-container .wp-digi-new-workunit-action" ).click();
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

		digi_workunit.$( "#wpdigi-workunit-creation-form" ).ajaxSubmit({
			'dataType': 'json',
			'beforeSubmit' : function( formData, jqForm, options ) {
				digi_workunit.$( '.wp-digi-societytree-left-container' ).addClass( "wp-digi-bloc-loading" );
			},
			'success' : function( response, status, xhr, $form ) {
				digi_workunit.$( '.wp-digi-societytree-left-container' ).removeClass( "wp-digi-bloc-loading" );
				digi_workunit.$( ".wp-digi-list-workunit" ).replaceWith( response.data.template );
				digi_workunit.$( ".wp-digi-workunit-" + response.data.id + " .wp-digi-global-name" ).click();
				window.digi_search.event( digi_workunit.$ );
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

		if( window.confirm( window.digi_confirm_delete ) ) {
			var data = {
				action: 'delete_society',
				element_id: digi_workunit.$( element ).data( 'id' ),
			};

			digi_workunit.$( element ).closest( 'li' ).fadeOut();
			digi_workunit.$.post( window.ajaxurl, data, function( response ) {} );
		}
	},

};
