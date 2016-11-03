window.digirisk.tab = {};

window.digirisk.tab.init = function() {
	window.digirisk.tab.event();
};

window.digirisk.tab.event = function() {
  jQuery( document ).on( 'click', '.wp-digi-global-sheet-tab li, .tab', window.digirisk.tab.load );
};

window.digirisk.tab.load = function( event ) {
  event.preventDefault();
  var a = jQuery( this );

  jQuery( ".wp-digi-global-sheet-tab li.active" ).removeClass( "active" );
  a.addClass( "active" );

  jQuery( ".wp-digi-content" ).addClass( "wp-digi-bloc-loading" );

  var data = {
    action:           "load_tab_content",
    _wpnonce:         a.data( 'nonce' ),
    tab_to_display:   a.data( "action" ),
    element_id :      a.closest( '.wp-digi-sheet' ).data( 'id' ),
  };

  jQuery.post( window.ajaxurl, data, function( response ) {
    jQuery( ".wp-digi-content" ).replaceWith( response.data.template );

		window.digirisk.tab.call_tab_changed();
  } );
};

window.digirisk.tab.call_tab_changed = function() {
	for ( var key in window.digirisk ) {
		if (window.digirisk[key].tab_changed) {
			window.digirisk[key].tab_changed();
		}
	}
}
