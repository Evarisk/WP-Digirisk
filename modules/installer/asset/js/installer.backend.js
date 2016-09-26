"use strict";

var digi_installer = {
	$: undefined,
	event: function($) {
		digi_installer.$ = $;
		digi_installer.$( document ).on( 'click', '.wpdigi-installer form input[type="button"]', function() { digi_installer.form_groupement( digi_installer.$( this ) ); } );
		digi_installer.$( document ).on( 'click', '.wpdigi-installer .btn-more-option', function( event ) { digi_installer.toggle_form( event, digi_installer.$( this ) ); } );
  },

	form_groupement: function( element ) {
		digi_installer.$( element ).closest( 'form' ).ajaxSubmit( {
			'beforeSubmit': function() {
				if ( digi_installer.$( '.wpdigi-installer input[name="groupement[title]"]' ).val() === '' ) {
					digi_installer.$( '.wpdigi-installer input[name="groupement[title]"]' ).css( 'border-bottom', 'solid red 2px' );
					return false;
				}

				digi_installer.$( element ).closest( 'div' ).addClass( "wp-digi-bloc-loading" );
				digi_installer.$( '.wpdigi-installer input[name="groupement[title]"]' ).css( 'border-bottom', '2px solid #272a35' );
			},
			'success': function( response ) {
				digi_installer.$( element ).closest( 'div' ).hide();
				digi_installer.$( '.wpdigi-installer .wpdigi-staff' ).fadeIn();
				digi_installer.$( '.wpdigi-installer ul.step li:first' ).removeClass( 'active' );
				digi_installer.$( '.wpdigi-installer ul.step li:last' ).addClass( 'active' );
	      digi_installer.$( '#toplevel_page_digi-setup a' ).attr( 'href', digi_installer.$( '#toplevel_page_digi-setup a' ).attr( 'href' ).replace( 'digi-setup', 'digirisk-simple-risk-evaluation' ) );
	    }
		} );

  },

	save_last_step: function( event, element ) {
		digi_installer.$( '.wpdigi-installer .dashicons-plus:last' ).click();
	},

  toggle_form: function( event, element ) {
    event.preventDefault();

		digi_installer.$( element ).find( '.dashicons' ).toggleClass( 'dashicons-plus dashicons-minus' );
    digi_installer.$( element ).closest( 'form' ).find( '.form-more-option' ).toggle();
  }
};
