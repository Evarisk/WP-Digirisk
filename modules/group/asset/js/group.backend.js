"use strict";

var digi_group = {
	$: undefined,
	event: function( $ ) {
		digi_group.$ = $;

		// Modifier un group
		digi_group.$( document ).on( 'keyup', 'input[name="wp-digi-group-name"]', function( event ) { digi_group.identity_edition_mode( event, digi_group.$( this ) ); } );
		digi_group.$( document ).on( 'click', '#wp-digi-save-group-identity-button', function( event ) { digi_group.save_identity( event, digi_group.$( this ) ); } );

		// Créer un groupement
		digi_group.$( document ).on( 'click', '.wp-digi-group-selector .wp-digi-new-group-action a', function( event ) { digi_group.create_group( event, digi_group.$( this ) ); } );

		// Print DUER
		digi_group.$( document ).on( 'click', '.wp-digi-duer-form-display', function( event ) { digi_group.display_form_duer( event, digi_group.$( this ) ); } );

		/**	Formulaire de génération du DUER / DUER generation form	*/
		digi_group.$( ".wp-digi-societytree-right-container" ).on( "click", ".wp-digi-duer-generation-button", function( event ) { digi_group.save_element_sheet( event, digi_group.$( this ) ); } );

    // Sauvegarde la configuration
    digi_group.$( document ).on( 'click', '.wp-digi-form-save-configuration button', function( event ) { digi_group.save_configuration( event, digi_group.$( this ) ); } );
  },

	identity_edition_mode: function( event, element ) {
		digi_group.$( ".wp-digi-group-action-container" ).removeClass( "hidden" );
		digi_group.$( element ).addClass( "active" );

		digi_group.$( '.wp-digi-societytree-left-container toggle span' ).html( digi_group.$( element ).val() );
    digi_group.$( '.wp-digi-group-action-container .wp-digi-bton-fourth' ).text( 'Enregistrer' );
	},

	save_identity: function( event, element ) {
		digi_group.$( element ).addClass( "wp-digi-loading" );

		var group_id = digi_group.$( element ).closest( '.wp-digi-group-sheet' ).data( 'id' );

		var data = {
			'action': 'wpdigi_ajax_group_update',
			'_wpnonce': digi_group.$( element ).data( 'nonce' ),
			'group_id': group_id,
			'send_to_group_id': digi_group.$( 'input[name="wp-digi-group-id"]' ).val(),
			'title': digi_group.$( 'input[name="wp-digi-group-name"]' ).val(),
		};

		digi_group.$.post( window.ajaxurl, data, function( response ) {
			digi_group.$( element ).removeClass( "wp-digi-loading" );
			digi_group.$( element ).removeClass( "active" );
			digi_group.$( element ).closest( '.wp-digi-group-sheet-header' ).find( '.wpdigi-auto-complete' ).val( '' );
			digi_group.$( element ).closest( '.wp-digi-group-sheet-header' ).find( 'input[name="wp-digi-group-id"]' ).val( '0' );
			if( response.data.template_left !== undefined )
				digi_group.$( ".wp-digi-societytree-left-container" ).html( response.data.template_left );

			digi_group.$( '.wp-digi-group-action-container' ).addClass( "hidden" );
		} );
	},

	create_group: function( event, element ) {
		event.preventDefault();
		var group_id = digi_group.$( element ).data( 'id' );
		digi_group.$( '.wp-digi-group-selector .wp-digi-develop-list' ).toggle();
		digi_group.$( ".wp-digi-societytree-main-container" ).addClass( "wp-digi-bloc-loading" );

		var data = {
			action: 'wpdigi-create-group',
			group_id: group_id,
		};

		digi_group.$.post( window.ajaxurl, data, function( response ) {
			digi_group.$( ".wp-digi-societytree-main-container" ).removeClass( "wp-digi-bloc-loading" );
			digi_group.$( ".wp-digi-societytree-left-container" ).replaceWith( response.data.template_left );
			digi_group.$( ".wp-digi-societytree-right-container" ).html( response.data.template_right );
			window.digi_global.init( digi_group.$ );
			window.digi_workunit.event( digi_society.$ );
			window.digi_search.event( digi_group.$ );
		} );
	},

	display_form_duer: function( event, element ) {
		event.preventDefault();
		/**
		 * Ajout d'un loader sur le bloc à droite / Display a loader on the right bloc
		 */
		digi_group.$( ".wp-digi-societytree-right-container" ).addClass( "wp-digi-bloc-loading" );

		var data = {
			action: 'load_sheet_display',
			element_id: digi_group.$( element ).data( 'id' ),
			tab_to_display: 'digi-generate-sheet',
		};

		digi_group.$.post( window.ajaxurl, data, function( response ) {
			digi_group.$( ".wp-digi-societytree-right-container" ).html( response.data.template );
			digi_group.$( ".wp-digi-societytree-right-container" ).removeClass( "wp-digi-bloc-loading" );
		} );
	},

	/**
	 * Lancement de l'enregistrement de la fiche de l'unité de travail
	 *
	 * @param event Evenement appelé pour le lancement de l'action
	 * @param HTMLElement Element sur lequel on intervient
	 */
	save_element_sheet : function ( event, element ) {
		event.preventDefault();

		var options = {
      beforeSubmit: function( formData, jqForm, options ) {
      	digi_group.$( element ).addClass( "wp-digi-loading" );
      },
      success: function( responseText, statusText, xhr, $form ) {
      	digi_group.$( element ).removeClass( "wp-digi-loading" );
				digi_group.$( ".wp-digi-global-sheet-tab li[data-action='digi-sheet']" ).click( );
      },
      dataType: "json",
  	};

		digi_group.$( "#wpdigi-save-element-form" ).ajaxSubmit( options );
	},

  save_configuration: function( event, element ) {
    event.preventDefault();
    digi_group.$( element ).closest( 'form' ).ajaxSubmit({
			'beforeSubmit': function() {
				digi_group.$( ".wp-digi-societytree-main-container" ).addClass( "wp-digi-bloc-loading" );
			},
			'success': function() {
				digi_group.$( ".wp-digi-societytree-main-container" ).removeClass( "wp-digi-bloc-loading" );
			}
		});
  }

};
