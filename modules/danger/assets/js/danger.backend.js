"use strict";

var digi_danger = {
	old_danger: undefined,
	$: undefined,

	init: function( event, $ ) {
		digi_danger.$ = $;

		if ( event || event === undefined ) {
			digi_danger.event();
		}

		this.old_danger = digi_danger.$( '.wp-digi-risk-item-new toggle' ).html();
	},

	event: function( $ ) {
		digi_danger.$( document ).on( 'click', '.form-risk .wp-digi-select-list li', function( event ) { digi_danger.select_danger( event, digi_danger.$( this ) ); } );
	},

	select_danger: function( event, element ) {
		digi_danger.$( '.form-risk input.input-hidden-danger' ).val( digi_danger.$( element ).data( 'id' ) );
		digi_danger.$( '.form-risk toggle span' ).html( digi_danger.$( element ).find( 'img' ).attr( 'title' ) );
	},

	reset_create_form: function() {
		digi_danger.$( '.form-risk toggle' ).html( digi_danger.old_danger );
		digi_danger.$( '.form-risk input.input-hidden-danger' ).val( '' );
	}
};
