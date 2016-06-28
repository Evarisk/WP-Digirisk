"use strict"

jQuery( document ).ready( function() {
	digi_workunit.event();
} );

var digi_workunit = {

	/**
	 * Définition de la liste des actions possibles
	 */
	event: function() {
		/**	Quand on demande l'ajout d'une unité de travail	*/
		jQuery( ".wp-digi-societytree-left-container" ).on( "keypress", "input[name='workunit[title]']", function( event) { digi_workunit.call_create_workunit( event ); } );
		jQuery( ".wp-digi-societytree-left-container" ).on( "click", ".wp-digi-new-workunit-action", function( event ){ digi_workunit.create_workunit( event, jQuery( this ) ); } );

		/** Quand on clique sur les lignes d'une unité de travail on l'affiche à droite */
		jQuery( ".wp-digi-societytree-left-container" ).on( "click", ".wp-digi-item-workunit .wp-digi-workunit-name", function( event ) { digi_workunit.display_workunit_sheet( event, jQuery( this ) ); } );

		/** Qunad on clique sur les onglets dans une unité de travail on l'affiche */
		jQuery( ".wp-digi-societytree-right-container" ).on( "click", ".wp-digi-workunit-sheet-tab li", function( event ) { digi_workunit.display_workunit_tab_content( event, jQuery( this ) ); } );

		/**	Quand on demande la suppression d'une unité de travail	*/
		jQuery( document ).on( 'click', '.wp-digi-list-workunit .wp-digi-action-delete', function( event ) { digi_workunit.delete_workunit( event, jQuery( this ) ); } );

		/**	Quand on commence a modifier le nom ou la description d'une unité, on affiche le bouton de sauvgarde	*/
		jQuery( document ).on( 'keyup', 'input[name="wp-digi-workunit-name"]', function( event ) { digi_workunit.identity_edition_mode( event, jQuery( this ) ); } );
		jQuery( document ).on( 'keyup', 'textarea[name="wp-digi-workunit-content"]', function( event ) { digi_workunit.identity_edition_mode( event, jQuery( this ) ); } );
		/**	Quand on clique sur le bouton de sauvegarde des informations d'une unité	*/
		jQuery( document ).on( 'click', '#wp-digi-save-workunit-identity-button', function( event ) { digi_workunit.save_identity( event, jQuery( this ) ); } );

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
			'beforeSubmit' : function( formData, jqForm, options ){
				jQuery( element ).addClass( "wp-digi-bloc-loading" );
			},
			'success' : function( response, status, xhr, $form ){
				if ( response.status ) {
					jQuery( ".wp-digi-list-workunit" ).prepend( response.output );
					jQuery( ".wp-digi-workunit-" + response.element.id + ' span.wp-digi-workunit-name' ).click();
					$form[ 0 ].reset();
					jQuery( element ).removeClass( "wp-digi-bloc-loading" );

					jQuery( '.wp-digi-group-header' ).replaceWith( response.template );


				}
				else {
					alert( response.message );
				}
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

  		var workunit_id = jQuery( element ).data( 'id' );

  		var data = {
  			'action': 'wpdigi_ajax_workunit_delete',
  			'_wpnonce': jQuery( element ).data( 'nonce' ),
  			'workunit_id': workunit_id,
  		};

  		jQuery.post( ajaxurl, data, function( response ) {
  			jQuery( '.wp-digi-workunit-' + workunit_id ).fadeOut();

  			jQuery( '.wp-digi-group-header' ).replaceWith( response.data.template );
  		} );
    }
	},

	/**
	 * Affichage du bouton d'enregistrement pour les informations principales d'une unité de travail. Mise en avant des champs a sauvegarder
	 *
	 * @param event Evenement appelé pour le lancement de l'action
	 * @param element L'élément cliqué
	 */
	identity_edition_mode: function( event, element ) {
		jQuery( ".wp-digi-workunit-action-container" ).removeClass( "hidden" );
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

		var workunit_id = jQuery( element ).closest( '.wp-digi-workunit-sheet' ).data( 'id' );

		var data = {
			'action': 'wpdigi_ajax_workunit_update',
			'_wpnonce': jQuery( element ).data( 'nonce' ),
			'workunit_id': workunit_id,
			'title': jQuery( 'input[name="wp-digi-workunit-name"]' ).val(),
			'content': jQuery( 'textarea[name="wp-digi-workunit-content"]' ).val(),
		};

		jQuery.post( ajaxurl, data, function( response ) {
			if ( response.success ) {
				jQuery( element ).removeClass( "wp-digi-loading" );
				jQuery( 'input[name="wp-digi-workunit-name"]' ).removeClass( 'active' );
				jQuery( 'textarea[name="wp-digi-workunit-content"]' ).removeClass( 'active' );

				jQuery( ".wp-digi-workunit-action-container" ).addClass( "hidden" );

				jQuery( ".wp-digi-workunit-" + response.data.id + " span.wp-digi-workunit-name > span" ).html( response.data.title );
			}
			else {

			}
		}, "json");
	},

	/**
	 * Affichage d'une unité de travail
	 *
	 * @param event Evenement appelé pour le lancement de l'action
	 * @param element L'élément cliqué
	 */
	display_workunit_sheet : function( event, element ) {
		event.preventDefault();

		/**
		 * Ajout d'un loader sur le bloc à droite / Display a loader on the right bloc
		 */
		jQuery( ".wp-digi-societytree-right-container" ).addClass( "wp-digi-bloc-loading" );

		/**
		 * Chargement de la fiche dans le conteneur droit / Load the sheet into the right container
		 */
		jQuery( ".wp-digi-societytree-right-container" ).load( ajaxurl, {
			"action": "wpdigi_workunit_sheet_display",
			"wpdigi_nonce": jQuery( element ).closest( '.wp-digi-item-workunit' ).data( 'nonce' ),
			"workunit_id" : jQuery( element ).closest( '.wp-digi-item-workunit' ).data( 'id' ),
		}, function(){
			/**
			 * Supression du loader sur le bloc à droite / Remove the loader on the right bloc
			 */
			jQuery( ".wp-digi-societytree-right-container" ).removeClass( "wp-digi-bloc-loading" );
			var workunit_id = jQuery( element ).closest( '.wp-digi-item-workunit' ).data( 'id' );
			if ( jQuery( ".wp-digi-workunit-sheet[data-id='" + workunit_id  + "'] input[name='wp-digi-workunit-name']" ).val() === '' ) {
				jQuery( ".wp-digi-workunit-sheet[data-id='" + workunit_id  + "'] input[name='wp-digi-workunit-name']" ).focus();
				jQuery( '.wp-digi-global-sheet-header' ).find( 'div' ).removeClass('hidden');
			}

			digi_global.init();
		});

		/**
		 * Ajoute une classe permettant de savoir sur quel element on est dans l'arbre / Add a class allowing to know on wich element we are in tree
		 */
		jQuery( ".wp-digi-item-workunit.active" ).each( function(){
			jQuery( this ).removeClass( "active" );
		});

		jQuery( element ).closest( 'li' ).addClass( "active" );
	},

	/**
	 * Affichage des onglets dans les unités de travail
	 *
	 * @param event Evenement appelé pour le lancement de l'action
	 * @param element Element sur lequel on intervient
	 */
	display_workunit_tab_content : function( event, element ) {
		event.preventDefault();

		if ( !jQuery( element ).hasClass( "disabled" ) ) {
			jQuery( ".wp-digi-workunit-sheet-tab li.active" ).removeClass( "active" );
			jQuery( element ).addClass( "active" );

			/**
			 * Ajout d'un loader sur le bloc à droite / Display a loader on the right bloc
			 */
			jQuery( ".wp-digi-workunit-sheet-content" ).addClass( "wp-digi-bloc-loading" );

			/**
			 * Chargement de la fiche dans le conteneur droit / Load the sheet into the right container
			 */
			var action = jQuery( element ).data( 'action' );
			var data = {
				"action": "wpdigi_loadsheet_" + jQuery( element ).closest( "ul" ).data( "type" ),
				"subaction" : action.replace( "digi-", "" ),
				"wpdigi_nonce": jQuery( element ).data( 'nonce' ),
				"workunit_id" : jQuery( element ).closest( '.wp-digi-workunit-sheet' ).data( 'id' ),
			};
			jQuery.post( ajaxurl, data, function( response ){
				jQuery( ".wp-digi-workunit-sheet-content" ).html( response.output );
				/**
				 * Supression du loader sur le bloc à droite / Remove the loader on the right bloc
				 */
				jQuery( ".wp-digi-workunit-sheet-content" ).removeClass( "wp-digi-bloc-loading" );

				digi_global.init();

				if( action.replace( "digi-", "" ) == "digi-risk" ) {
					digi_risk.tab_changed();
				}
				else if ( action.replace( "digi-", "" ) == "recommendation" ) {
					digi_recommendation.tab_changed();
				}

				jQuery( '.wp-digi-sheet-tab-title' ).html( jQuery( element ).html() );
			}, 'json');
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
