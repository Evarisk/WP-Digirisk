"use strict";

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

var digi_global = {
	init: function() {
		jQuery( '.wpdigi_date' ).datepicker( {
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
        jQuery( '.wp-digi-group-action-container .wp-digi-bton-fourth' ).text( 'Déplacer' );
			}
		} );
	} );
	},

	event: function() {
		jQuery( document ).on( 'click', 'toggle, .digi-toggle', function( event ) {
			event.stopPropagation();
			var element = jQuery( this );
      var parent = jQuery( this ).data( 'parent' );
      if( parent != undefined ) {
  			var div = jQuery( this ).closest( '.' + parent ).find( '.' + jQuery( this ).data( 'target' ) );
      }
      else {
        var div = jQuery( this ).parent().find( '.' + jQuery( this ).data( 'target' ) );
      }

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
