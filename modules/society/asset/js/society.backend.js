"use strict";

var digi_society = {
	$,
	event: function( $ ) {
		digi_society.$ = $,

		digi_society.$( document ).on( 'click', '.wp-digi-societytree-left-container .wp-digi-global-name', function( event ) { digi_society.load_society( event, digi_society.$( this ) ); } );

		/**	Quand on commence a modifier le nom ou la description, on affiche le bouton de sauvgarde	*/
		digi_society.$( document ).on( 'keyup', 'input[name="establishment_name"]', function( event ) { digi_society.identity_edition_mode( event, digi_society.$( this ) ); } );
		/**	Quand on clique sur le bouton de sauvegarde des informations d'une unité	*/
		digi_society.$( document ).on( 'click', '.wp-digi-global-sheet-header button.wp-digi-save-identity-button', function( event ) { digi_society.save_identity( event, digi_society.$( this ) ); } );

		digi_society.$( document ).on( 'click', '.wp-digi-global-sheet-header .wp-digi-delete-action', function ( event ) { digi_society.delete_society( event, digi_society.$( this ) ); } );
	},

	load_society: function( event, element ) {
		digi_society.$( '.wp-digi-group-selector .digi-popup').hide();
		digi_society.$( element ).closest( 'ul' ).find( 'li.active' ).removeClass( 'active' );
		digi_society.$( element ).closest( 'li' ).addClass( 'active' );
		digi_society.$( '.wp-digi-societytree-right-container' ).addClass( "wp-digi-bloc-loading" );

		var data = {
			action: 'load_sheet_display',
			element_id: digi_society.$( element ).closest( 'li' ).data( 'id' ),
			tab_to_display: 'digi-risk',
		};

		digi_society.$.post( ajaxurl, data, function( response ) {
			digi_society.$( '.wp-digi-societytree-right-container' ).removeClass( "wp-digi-bloc-loading" );
			digi_society.$( '.wp-digi-societytree-right-container' ).html( response.data.template );
			digi_society.$( '.wp-digi-societytree-left-container' ).html( response.data.template_left );
			digi_global.init();
		} );
	},

	/**
	 * Affichage du bouton d'enregistrement pour les informations principales d'une unité de travail. Mise en avant des champs a sauvegarder
	 *
	 * @param event Evenement appelé pour le lancement de l'action
	 * @param element L'élément cliqué
	 */
	identity_edition_mode: function( event, element ) {
		digi_society.$( element ).closest( '.wp-digi-global-sheet-header' ).find( ".wp-digi-global-action-container" ).removeClass( "hidden" );
		digi_society.$( element ).addClass( "active" );
	},

	/**
	 * Enregistrement des informations principales d'une unité de travail
	 *
	 * @param event Evenement appelé pour le lancement de l'action
	 * @param element L'élément cliqué
	 */
	save_identity: function( event, element ) {
		digi_society.$( element ).addClass( "wp-digi-loading" );

		var element_id = digi_society.$( element ).closest( '.wp-digi-sheet' ).data( 'id' );

		var data = {
			'action': 'save_society',
			'element_id': element_id,
			'parent_id': digi_society.$( 'input[name="group_id"]' ).val(),
			'title': digi_society.$( 'input[name="establishment_name"]' ).val(),
		};

		digi_society.$.post( ajaxurl, data, function( response ) {
			digi_society.$( '.wp-digi-societytree-left-container' ).html( response.data.template_left );
			digi_society.$( element ).removeClass( "wp-digi-loading" );
			digi_society.$( ".wp-digi-global-sheet-header .wp-digi-global-action-container" ).addClass( "hidden" );
		}, "json");
	},

	delete_society: function( event, element ) {
		event.preventDefault();

		if( confirm( digi_confirm_delete ) ) {
			var data = {
				action: 'delete_society',
				element_id: digi_society.$( element ).data( 'id' ),
			};

			digi_society.$( ".wp-digi-societytree-main-container" ).addClass( "wp-digi-bloc-loading" );

			digi_society.$.post( ajaxurl, data, function( response ) {
				digi_society.$( ".wp-digi-societytree-main-container" ).removeClass( "wp-digi-bloc-loading" );
			} );
		}
	}
};
