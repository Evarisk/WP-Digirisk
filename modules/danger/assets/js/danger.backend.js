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
		digi_danger.$( document ).on( 'click', '.wp-digi-risk-item-new .wp-digi-select-list li', function( event ) { digi_danger.select_danger( event, digi_danger.$( this ) ); } );
	},

	select_danger: function( event, element ) {
		digi_danger.$( '.wp-digi-risk-item-new input[name="danger_id"]' ).val( digi_danger.$( element ).data( 'id' ) );
		digi_danger.$( '.wp-digi-risk-item-new toggle span' ).html( digi_danger.$( element ).find( 'img' ).attr( 'title' ) );
	},

	reset_create_form: function() {
		digi_danger.$( '.wp-digi-risk-item-new toggle' ).html( digi_danger.old_danger );
		digi_danger.$( '.wp-digi-risk-item-new input[name="danger_id"]').val( '' );
	}
};
