"use strict"

jQuery( document ).ready( function() {
  digi_tab.event();
} );

var digi_tab = {
  event: function() {
    jQuery( ".wp-digi-societytree-right-container" ).on( "click", ".wp-digi-global-sheet-tab li", function( event ) { digi_tab.click_tab( event, jQuery( this ) ); } );
  },

  click_tab: function( event, element ) {
    event.preventDefault();

		if ( !jQuery( element ).hasClass( "disabled" ) ) {
			var action = jQuery( element ).data( "action" );
			jQuery( ".wp-digi-global-sheet-tab li.active" ).removeClass( "active" );
			jQuery( element ).addClass( "active" );

			jQuery( ".wp-digi-content" ).addClass( "wp-digi-bloc-loading" );

			var data = {
				"action": "load_tab_content",
        "_wpnonce": jQuery( element ).data( 'nonce' ),
        "tab_to_display": action,
				"element_id" : jQuery( element ).closest( '.wp-digi-sheet' ).data( 'id' ),
			};
			jQuery.post( ajaxurl, data, function( response ){
        jQuery( ".wp-digi-content" ).removeClass( "wp-digi-bloc-loading" );
				jQuery( ".wp-digi-content" ).html( response.data.template );

				var object_name = action.replace( '-', '_' );
				if ( window[object_name] && window[object_name].init ) {
					window[object_name].init(false);
				}
			}, 'json');
		}
  }
};
