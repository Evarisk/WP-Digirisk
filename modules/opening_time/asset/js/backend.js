"use strict"

jQuery( document ).ready(function() {
  di_opening_time.event();
});

var di_opening_time = {
  event: function() {
    jQuery( '.di-opening-time .time-picker' ).timepicker( { 'timeFormat': 'H:i' } );
    jQuery( '.di-opening-time' ).on( 'change', 'input[type="text"]', function( event ) { di_opening_time.change_time_picker( event, jQuery( this ) ); } );
    jQuery( '.di-opening-time' ).on( 'change', 'input[type="checkbox"]', function( event ) { di_opening_time.change_checkbox( event, jQuery( this ) ); } );
  },

  change_time_picker: function( event, element ) {
    var type = jQuery( element ).data( 'type' );
    jQuery( element ).closest('div').find( 'input[type="text"].' + type ).val ( jQuery( element ).val() );
  },

  change_checkbox: function( event, element ) {
    jQuery( element ).closest( 'div' ).find( 'ul' ).toggle();
  }
};
