"use strict";

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

jQuery( document ).ready( function(){
	digi_global.init();
	digi_global.event();
	digi_installer.event();
	digi_society.event();
	digi_group.event();
	digi_risk.init();
	digi_workunit.event();
	digi_user.event();
	digi_evaluator.event();
	digi_recommendation.init();
  digi_tools.event();
});

var digi_global = {
	init: function() {
		jQuery( '.wpdigi_date' ).datepicker( {
			'dateFormat': 'dd/mm/yy',
		} );

		/**	Trigger event on use current date button	*/
		jQuery( document ).on( "click", ".digi_use_current_date", function( event ){
			event.preventDefault();

			jQuery( this ).prev( "input" ).val( digi_current_date );
		} );
		/**	Trigger event on use current datetime button	*/
		jQuery( document ).on( "click", ".digi_use_current_datetime", function( event ){
			event.preventDefault();

			jQuery( this ).prev( "input" ).val( digi_current_datetime );
		} );


		/** Auto complete */
		/**
		* Paramètre à ajouter sur la balise html
		* Ne pas oublier la classe : wp-digi-bloc-loader
		* int data-element-id : ID d'un élément ex: workunit_id
		* string data-callback : Pour appeler une fonction après avoir récupére la liste des ID des utilisateurs.
		* string append-to : Le bloc ou sera affiche le rendu
		*/
		jQuery.each( jQuery( '.wpdigi-auto-complete-user' ), function( key, element ) {
			var list_option = {
				'source': 'admin-ajax.php?action=search_user&element_id=' + jQuery( element ).data( "element-id" ) + '&filter=' + jQuery( element ).data( "filter" ),
				'minLength': 0,
			}
			if ( jQuery ( element ).data( 'append-to' ) != undefined ) {
				list_option.search = function( event, ui ) {
					jQuery( jQuery ( element ).data( 'append-to' ) ).addClass( 'wp-digi-bloc-loading' );
				}
				list_option.response = function( event, ui ) {
					jQuery( jQuery ( element ).data( 'append-to' ) ).replaceWith( ui.content[0].value );
				}
				list_option.open = function( event, ui ) {
					jQuery ( element ).autocomplete( 'close' );
				}
			}

      if( jQuery( element ).data( 'target' ) != undefined ) {
        list_option.select = function( event, ui ) {
          jQuery( 'input[name="' + jQuery( element ).data('target') + '"]' ).val( ui.item.id );
        }
      }

			jQuery( element ).autocomplete( list_option );
		} );

		// @TODO
		// A adapter pour faire que ce soit global
		jQuery.each( jQuery( '.wpdigi-auto-complete' ), function( key, element ) {
		jQuery( element ).autocomplete( {
			'source': 'admin-ajax.php?action=search&post_type=digi-group&element_id=' + jQuery( element ).data( 'id' ),
			'select': function( event, ui ) {
				jQuery( 'input[name="' + jQuery( element ).data('target') + '"]' ).val( ui.item.id );
				jQuery( '.wp-digi-group-action-container' ).removeClass( "hidden" );
			}
		} );
	} );
	},

	event: function() {
		jQuery( document ).on( 'click', 'toggle, .digi-toggle', function( event ) {
			event.stopPropagation();
			var element = jQuery( this );
			var div = jQuery( this ).parent().find( '.' + jQuery( this ).data( 'target' ) );

			jQuery( '.digi-popup' ).each( function() {
				if ( jQuery( this ).has( event.target ).length === 0 && jQuery( this ).is( ':visible' ) && !jQuery( this ).hasClass( element.data( 'target' ) ) ) {
					jQuery( this ).hide();
				}
			} );

			div.toggle();

		} );

		jQuery( document ).on( 'click', function( event ) {
			jQuery( '.digi-popup' ).each( function() {
				if ( jQuery( this ).has( event.target ).length === 0 && jQuery( this ).is( ':visible' ) ) {
					jQuery( this ).toggle();
				}
			} );
		} );
	},

	/** Ouvre / ferme le menu responsive */
	responsive_menu_toggle: function( element ) {
		jQuery( '.wp-digi-sheet-tab-responsive-content' ).toggle( 'fast' );
		jQuery( '.wp-digi-sheet-tab-title' ).toggleClass( 'active' );
	}
};

var digi_installer = {
	event: function() {
		jQuery( document ).on( 'click', '.wpdigi-installer form input[type="button"]', function() { digi_installer.form_groupement( jQuery( this ) ); } );

		/** Ouvrir plus d'options */
		jQuery( document ).on( 'click', '.wpdigi-staff .more-option', function( event ) { digi_installer.toggle_form( event, jQuery( this ) ); } );

		jQuery( document ).on( 'keyup', '.wpdigi-staff .input-domain-mail', function( event ) { digi_installer.keyp_update_email( event, jQuery( this ) ); } );
		jQuery( document ).on( 'keyup', '#wp-digi-form-add-staff input[name="user[option][user_info][lastname]"]', function( event ) { digi_installer.keyp_update_email( event, jQuery( this ) ); } );
		jQuery( document ).on( 'keyup', '#wp-digi-form-add-staff input[name="user[option][user_info][firstname]"]', function( event ) { digi_installer.keyp_update_email( event, jQuery( this ) ); } );
    jQuery( document ).on( 'click', '.wp-digi-action-save-domain-mail', function( event ) { digi_installer.save_domain_mail( event, jQuery( this ) ); } );

		/** Ajouter un personnel */
		jQuery( document ).on( 'click', '.wpdigi-staff .add-staff', function( event ) { digi_installer.add_staff( event, jQuery( this ) ); } );
    /** Modifier un personnel */
    jQuery( document ).on( 'click', '.wpdigi-staff .wp-digi-action-load', function( event ) { digi_installer.load_staff( event, jQuery( this ) ); } );
    jQuery( document ).on( 'click', '.wpdigi-staff .wp-digi-action-edit', function( event ) { digi_installer.edit_staff( event, jQuery( this ) ); } );
    /** Supprimer un personnel */
    jQuery( document ).on( 'click', '.wpdigi-staff .wp-digi-action-delete', function( event ) { digi_installer.delete_staff( event, jQuery( this ) ); } );

		/** Enregister dernière étape */
		jQuery( document ).on( 'click', '.wpdigi-installer div:last a:last', function( event ) { digi_installer.save_last_step( event, jQuery( this ) ); } );

    jQuery( document ).on( 'click', '.btn-more-option', function( event) { digi_installer.toggle_form( event, jQuery( this ) ); } );
  },

	form_groupement: function( element ) {
		jQuery( element ).closest( 'div' ).addClass( "wp-digi-bloc-loading" );
		jQuery( element ).closest( 'form' ).ajaxSubmit( function( response ) {
			jQuery( element ).closest( 'div' ).hide();
			jQuery( '.wpdigi-installer .wpdigi-staff' ).fadeIn();
			jQuery( '.wpdigi-installer ul.step li:first' ).removeClass( 'active' );
			jQuery( '.wpdigi-installer ul.step li:last' ).addClass( 'active' );

      jQuery( '#toplevel_page_digi-setup a' ).attr( 'href', jQuery( '#toplevel_page_digi-setup a' ).attr( 'href' ).replace( 'digi-setup', 'digirisk-simple-risk-evaluation' ) );
    } );

  },

	add_staff: function( event, element ) {
		event.preventDefault();
		if( jQuery( '.wpdigi-staff input[name="option[user_info][lastname]"]' ).val() != '') {
			jQuery( '.wp-digi-list-staff' ).addClass( 'wp-digi-bloc-loading' );
			jQuery( '#wp-digi-form-add-staff' ).ajaxSubmit( {
				beforeSubmit: function() {
					if( !validateEmail( jQuery( '.wpdigi-staff input[name="user[email]"]' ).val() ) ) {
						jQuery( '.wp-digi-list-staff' ).removeClass( 'wp-digi-bloc-loading' );
						return false;
					}
				},
				success: function( response ) {
					jQuery( '.wp-digi-list-staff' ).removeClass( 'wp-digi-bloc-loading' );
					jQuery( '.wp-digi-list-staff' ).append( response.data.template );
					jQuery( '.wpdigi-staff input[name="user[option][user_info][firstname]"]' ).val( "" );
					jQuery( '.wpdigi-staff input[name="user[option][user_info][lastname]"]' ).val( "" );
					jQuery( ".wpdigi-staff input[name='user[email]']" ).val( jQuery( '.wpdigi-staff input[name="user[option][user_info][firstname]"]' ).val() + '.' + jQuery( '.wpdigi-staff input[name="user[option][user_info][lastname]"]' ).val() + '@' + jQuery( '.wpdigi-staff .input-domain-mail' ).val() );
					jQuery( '.wpdigi-staff input[name="user[option][user_info][lastname]"]' ).focus();
				}
			} );
		}
	},

  load_staff: function( event, element ) {
    event.preventDefault();

		var user_id = jQuery( element ).data( 'id' );
		jQuery( '.wp-digi-list-item[data-id="'+ user_id +'"]' ).addClass( 'wp-digi-bloc-loading' );

		var data = {
			action: 'wpdigi-installer-load-user',
			_wpnonce: jQuery( element ).data( 'nonce' ),
			user_id: user_id,
		};

		jQuery.post( ajaxurl, data, function( response ) {
			jQuery( '.wp-digi-list-item[data-id="'+ user_id +'"]' ).removeClass( 'wp-digi-bloc-loading' );
			jQuery( '.wp-digi-list-item[data-id="'+ user_id +'"]' ).replaceWith( response.data.template );
		} );
  },

  edit_staff: function( event, element ) {
    var user_id = jQuery( element ).closest( 'form' ).data( 'id' );
		if( jQuery( element ).closest( 'form' ).find( 'input[name="option[user_info][lastname]"]' ).val() != '') {
			jQuery( element ).closest( 'form' ).addClass( 'wp-digi-bloc-loading' );
			jQuery( element ).closest( 'form' ).ajaxSubmit( {
				beforeSubmit: function() {
					if( !validateEmail( jQuery( element ).closest( 'form' ).find( 'input[name="user[email]"]' ).val() ) ) {
						jQuery( element ).closest( 'form' ).removeClass( 'wp-digi-bloc-loading' );
						return false;
					}
				},
				success: function( response ) {
          jQuery( '.wp-digi-list-item[data-id="'+ user_id +'"]' ).removeClass( 'wp-digi-bloc-loading' );
    			jQuery( '.wp-digi-list-item[data-id="'+ user_id +'"]' ).replaceWith( response.data.template );
				}
			} );
		}
  },

  delete_staff: function( event, element ) {
    event.preventDefault();

    if( confirm( digi_confirm_delete ) ) {
  		var user_id = jQuery( element ).data( 'id' );

  		jQuery( '.wp-digi-list-staff .wp-digi-list-item[data-id="'+ user_id +'"]' ).fadeOut();

  		var data = {
  			action: 'wpdigi-installer-delete-user',
  			_wpnonce: jQuery( element ).data( 'nonce' ),
  			user_id: user_id,
  		};

  		jQuery.post( ajaxurl, data, function() {} );
    }
  },

	toggle_form: function( event, element ) {
		event.preventDefault();
		jQuery( element ).find( '.dashicons' ).toggleClass( 'dashicons-plus dashicons-minus' );
		jQuery( element ).closest( 'div' ).find( 'ul:last' ).toggle();
		jQuery( '.wp-digi-add-staff-from-file' ).toggle();
	},

	keyp_update_email: function( event, element ) {
		jQuery( ".wpdigi-staff input[name='user[email]']" ).val( jQuery( '.wpdigi-staff input[name="user[option][user_info][firstname]"]' ).val() + '.' + jQuery( '.wpdigi-staff input[name="user[option][user_info][lastname]"]' ).val() + '@' + jQuery( '.wpdigi-staff .input-domain-mail' ).val() );

		if( event.keyCode == 13 ) {
			jQuery( ".wpdigi-staff .add-staff" ).click();
		}
	},

  save_domain_mail: function( event, element ) {
    event.preventDefault();

    var data = {
      action: 'save_domain_mail',
      _wpnonce: jQuery( element ).data( 'nonce' ),
      domain_mail: jQuery( element ).closest( '.form-element' ).find( 'input' ).val(),
    };

    jQuery.post( ajaxurl, data, function() { } );
  },

	save_last_step: function( event, element ) {
		jQuery( '.wpdigi-installer .dashicons-plus:last' ).click();
	},

  toggle_form: function( event, element ) {
    event.preventDefault();

    jQuery( element ).closest( 'form' ).find( '.form-more-option' ).toggle();
  }
};

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
				var workunit_for_is_complete = true;
				for (var i=0; i < formData.length; i++) {
			        if (!formData[i].value) {
			        	workunit_for_is_complete = false;
			        }
				}
				if ( workunit_for_is_complete ) {
					jQuery( element ).addClass( "wp-digi-bloc-loading" );
				}
				else {
					alert( "Please fill in all fields" );
          return false;
				}
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

var digi_risk = {

	old_danger: undefined,
	old_date: undefined,

	init: function() {
		digi_risk.event();
		this.old_danger = jQuery( '.wp-digi-risk-item-new toggle' ).html();
		this.old_date = jQuery( '.wp-digi-risk-item-new input[name="risk_comment_date"]' ).val();
	},

	tab_changed: function() {
		this.old_danger = jQuery( '.wp-digi-risk-item-new toggle' ).html();
		this.old_date = jQuery( '.wp-digi-risk-item-new input[name="risk_comment_date"]' ).val();
	},

	event: function() {
		// jQuery( document ).on( 'click', '.wp-digi-list-item .wp-digi-risk-list-column-cotation, .wp-digi-risk-item .wp-digi-risk-list-column-cotation', function() { digi_risk.show_simple_cotation( jQuery( this ) ); } );

		// Quand on clique sur le plus pour créer un risque
		jQuery( document ).on( 'click', '.wp-digi-risk-item-new .dashicons-plus', function( event ) { digi_risk.create_risk( event, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wp-digi-risk .wp-digi-action-delete', function( event ) { digi_risk.delete_risk( event, jQuery( this ) ); } );

		// Quand on clique pour charger un risque
		jQuery( document ).on( 'click', '.wp-digi-risk .wp-digi-action-load', function( event ) { digi_risk.load_risk( event, jQuery( this ) ); } );

		// Quand on clique pour finir l'édition d'un risque
		jQuery( document ).on( 'click', '.wp-digi-risk .wp-digi-action-edit', function( event ) { digi_risk.edit_risk( event, jQuery( this ) ); } );

		// jQuery( document ).on( 'click', '.wp-digi-risk-item-new toggle', function( event ) { digi_risk.toggle_danger( event, jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wp-digi-risk-item-new .wp-digi-select-list li', function( event ) { digi_risk.select_danger( event, jQuery( this ) ); } );

		jQuery( document ).on( 'click', '.wpdigi-method-evaluation-render .row li', function( event ) { digi_risk.select_variable( event, jQuery( this ) ); } );

		jQuery( document ).on( 'click', '.wpdigi-method-evaluation-render .dashicons-no-alt', function( event ) { digi_risk.close_modal( jQuery( this ) ); } );
		jQuery( document ).on( 'click', '.wpdigi-method-evaluation-render .wp-digi-bton-fourth', function( event ) { digi_risk.close_modal( jQuery( this ) ); } );

		jQuery( document ).on( 'click', '.open-method-evaluation-render', function( event ) { digi_risk.open_modal( event, jQuery( this ) ); } );
		// jQuery( document ).mouseup( function( event ) {
		// 	var div = jQuery( '.wp-digi-eval-evarisk > div' );
		//
		// 	if ( div.has( event.target ).length === 0 && jQuery( '.wp-digi-eval-evarisk' ).is( ':visible' ) ) {
		// 		digi_risk.close_modal( jQuery( this ) );
		// 	}
		// } );

		jQuery( document ).on( 'click', 'ul.wp-digi-risk-cotation-chooser li', function( event ) {
			event.preventDefault();

			var new_risk_level_container = jQuery( this ).closest( "span" );
			var new_risk_current_level = new_risk_level_container.attr( "data-risk_level" );

			new_risk_level_container.removeClass( "wp-digi-risk-level-" + new_risk_current_level );
			new_risk_level_container.addClass( "wp-digi-risk-level-" + jQuery( this ).data( "risk_level" ) );
			new_risk_level_container.find( 'div' ).removeClass( "wp-digi-risk-level-" + new_risk_current_level );
			new_risk_level_container.find( 'div' ).html(  jQuery( this ).data( "risk-text" ) );
			new_risk_level_container.find( 'div' ).addClass( "wp-digi-risk-level-" + jQuery( this ).data( "risk_level" ) );
			new_risk_level_container.attr( "data-risk_level", jQuery( this ).data( "risk_level" ) );

			jQuery( this ).closest( 'form' ).find( '.risk-level' ).val( jQuery( this ).data( "value" ) );

			jQuery( this ).closest( '.wp-digi-list-item' ).find( 'input[name="digi_method"]' ).val( jQuery( this ).closest( '.wp-digi-list-item' ).find( 'input.digi-method-simple' ).val() );
		} );

    // Supprimer un commentaire
    jQuery( document ).on( 'click', '.wp-digi-action-comment-delete', function( event ) { digi_risk.delete_comment( event, jQuery( this ) ); } );

	},

	show_simple_cotation: function( element ) {
		if ( !jQuery( element ).find( "ul.wp-digi-risk-cotation-chooser" ).is( ":visible" ) ) {
			jQuery( element ).find( "ul.wp-digi-risk-cotation-chooser" ).show();
		}
		else {
			jQuery( element ).find( "ul.wp-digi-risk-cotation-chooser" ).hide();
		}
	},

	create_risk: function( event, element ) {
		event.preventDefault();

		jQuery( '.wp-digi-risk-item-new' ).addClass( 'wp-digi-bloc-loading' );

		jQuery( element ).closest( 'form' ).ajaxSubmit( {
			'success': function( response ) {
				jQuery( '.wp-digi-risk-item-new' ).removeClass( 'wp-digi-bloc-loading' );
				jQuery( '.wp-digi-risk.wp-digi-list' ).closest( 'div' ).replaceWith( response.data.template );

				// Clean form
				var risk_level = jQuery( ".wp-digi-risk-item-new .wp-digi-risk-list-column-cotation" ).attr( "data-risk_level" );
				jQuery( ".wp-digi-risk-item-new .wp-digi-risk-list-column-cotation" ).attr( "data-risk_level", 1 );
				jQuery( ".wp-digi-risk-item-new .wp-digi-risk-level-new" ).removeClass( "wp-digi-risk-level-" + risk_level ).addClass( "wp-digi-risk-level-1" ).html( "1" );
				jQuery( ".wp-digi-risk-item-new .wp-digi-risk-list-column-cotation" ).removeClass( "wp-digi-risk-level-" + risk_level ).addClass( "wp-digi-risk-level-1" );

				jQuery( '.wp-digi-risk-item-new toggle' ).html( digi_risk.old_danger );

				jQuery( element ).closest( 'form' ).clearForm();

				jQuery( ".wp-digi-risk-item-new input[name='risk_evaluation_level']" ).val( 1 );
				jQuery( ".wp-digi-risk-item-new input[name='risk_comment_date']" ).val( digi_risk.old_date );
				jQuery( ".wp-digi-risk-item-new input[name='risk_danger_id']" ).val( "" );

				digi_global.init();

			}
		} );
	},

	delete_risk: function( event, element ) {
		event.preventDefault();

    if( confirm( digi_confirm_delete ) ) {
  		var risk_id = jQuery( element ).data( 'id' );

  		jQuery( '.wp-digi-risk-item[data-risk-id="'+ risk_id +'"]' ).addClass( 'wp-digi-bloc-loading' );

  		var data = {
  			action: 'wpdigi-delete-risk',
  			_wpnonce: jQuery( element ).data( 'nonce' ),
  			global: jQuery( element ).data( 'global' ),
  			risk_id: risk_id,
  		};

  		jQuery.post( ajaxurl, data, function() {
  			jQuery( '.wp-digi-risk-item[data-risk-id="'+ risk_id +'"]' ).removeClass( 'wp-digi-bloc-loading' );
  			jQuery( '.wp-digi-list .wp-digi-list-item[data-risk-id="' + risk_id + '"]' ).fadeOut();
  		} );
    }
	},

	load_risk: function( event, element ) {
		event.preventDefault();

		var risk_id = jQuery( element ).data( 'id' );
		jQuery( '.wp-digi-risk-item[data-risk-id="'+ risk_id +'"]' ).addClass( 'wp-digi-bloc-loading' );

		var data = {
			action: 'wpdigi-load-risk',
			_wpnonce: jQuery( element ).data( 'nonce' ),
			global: jQuery( element ).data( 'global' ),
			risk_id: risk_id,
		};

		jQuery.post( ajaxurl, data, function( response ) {
			jQuery( '.wp-digi-risk-item[data-risk-id="'+ risk_id +'"]' ).removeClass( 'wp-digi-bloc-loading' );
			jQuery( '.wp-digi-risk .wp-digi-list-item[data-risk-id="' + risk_id + '"]' ).replaceWith( response.data.template );
			jQuery( '.wp-digi-risk .wp-digi-list-item[data-risk-id="' + risk_id + '"] .wpdigi-method-evaluation-render' ).html( response.data.table_evaluation_method );
			jQuery( '.wpdigi_date' ).datepicker( { 'dateFormat': 'dd/mm/yy', } );
		} );
	},

	edit_risk: function( event, element ) {
		event.preventDefault();

		var risk_id = jQuery( element ).data( 'id' );
		jQuery( '.wp-digi-risk-item[data-risk-id="'+ risk_id +'"]' ).addClass( 'wp-digi-bloc-loading' );

		jQuery( element ).closest( 'form' ).ajaxSubmit( {
			'success': function( response ) {
				jQuery( '.wp-digi-risk.wp-digi-list' ).closest( 'div' ).replaceWith( response.data.template );
			}
		} );
	},

	toggle_danger: function( event, element ) {
		jQuery( '.wp-digi-risk-item-new .wp-digi-select-list' ).toggle();
	},

	select_danger: function( event, element ) {
		jQuery( '.wp-digi-risk-item-new input[name="risk_danger_id"]' ).val( jQuery( element ).data( 'id' ) );
		jQuery( '.wp-digi-risk-item-new .wp-digi-select-list' ).toggle();
		jQuery( '.wp-digi-risk-item-new toggle' ).html( jQuery( element ).find( 'img' ).attr( 'title' ) );
	},

	select_variable: function( event, element ) {
		if ( jQuery( element ).data( 'seuil-id' ) != 'undefined' ) {
			jQuery( '.wpdigi-method-evaluation-render .row li[data-variable-id="' + jQuery( element ).data( 'variable-id' ) + '"]' ).removeClass( 'active' );
			jQuery( element ).addClass( 'active' );
			jQuery( '.wpdigi-method-evaluation-render input[name="variable[' + jQuery( element ).data( 'variable-id' ) + ']"]' ).val( jQuery( element ).data( 'seuil-id' ) );
		}
	},

	open_modal: function( event, element ) {
		jQuery( element ).closest( 'form' ).find( '.wp-digi-eval-evarisk' ).show( function() {
			jQuery( element ).closest( 'form' ).find( '.wp-digi-eval-evarisk' ).animate({
				'opacity': 1,
			}, 400);
		} );
		jQuery( element ).closest( 'form' ).find( '.wp-digi-eval-evarisk > div' ).show( function() {
			jQuery( element ).closest( 'form' ).find( '.wp-digi-eval-evarisk > div' ).animate( {
				'top': '50%',
				'opacity': 1,
			}, 400 );
		} );
	},

	close_modal: function( element ) {
		var list_variable = {};
		jQuery( '.wpdigi-method-evaluation-render .wp-digi-eval-evarisk:visible').find( 'input[type="hidden"]:not(.digi-method-evaluation-id)' ).each(function( key, f ) {
			list_variable[jQuery( f ).attr( 'variable-id' )] = jQuery( f ).val();
		} );

		jQuery( '.wpdigi-method-evaluation-render .wp-digi-eval-evarisk > div ' ).animate( {
			'top': '30%',
			'opacity': 0,
		}, 400, function() { jQuery( '.wpdigi-method-evaluation-render .wp-digi-eval-evarisk > div ' ).hide(); } );
		jQuery( '.wpdigi-method-evaluation-render .wp-digi-eval-evarisk' ).animate({
			'opacity': 0,
		}, 400, function() { jQuery( '.wpdigi-method-evaluation-render .wp-digi-eval-evarisk' ).hide(); } );

		var data = {
			action: 'get_value_threshold',
			list_variable: list_variable,
		};

		jQuery.post( ajaxurl, data, function( response ) {
			jQuery( element ).closest( '.wp-digi-list-item' ).find( 'input[name="digi_method"]' ).val( jQuery( element ).closest( '.wpdigi-method-evaluation-render' ).find( 'input.digi-method-evaluation-id' ).val() );
			jQuery( element ).closest( '.wp-digi-list-item' ).find( '.wp-digi-risk-list-column-cotation > div' ).html( response.data.equivalence );
			jQuery( element ).closest( '.wp-digi-list-item' ).find( '.wp-digi-risk-list-column-cotation > div' ).attr( 'class', 'wp-digi-risk-level-' + response.data.scale );
		} );
	},

  delete_comment: function( event, element ) {
    if( confirm( digi_confirm_delete ) ) {
      var data = {
        action: 'delete_comment',
        _wpnonce: jQuery( element ).data( 'nonce' ),
        risk_id: jQuery( element ).data( 'risk-id' ),
        id: jQuery( element ).data( 'id' ),
      };

      jQuery( element ).closest( 'li' ).remove();

      jQuery.post( ajaxurl, data, function() {} );
    }
  }
};

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

				digi_global.init();
			}, 'json');
		}
	},

	identity_edition_mode: function( event, element ) {
		jQuery( ".wp-digi-group-action-container" ).removeClass( "hidden" );
		jQuery( element ).addClass( "active" );

		jQuery( '.wp-digi-societytree-left-container toggle span' ).html( jQuery( element ).val() );
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
		        	jQuery( ".wp-digi-list-item:last" ).click( );
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

var digi_society = {
	event: function() {}
};

var digi_user = {
	old_affected_user: '',

	event: function() {
		jQuery( document ).on( 'keyup', '.wp-list-search input[name="user_name_affected"]', function() { digi_user.search_affected_user( jQuery( this ) ); } );
	},

	search_affected_user: function( element ) {
		if ( digi_user.old_affected_user != jQuery( element ).val() ) {
			digi_user.old_affected_user = jQuery( element ).val();
			if ( jQuery( element ).val().length > 2 ) {
				var new_search = jQuery( element ).val();

				jQuery( element ).closest( 'form' ).ajaxSubmit( function( response ) {
					jQuery( element ).closest( 'div' ).find( '.wp-digi-list' ).replaceWith( response.data.template );
				} );
			}
			else if ( jQuery( element ).val().length <= 0 ) {
				jQuery( element ).closest( 'form' ).ajaxSubmit( function( response ) {
					jQuery( element ).closest( 'div' ).find( '.wp-digi-list' ).replaceWith( response.data.template );
				} );
			}
		}
	}
};

var digi_evaluator = {
	event: function() {
		jQuery( document ).on( 'click', '.wp-digi-evaluator-list input[type="checkbox"]', function() { digi_evaluator.add_time( jQuery( this ) ); } );
	},

	add_time: function( element ) {
		jQuery( element ).closest( 'li' ).find( '.period-assign input' ).val( jQuery( '.wp-digi-evaluator-list .wp-digi-table-header input[type="text"]' ).val() );
	}
};

var digi_recommendation = {
	old_recommendation_name: undefined,
	old_thumbnail: undefined,

	init: function() {
		digi_recommendation.old_recommendation_name = jQuery( '.wp-digi-recommendation-item-new toggle' ).html();
		digi_recommendation.old_thumbnail = jQuery( ".wp-digi-recommendation-item-new .wp-digi-recommendation-thumbnail" ).html();

		digi_recommendation.event();
	},

	tab_changed: function() {
		digi_recommendation.old_recommendation_name = jQuery( '.wp-digi-recommendation-item-new toggle' ).html();
		digi_recommendation.old_thumbnail = jQuery( ".wp-digi-recommendation-item-new .wp-digi-recommendation-thumbnail" ).html();
	},

	event: function() {
		jQuery( document ).on( 'click', '.wp-digi-recommendation-item-new .wp-digi-select-list li', function( event ) { digi_recommendation.select_recommendation( event, jQuery( this ) ); } );

		// Ajouter une recommendation
		jQuery( document ).on( 'click', '.wp-digi-recommendation-item-new .dashicons-plus', function( event ) { digi_recommendation.add_recommendation( event, jQuery( this ) ); } );
		// Charger une recommendation
		jQuery( document ).on( 'click', '.wp-digi-recommendation-item .wp-digi-action-load', function( event ) { digi_recommendation.load_recommendation( event, jQuery( this ) ); } );
		// Editer une recommendation
		jQuery( document ).on( 'click', '.wp-digi-recommendation-item .dashicons-edit', function( event ) { digi_recommendation.edit_recommendation( event, jQuery( this ) ); } );
		// Supprimer une recommendation
		jQuery( document ).on( 'click', '.wp-digi-recommendation-item .wp-digi-action-delete', function( event ) { digi_recommendation.delete_recommendation( event, jQuery( this ) ); } );
	},

	select_recommendation: function( event, element ) {
		jQuery( '.wp-digi-recommendation-item-new input[name=recommendation_id]' ).val( jQuery( element ).data( 'id' ) );
		jQuery( '.wp-digi-recommendation-item-new .wp-digi-select-list' ).toggle();
		jQuery( '.wp-digi-recommendation-item-new .wp-digi-recommendation-thumbnail i' ).hide();
		jQuery( '.wp-digi-recommendation-item-new toggle' ).html( jQuery( element ).data( 'name' ) );
		jQuery( '.wp-digi-recommendation-item-new .wp-digi-recommendation-thumbnail .attachment-digirisk-element-miniature' ).attr( 'src', jQuery( element ).data( 'url' ) ).show();
	},

	add_recommendation: function( event, element ) {
		event.preventDefault();

		jQuery( '.wp-digi-recommendation-item-new' ).addClass( 'wp-digi-bloc-loading' );

		jQuery( element ).closest( 'form' ).ajaxSubmit( {
			'success': function( response ) {
				jQuery( '.wp-digi-recommendation-item-new' ).removeClass( 'wp-digi-bloc-loading' );
				jQuery( '.wp-digi-recommendation.wp-digi-list' ).append( response.data.template );

				// Clear form
				jQuery( '.wp-digi-recommendation-item-new toggle' ).html( digi_recommendation.old_recommendation_name );
				jQuery( '.wp-digi-recommendation-item-new input[name="recommendation_id"]' ).val( "" );
				jQuery( '.wp-digi-recommendation-item-new input[name="recommendation_comment"]' ).val( "" );

				jQuery( ".wp-digi-recommendation-item-new .wp-digi-recommendation-thumbnail" ).html( digi_recommendation.old_thumbnail );

			}
		} );
	},

	load_recommendation: function( event, element ) {
		event.preventDefault();

		var data = {
			action: 'wpdigi-load-recommendation',
			_wpnonce: jQuery( element ).data( 'nonce' ),
			workunit_id: jQuery( element ).data( 'workunit-id' ),
			term_id: jQuery( element ).data( 'id' ),
			index: jQuery( element ).data( 'index' ),
		};

		jQuery.post( ajaxurl, data, function( response ) {
			jQuery( element ).closest( '.wp-digi-recommendation-item' ).replaceWith( response.data.template );
		} );
	},

	edit_recommendation: function( event, element ) {
		jQuery( element ).closest( '.wp-digi-recommendation-item' ).addClass( 'wp-digi-bloc-loading' );

		jQuery( element ).closest( 'form' ).ajaxSubmit( {
			'success': function( response ) {
				jQuery( element ).closest( '.wp-digi-recommendation-item' ).replaceWith( response.data.template );
			}
		} );
	},

	delete_recommendation: function( event, element ) {
		event.preventDefault();

    if( confirm( digi_confirm_delete ) ) {
  		var workunit_id	= jQuery( element ).data( 'workunit-id' );
  		var term_id 	= jQuery( element ).data( 'id' );
  		var index 		= jQuery( element ).data( 'index' );
  		var _wpnonce 	= jQuery( element ).data( 'nonce' );
  		var data = {
  			action: 'wpdigi-delete-recommendation',
  			_wpnonce: _wpnonce,
  			workunit_id: workunit_id,
  			term_id: term_id,
  			index: index,
  		};

  		jQuery( element ).closest( '.wp-digi-recommendation-item' ).fadeOut();

  		jQuery.post( ajaxurl, data, function() {

  		} );
    }
	}
};

var digi_tools = {
  event: function() {
    jQuery( document ).on( 'click', '.reset-method-evaluation', function( event ) { digi_tools.reset( event, jQuery( this ) ); } );
  },

  reset: function( event, element ) {
    event.preventDefault();

    if ( confirm ( digi_tools_confirm ) ) {
      jQuery( element ).addClass( "wp-digi-loading" );
      jQuery( element ).closest( '.wrap' ).find( 'ul' ).html('');

      var li = document.createElement( 'li' );
      li.innerHTML = digi_tools_in_progress;
      jQuery( element ).closest( '.wrap' ).find( 'ul' ).append( li );

      var data = {
        action: 'reset_method_evaluation',
        _wpnonce: jQuery( element ).data( 'nonce' )
      };

      jQuery.post( ajaxurl, data, function() {
        jQuery( element ).removeClass( "wp-digi-loading" );
        li.innerHTML += ' ' + digi_tools_done;
      } );
    }
  }
}
