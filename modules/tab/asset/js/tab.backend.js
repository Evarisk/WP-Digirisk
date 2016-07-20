"use strict";

var digi_tab = {
	$: undefined,
  event: function( $ ) {
		digi_tab.$ = $;

    digi_tab.$( ".wp-digi-societytree-right-container" ).on( "click", ".wp-digi-global-sheet-tab li", function( event ) { digi_tab.click_tab( event, digi_tab.$( this ) ); } );
  },

  click_tab: function( event, element ) {
    event.preventDefault();

		if ( !digi_tab.$( element ).hasClass( "disabled" ) ) {
			var action = digi_tab.$( element ).data( "action" );
			digi_tab.$( ".wp-digi-global-sheet-tab li.active" ).removeClass( "active" );
			digi_tab.$( element ).addClass( "active" );

			digi_tab.$( ".wp-digi-content" ).addClass( "wp-digi-bloc-loading" );

			var data = {
				"action": "load_tab_content",
        "_wpnonce": digi_tab.$( element ).data( 'nonce' ),
        "tab_to_display": action,
				"element_id" : digi_tab.$( element ).closest( '.wp-digi-sheet' ).data( 'id' ),
			};
			digi_tab.$.post( window.ajaxurl, data, function( response ){
        digi_tab.$( ".wp-digi-content" ).removeClass( "wp-digi-bloc-loading" );
				digi_tab.$( ".wp-digi-content" ).html( response.data.template );
				window.digi_global.init( digi_tab.$ );
				window.digi_search.event( digi_tab.$ );

				var object_name = action.replace( '-', '_' );
				if ( window[object_name] && window[object_name].init ) {
					window[object_name].init( false, digi_tab.$ );
				}
			}, 'json');
		}
  }
};
