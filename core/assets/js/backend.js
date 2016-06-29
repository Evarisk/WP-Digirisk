"use strict";

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

jQuery( document ).ready( function(){
	digi_global.init();
	digi_global.event();
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
  			var div = jQuery( this ).closest( parent ).find( '.' + jQuery( this ).data( 'target' ) );
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




var digi_tools = {

  event: function() {
	  jQuery( document ).on( 'click', '.reset-method-evaluation', function( event ) { digi_tools.reset( event, jQuery( this ) ); } );
	  jQuery( document ).on( 'click', '.digi-tools-main-container .nav-tab', function( event ) { digi_tools.tab_switcher( event, jQuery( this ) ); } );
	  jQuery( document ).on( 'click', '.element-risk-compilation', function( event ) { digi_tools.risk_fixer( event, jQuery( this ) ); } );
  },

  tab_switcher: function( event, element ) {
	  event.preventDefault();

	  /**	Remove all calss active on all tabs	*/
	  jQuery( element ).closest( "h2" ).children( ".nav-tab" ).each( function(){
		  jQuery( this ).removeClass( "nav-tab-active" );
	  });
	  /**	Add the active class on clicked tab	*/
	  jQuery( element ).addClass( "nav-tab-active" );

	  /**	Hide the different container and display the selected container	*/
	  jQuery( element ).closest( ".digi-tools-main-container" ).children( "div" ).each( function(){
		  jQuery( this ).hide();
	  });
	  jQuery( "#" + jQuery( element ).attr( "data-id" ) ).show();
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
  },

  risk_fixer: function( event, element ) {
	  event.preventDefault();

      jQuery( element ).addClass( "wp-digi-loading" );
      jQuery( element ).closest( '.wrap' ).find( 'ul' ).html('');

      var li = document.createElement( 'li' );
      li.innerHTML = digi_tools_in_progress;
      jQuery( element ).closest( '.wrap' ).find( 'ul' ).append( li );

      var data = {
        action: 'compil_risk_list',
        _wpnonce: jQuery( element ).data( 'nonce' )
      };

      jQuery.post( ajaxurl, data, function() {
        jQuery( element ).removeClass( "wp-digi-loading" );
        li.innerHTML += ' ' + digi_tools_done;
      } );
  }

}
