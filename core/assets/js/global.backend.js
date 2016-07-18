"use strict";

var digi_global = {
	$: undefined,

	init: function( $ ) {
		digi_global.$ = $;

		digi_global.$( '.wpdigi_date' ).datepicker( {
			'dateFormat': 'dd/mm/yy',
		} );

		/** Auto complete */
		/**
		* Paramètre à ajouter sur la balise html
		* Ne pas oublier la classe : wp-digi-bloc-loader
		* int data-element-id : ID d'un élément ex: workunit_id
		* string data-callback : Pour appeler une fonction après avoir récupére la liste des ID des utilisateurs.
		* string append-to : Le bloc ou sera affiche le rendu
		*/
		digi_global.$.each( digi_global.$( '.wpdigi-auto-complete-user' ), function( key, element ) {
			var list_option = {
				'source': 'admin-ajax.php?action=search_user&element_id=' + digi_global.$( element ).data( "element-id" ) + '&filter=' + digi_global.$( element ).data( "filter" ),
				'minLength': 0,
			};

			if ( digi_global.$ ( element ).data( 'append-to' ) !== undefined ) {
				list_option.search = function( event, ui ) {
					digi_global.$( digi_global.$ ( element ).data( 'append-to' ) ).addClass( 'wp-digi-bloc-loading' );
				};

				list_option.response = function( event, ui ) {
					digi_global.$( digi_global.$ ( element ).data( 'append-to' ) ).replaceWith( ui.content[0].value );
				};

				list_option.open = function( event, ui ) {
					digi_global.$ ( element ).autocomplete( 'close' );
				};

			}

      if( digi_global.$( element ).data( 'target' ) !== undefined ) {
        list_option.select = function( event, ui ) {
          digi_global.$( 'input[name="' + digi_global.$( element ).data('target') + '"]' ).val( ui.item.id );
        };
      }

			digi_global.$( element ).autocomplete( list_option );
		} );

		digi_global.$.each( digi_global.$( '.wpdigi-auto-complete' ), function( key, element ) {
		digi_global.$( element ).autocomplete( {
			'source': 'admin-ajax.php?action=search&post_type=digi-group&element_id=' + digi_global.$( element ).data( 'id' ),
			'select': function( event, ui ) {
				digi_global.$( 'input[name="' + digi_global.$( element ).data('target') + '"]' ).val( ui.item.id );
				digi_global.$( '.wp-digi-group-action-container' ).removeClass( "hidden" );
        digi_global.$( '.wp-digi-group-action-container .wp-digi-bton-fourth' ).text( 'Déplacer' );
			}
		} );
	} );
	},

	event: function() {
		digi_global.$( document ).on( 'click', 'toggle, .digi-toggle', function( event ) {
			event.stopPropagation();
			var element = digi_global.$( this );
      var parent = digi_global.$( this ).data( 'parent' );
			var div = undefined;
			
      if( parent !== undefined ) {
  			div = digi_global.$( this ).closest( '.' + parent ).find( '.' + digi_global.$( this ).data( 'target' ) );
      }
      else {
        div = digi_global.$( this ).parent().find( '.' + digi_global.$( this ).data( 'target' ) );
      }

			digi_global.$( '.digi-popup' ).each( function() {
				if ( digi_global.$( this ).has( event.target ).length === 0 && digi_global.$( this ).is( ':visible' ) && !digi_global.$( this ).hasClass( element.data( 'target' ) ) ) {
					digi_global.$( this ).hide();
				}
			} );

			div.toggle();
		} );

		digi_global.$( document ).on( 'click', function( event ) {
			digi_global.$( '.digi-popup' ).each( function() {
				if ( digi_global.$( this ).has( event.target ).length === 0 && digi_global.$( this ).is( ':visible' ) ) {
					digi_global.$( this ).toggle();
				}
			} );
		} );
	},

	/** Ouvre / ferme le menu responsive */
	responsive_menu_toggle: function( element ) {
		digi_global.$( '.wp-digi-sheet-tab-responsive-content' ).toggle( 'fast' );
		digi_global.$( '.wp-digi-sheet-tab-title' ).toggleClass( 'active' );
	}
};
