"use strict";

var digi_evaluator = {
	$: undefined,
	event: function( $ ) {
		digi_evaluator.$ = $;

		digi_evaluator.$( document ).on( 'click', '.wp-digi-evaluator-list input[type="checkbox"]', function() { digi_evaluator.add_time( digi_evaluator.$( this ) ); } );
    digi_evaluator.$( document ).on ('click', '.wp-form-evaluator-to-assign input[type="submit"]', function( evt ) { digi_evaluator.add_evaluator( evt, digi_evaluator.$( this ) ); } );
    digi_evaluator.$( document ).on ('click', '.wp-digi-list-evaluator .wp-digi-action-delete', function( evt ) { digi_evaluator.delete_evaluator( evt, digi_evaluator.$( this ) ); } );
		digi_evaluator.$( document ).on( 'click', '.wp-form-evaluator-to-assign .wp-digi-pagination a', function( event ) { digi_evaluator.pagination( event, digi_evaluator.$( this ) ); } );
	},

	add_time: function( element ) {
		digi_evaluator.$( element ).closest( 'li' ).find( '.period-assign input' ).val( digi_evaluator.$( '.wp-digi-evaluator-list .wp-digi-table-header input[type="text"]' ).val() );
	},

  add_evaluator: function( event, element ) {
    event.preventDefault();

    digi_evaluator.$( '.wp-digi-list-evaluator' ).addClass( 'wp-digi-bloc-loading' );

    digi_evaluator.$( element ).closest( 'form' ).ajaxSubmit( function( response ) {
      digi_evaluator.$( '.wp-digi-list-evaluator' ).replaceWith( response.data.template );
    } );
  },

  delete_evaluator: function( event, element ) {
    event.preventDefault();

    if( window.confirm( window.digi_confirm_delete ) ) {
      digi_evaluator.$( '.wp-digi-list-evaluator' ).addClass( 'wp-digi-bloc-loading' );

      var data = {
        action: 'detach_evaluator',
        id: digi_evaluator.$( element ).data( 'id' ),
        user_id: digi_evaluator.$( element ).data( 'user-id' ),
        global: digi_evaluator.$( element ).data( 'global' ),
        affectation_id: digi_evaluator.$( element ).data( 'affectation-data-id' ),
      };

      digi_evaluator.$.post( window.ajaxurl, data, function( response ) {
        digi_evaluator.$( '.wp-digi-list-evaluator' ).replaceWith( response.data.template );
      } );
    }
  },

	pagination: function( event, element ) {
		event.preventDefault();

		var href = digi_evaluator.$( element ).attr( 'href' ).split( '&' );
		var next_page = href[1].replace('current_page=', '');
		var element_id = href[2].replace('element_id=', '');

		var data = {
			action: 'paginate_evaluator',
			element_id: element_id,
			next_page: next_page
		};

		digi_evaluator.$( '.wp-form-evaluator-to-assign' ).load( window.ajaxurl, data, function() {} );
	}
};
