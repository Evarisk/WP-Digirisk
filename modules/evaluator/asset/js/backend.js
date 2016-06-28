"use strict"

jQuery( document ).ready( function() {
	digi_evaluator.event();
} );


var digi_evaluator = {
	event: function() {
		jQuery( document ).on( 'click', '.wp-digi-evaluator-list input[type="checkbox"]', function() { digi_evaluator.add_time( jQuery( this ) ); } );
    jQuery( document ).on ('click', '.wp-form-evaluator-to-assign input[type="submit"]', function( evt ) { digi_evaluator.add_evaluator( evt, jQuery( this ) ); } );
    jQuery( document ).on ('click', '.wp-digi-list-evaluator .wp-digi-action-delete', function( evt ) { digi_evaluator.delete_evaluator( evt, jQuery( this ) ); } );
	},

	add_time: function( element ) {
		jQuery( element ).closest( 'li' ).find( '.period-assign input' ).val( jQuery( '.wp-digi-evaluator-list .wp-digi-table-header input[type="text"]' ).val() );
	},

  add_evaluator: function( event, element ) {
    event.preventDefault();

    jQuery( '.wp-digi-list-evaluator' ).addClass( 'wp-digi-bloc-loading' );

    jQuery( element ).closest( 'form' ).ajaxSubmit( function( response ) {
      jQuery( '.wp-digi-list-evaluator' ).replaceWith( response.data.template );
    } );
  },

  delete_evaluator: function( event, element ) {
    event.preventDefault();

    if( confirm( digi_confirm_delete ) ) {
      jQuery( '.wp-digi-list-evaluator' ).addClass( 'wp-digi-bloc-loading' );

      var data = {
        action: 'detach_evaluator',
        id: jQuery( element ).data( 'id' ),
        user_id: jQuery( element ).data( 'user-id' ),
        global: jQuery( element ).data( 'global' ),
        affectation_id: jQuery( element ).data( 'affectation-data-id' ),
      };

      jQuery.post( ajaxurl, data, function( response ) {
        jQuery( '.wp-digi-list-evaluator' ).replaceWith( response.data.template );
      } );
    }
  }
};
