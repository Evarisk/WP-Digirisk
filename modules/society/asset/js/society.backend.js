"use strict"

var digi_society = {
	event: function() {
		jQuery( document ).on( 'click', '.wp-digi-societytree-left-container .wp-digi-global-name', function( event ) { digi_society.load_society( event, jQuery( this ) ); } );

		/**	Quand on commence a modifier le nom ou la description, on affiche le bouton de sauvgarde	*/
		jQuery( document ).on( 'keyup', 'input[name="establishment_name"]', function( event ) { digi_society.identity_edition_mode( event, jQuery( this ) ); } );
		/**	Quand on clique sur le bouton de sauvegarde des informations d'une unité	*/
		jQuery( document ).on( 'click', '.wp-digi-global-sheet-header button.wp-digi-save-identity-button', function( event ) { digi_society.save_identity( event, jQuery( this ) ); } );

		jQuery( document ).on( 'click', '.wp-digi-global-sheet-header .wp-digi-delete-action', function ( event ) { digi_society.delete_society( event, jQuery( this ) ); } );
	},

	load_society: function( event, element ) {
		jQuery( '.wp-digi-group-selector .digi-popup').hide();
		jQuery( element ).closest( 'ul' ).find( 'li.active' ).removeClass( 'active' );
		jQuery( element ).closest( 'li' ).addClass( 'active' );
		jQuery( '.wp-digi-societytree-right-container' ).addClass( "wp-digi-bloc-loading" );

		var data = {
			action: 'load_sheet_display',
			element_id: jQuery( element ).closest( 'li' ).data( 'id' ),
			tab_to_display: 'digi-risk',
		};

		jQuery.post( ajaxurl, data, function( response ) {
			jQuery( '.wp-digi-societytree-right-container' ).removeClass( "wp-digi-bloc-loading" );
			jQuery( '.wp-digi-societytree-right-container' ).html( response.data.template );
			jQuery( '.wp-digi-societytree-left-container' ).html( response.data.template_left );
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
		jQuery( element ).closest( '.wp-digi-global-sheet-header' ).find( ".wp-digi-global-action-container" ).removeClass( "hidden" );
		jQuery( element ).addClass( "active" );
	},

	/**
	 * Enregistrement des informations principales d'une unité de travail
	 *
	 * @param event Evenement appelé pour le lancement de l'action
	 * @param element L'élément cliqué
	 */
	save_identity: function( event, element ) {
		jQuery( element ).addClass( "wp-digi-loading" );

		var element_id = jQuery( element ).closest( '.wp-digi-sheet' ).data( 'id' );

		var data = {
			'action': 'save_society',
			'element_id': element_id,
			'parent_id': jQuery( 'input[name="group_id"]' ).val(),
			'title': jQuery( 'input[name="establishment_name"]' ).val(),
		};

		jQuery.post( ajaxurl, data, function( response ) {
			jQuery( '.wp-digi-societytree-left-container' ).html( response.data.template_left );
			jQuery( element ).removeClass( "wp-digi-loading" );
			jQuery( ".wp-digi-global-sheet-header .wp-digi-global-action-container" ).addClass( "hidden" );
		}, "json");
	},

	delete_society: function( event, element ) {
		event.preventDefault();

		if( confirm( digi_confirm_delete ) ) {
			var data = {
				action: 'delete_society',
				element_id: jQuery( element ).data( 'id' ),
			};

			jQuery( ".wp-digi-societytree-main-container" ).addClass( "wp-digi-bloc-loading" );

			jQuery.post( ajaxurl, data, function( response ) {
				jQuery( ".wp-digi-societytree-main-container" ).removeClass( "wp-digi-bloc-loading" );
			} );
		}
	}
};
