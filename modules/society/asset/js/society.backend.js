window.digirisk.society = {};

window.digirisk.society.init = function() {
	window.digirisk.society.event();
};

window.digirisk.society.event = function() {
	jQuery( document ).on( 'keyup', 'input[name="title"]', window.digirisk.society.display_save_button );
};

window.digirisk.society.callback_load_society = function( element, response ) {
	console.log(response);
	jQuery( '.wp-digi-societytree-right-container' ).html( response.data.template );

	if ( response.data.template_left ) {
		jQuery( '.wp-digi-societytree-left-container' ).html( response.data.template_left );
	}
}

window.digirisk.society.display_save_button = function( event ) {
	jQuery( this ).closest( '.wp-digi-global-sheet-header' ).find( ".wp-digi-global-action-container" ).removeClass( "hidden" );
	jQuery( this ).addClass( "active" );
	jQuery( '.wp-digi-group-action-container .wp-digi-bton-fourth' ).text( 'Enregistrer' );
}



//
//
// var digi_society = {
// 	$: undefined,
// 	event: function( $ ) {
// 		digi_society.$ = $;
// 		digi_society.$( document ).on( 'keyup', 'input[name="establishment_name"]', function( event ) { digi_society.identity_edition_mode( event, digi_society.$( this ) ); } );
// 		digi_society.$( document ).on( 'click', '.wp-digi-societytree-left-container .wp-digi-global-name', function( event ) { digi_society.load_society( event, digi_society.$( this ) ); } );
// 		digi_society.$( document ).on( 'click', '.wp-digi-global-sheet-header button.wp-digi-save-identity-button', function( event ) { digi_society.save_society( event, digi_society.$( this ) ); } );
// 		digi_society.$( document ).on( 'click', '.wp-digi-global-sheet-header .wp-digi-delete-action', function ( event ) { digi_society.delete_society( event, digi_society.$( this ) ); } );
// 	},
//
// 	/**
// 	 * Affichage du bouton d'enregistrement pour les informations principales d'une unité de travail. Mise en avant des champs a sauvegarder
// 	 *
// 	 * @param event Evenement appelé pour le lancement de l'action
// 	 * @param element L'élément cliqué
// 	 */
// 	identity_edition_mode: function( event, element ) {
// 		digi_society.$( element ).closest( '.wp-digi-global-sheet-header' ).find( ".wp-digi-global-action-container" ).removeClass( "hidden" );
// 		digi_society.$( element ).addClass( "active" );
// 		digi_global.$( '.wp-digi-group-action-container .wp-digi-bton-fourth' ).text( 'Enregistrer' );
// 	},
//
// 	load_society: function( event, element ) {
// 		digi_society.$( '.wp-digi-group-selector .digi-popup').hide();
// 		digi_society.$( element ).closest( 'ul' ).find( 'li.active' ).removeClass( 'active' );
// 		digi_society.$( element ).closest( 'li' ).addClass( 'active' );
// 		digi_society.$( '.wp-digi-societytree-right-container' ).addClass( "wp-digi-bloc-loading" );
// 		digi_society.$( '.wp-digi-societytree-left-container' ).addClass( "wp-digi-bloc-loading" );
//
// 		var data = {
// 			action: 'load_sheet_display',
// 			element_id: digi_society.$( element ).closest( 'li' ).data( 'id' ),
// 			tab_to_display: 'digi-risk',
// 		};
//
// 		digi_society.$.post( window.ajaxurl, data, function( response ) {
// 			digi_society.$( '.wp-digi-societytree-right-container' ).removeClass( "wp-digi-bloc-loading" );
// 			digi_society.$( '.wp-digi-societytree-right-container' ).html( response.data.template );
// 			digi_society.$( '.wp-digi-societytree-left-container' ).removeClass( "wp-digi-bloc-loading" );
// 			if ( response.data.template_left ) {
// 				digi_society.$( '.wp-digi-societytree-left-container' ).replaceWith( response.data.template_left );
// 			}
//
// 			window.digi_global.init( digi_society.$ );
// 			window.digi_risk.init( false, digi_society.$ );
// 			window.digi_search.event( digi_society.$ );
// 		} );
// 	},
//
// 	/**
// 	 * Enregistrement des informations principales d'une unité de travail
// 	 *
// 	 * @param event Evenement appelé pour le lancement de l'action
// 	 * @param element L'élément cliqué
// 	 */
// 	save_society: function( event, element ) {
// 		digi_society.$( element ).addClass( "wp-digi-loading" );
//
// 		var element_id = digi_society.$( element ).closest( '.wp-digi-sheet' ).data( 'id' );
//
// 		var data = {
// 			'action': 'save_society',
// 			'id': element_id,
// 			'parent_id': digi_society.$( 'input[name="group_id"]' ).val(),
// 			'title': digi_society.$( 'input[name="establishment_name"]' ).val(),
// 		};
//
// 		digi_society.$.post( window.ajaxurl, data, function( response ) {
// 			digi_society.$( '.wp-digi-societytree-left-container' ).html( response.data.template_left );
// 			digi_society.$( element ).removeClass( "wp-digi-loading" );
// 			digi_society.$( ".wp-digi-global-sheet-header .wp-digi-global-action-container" ).addClass( "hidden" );
// 			digi_society.$( ".wp-digi-global-sheet-header .wp-list-search input" ).val( '' );
// 		}, "json");
// 	},
//
// 	delete_society: function( event, element ) {
// 		event.preventDefault();
//
// 		if( window.confirm( window.digi_confirm_delete ) ) {
// 			var data = {
// 				action: 'delete_society',
// 				element_id: digi_society.$( element ).data( 'id' ),
// 			};
//
// 			digi_society.$( ".wp-digi-societytree-main-container" ).addClass( "wp-digi-bloc-loading" );
//
// 			digi_society.$.post( window.ajaxurl, data, function( response ) {
// 				digi_society.$( ".wp-digi-societytree-main-container" ).removeClass( "wp-digi-bloc-loading" );
// 				digi_society.$( ".wp-digi-societytree-main-container" ).replaceWith( response.data.template );
// 			} );
// 		}
// 	}
// };
