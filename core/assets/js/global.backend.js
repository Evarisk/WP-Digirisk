"use strict";

var digi_global = {
	$: undefined,

	init: function( $ ) {
		digi_global.$ = $;

		digi_global.$( '.wpdigi_date' ).datepicker( {
			'dateFormat': 'dd/mm/yy',
		} );
	},

	event: function() {
		digi_global.$( document ).on( 'click', 'toggle, .digi-toggle', function( event ) {
			event.stopPropagation();
			var element = digi_global.$( this );
      var parent = digi_global.$( this ).data( 'parent' );
			var div;

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
	},

	download_file: function( url_to_file, filename ) {
		var url = digi_global.$('<a href="' + url_to_file + '" download="' + filename + '"></a>');
		digi_global.$('.wrap').append(url);
		url[0].click();
		url.remove();
	}
};
