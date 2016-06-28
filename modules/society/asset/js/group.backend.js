"use strict"

jQuery( document ).ready( function() {
	digi_group.event();
} );

var digi_group = {
	event: function() {
		// jQuery( document ).on( 'click', '.wp-digi-group-selector toggle', function() {  } );

		jQuery( ".wp-digi-societytree-right-container" ).on( "click", ".wp-digi-group-sheet-tab li", function( event ) { digi_group.display_group_tab_content( event, jQuery( this ) ); } );

		// Modifier un group
		jQuery( document ).on( 'keyup', 'input[name="wp-digi-group-name"]', function( event ) { digi_group.identity_edition_mode( event, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '#wp-digi-save-group-identity-button', function( event ) { digi_group.save_identity( event, jQuery( this ) ); } );

		// Selection d'un groupement
		jQuery( document ).on( 'click', '.wp-digi-group-selector .wp-digi-develop-list span:not(.wp-digi-new-group-action)', function( event ) { digi_group.select_group( event, jQuery( this ) ); } );

		// Créer un groupement
		jQuery( document ).on( 'click', '.wp-digi-group-selector .wp-digi-new-group-action a', function( event ) { digi_group.create_group( event, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wp-digi-delete-group-action', function( event ) { digi_group.delete_group( event, jQuery( this ) ); } );

		// Print DUER
		jQuery( document ).on( 'click', '.wp-digi-duer-form-display', function( event ) { digi_group.display_form_duer( event, jQuery( this ) ); } );

		/**	Formulaire de génération du DUER / DUER generation form	*/
		jQuery( ".wp-digi-societytree-right-container" ).on( "click", ".wp-digi-duer-generation-button", function( event ) { digi_group.save_element_sheet( event, jQuery( this ) ); } );

    // Sauvegarde la configuration
    jQuery( document ).on( 'click', '.wp-digi-form-save-configuration button', function( event ) { digi_group.save_configuration( event, jQuery( this ) ); } );
  },

	display_group_tab_content : function( event, element ) {
		event.preventDefault();

		if ( !jQuery( element ).hasClass( "disabled" ) ) {
			jQuery( ".wp-digi-group-sheet-tab li.active" ).removeClass( "active" );
			jQuery( element ).addClass( "active" );

			/**
			 * Ajout d'un loader sur le bloc à droite / Display a loader on the right bloc
			 */
			jQuery( ".wp-digi-group-sheet-content" ).addClass( "wp-digi-bloc-loading" );

			/**
			 * Chargement de la fiche dans le conteneur droit / Load the sheet into the right container
			 */
			var action = jQuery( element ).data( 'action' );
			var data = {
				"action": "wpdigi_loadsheet_" + jQuery( element ).closest( "ul" ).data( "type" ),
				"subaction" : action.replace( "digi-", "" ),
				"group_id" : jQuery( element ).closest( '.wp-digi-group-sheet' ).data( 'id' ),
			};
			jQuery.post( ajaxurl, data, function( response ){
				jQuery( ".wp-digi-group-sheet-content" ).html( response.output );
				/**
				 * Supression du loader sur le bloc à droite / Remove the loader on the right bloc
				 */
				jQuery( ".wp-digi-group-sheet-content" ).removeClass( "wp-digi-bloc-loading" );

				if( action.replace( "digi-", "" ) == "digi-risk" ) {
					digi_risk.tab_changed();
				}

				digi_global.init();
			}, 'json');
		}
	},

	identity_edition_mode: function( event, element ) {
		jQuery( ".wp-digi-group-action-container" ).removeClass( "hidden" );
		jQuery( element ).addClass( "active" );

		jQuery( '.wp-digi-societytree-left-container toggle span' ).html( jQuery( element ).val() );
    jQuery( '.wp-digi-group-action-container .wp-digi-bton-fourth' ).text( 'Enregistrer' );
	},

	save_identity: function( event, element ) {
		jQuery( element ).addClass( "wp-digi-loading" );

		var group_id = jQuery( element ).closest( '.wp-digi-group-sheet' ).data( 'id' );

		var data = {
			'action': 'wpdigi_ajax_group_update',
			'_wpnonce': jQuery( element ).data( 'nonce' ),
			'group_id': group_id,
			'send_to_group_id': jQuery( 'input[name="wp-digi-group-id"]' ).val(),
			'title': jQuery( 'input[name="wp-digi-group-name"]' ).val(),
		};

		jQuery.post( ajaxurl, data, function( response ) {
			jQuery( element ).removeClass( "wp-digi-loading" );
			jQuery( element ).removeClass( "active" );
			jQuery( element ).closest( '.wp-digi-group-sheet-header' ).find( '.wpdigi-auto-complete' ).val( '' );
			jQuery( element ).closest( '.wp-digi-group-sheet-header' ).find( 'input[name="wp-digi-group-id"]' ).val( '0' );
			if( response.data.template_left != undefined )
				jQuery( ".wp-digi-societytree-left-container" ).html( response.data.template_left );

			jQuery( '.wp-digi-group-action-container' ).addClass( "hidden" );
		} );
	},

	select_group: function( event, element ) {
		event.preventDefault();
		var group_id = jQuery( element ).data( 'id' );
		jQuery( '.wp-digi-group-selector .wp-digi-develop-list' ).toggle();

		var data = {
			action: 'wpdigi-load-group',
			group_id: group_id,
		};

		jQuery.post( ajaxurl, data, function( response ) {
			jQuery( ".wp-digi-societytree-left-container" ).html( response.data.template_left );
			jQuery( ".wp-digi-societytree-right-container" ).html( response.data.template_right );
			jQuery( element ).closest( 'div' ).addClass( 'active' );
			digi_global.init();
		} );
	},

	create_group: function( event, element ) {
		event.preventDefault();
		var group_id = jQuery( element ).data( 'id' );
		jQuery( '.wp-digi-group-selector .wp-digi-develop-list' ).toggle();

		var data = {
			action: 'wpdigi-create-group',
			group_id: group_id,
		};

		jQuery.post( ajaxurl, data, function( response ) {
			jQuery( ".wp-digi-societytree-left-container" ).html( response.data.template_left );
			jQuery( ".wp-digi-societytree-right-container" ).html( response.data.template_right );
			digi_global.init();
		} );
	},

  delete_group: function( event, element ) {
    event.preventDefault();

    if( confirm( digi_confirm_delete ) ) {
  		var group_id = jQuery( element ).data( 'id' );

  		var data = {
  			action: 'wpdigi-delete-group',
  			group_id: group_id,
  		};

  		jQuery.post( ajaxurl, data, function( response ) {
        jQuery( ".wp-digi-societytree-left-container" ).html( response.data.template_left );
        jQuery( ".wp-digi-societytree-right-container" ).html( response.data.template_right );
  			digi_global.init();
  		} );
    }
  },

	display_form_duer: function( event, element ) {
		event.preventDefault();

		/**
		 * Ajout d'un loader sur le bloc à droite / Display a loader on the right bloc
		 */
		jQuery( ".wp-digi-societytree-right-container" ).addClass( "wp-digi-bloc-loading" );

		/**
		 * Chargement de la fiche dans le conteneur droit / Load the sheet into the right container
		 */
		jQuery( ".wp-digi-societytree-right-container" ).load( ajaxurl, {
			"action": "wpdigi_group_sheet_display",
			"group_id" : jQuery( element ).data( 'id' ),
		}, function(){
			digi_global.init();
			/**
			 * Supression du loader sur le bloc à droite / Remove the loader on the right bloc
			 */
			jQuery( ".wp-digi-societytree-right-container" ).removeClass( "wp-digi-bloc-loading" );
		});

		/**
		 * Ajoute une classe permettant de savoir sur quel element on est dans l'arbre / Add a class allowing to know on wich element we are in tree
		 */
		jQuery( ".wp-digi-item-workunit.active" ).each( function(){
			jQuery( element ).removeClass( "active" );
		});
		jQuery( element ).addClass( "active" );
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
	        	if ( responseText.status ) {
		        	jQuery( ".wp-digi-list-item[data-action='digi-sheet']" ).click( );
	        	}
	        },
	        dataType: "json",
	    };
		jQuery( "#wpdigi-save-element-form" ).ajaxSubmit( options );
	},

  save_configuration: function( event, element ) {
    event.preventDefault();

    var options = {
      beforeSubmit: function( formData, jqForm, options ) {
        jQuery( element ).addClass( "wp-digi-loading" );
      },
      success: function() {
        jQuery( element ).removeClass( "wp-digi-loading" );
      },
      dataType: "json"
    };

    jQuery( element ).closest( 'form' ).ajaxSubmit( options );

  }

};
