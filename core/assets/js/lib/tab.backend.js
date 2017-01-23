window.digirisk.tab = {};

window.digirisk.tab.init = function() {
	window.digirisk.tab.event();
};

window.digirisk.tab.event = function() {
  jQuery( document ).on( 'click', '.tab-element', window.digirisk.tab.load );
};

window.digirisk.tab.load = function( event ) {
	var tabTriggered = jQuery( this );
	var data = {};

  event.preventDefault();
	event.stopPropagation();

	tabTriggered.closest( '.content' ).removeClass( 'active' );

	if ( ! tabTriggered.hasClass( 'no-tab' ) && tabTriggered( 'action' ) ) {
		jQuery( '.tab .tab-element.active' ).removeClass( 'active' );

		data = {
			action: 'load_tab_content',
			_wpnonce: tabTriggered.data( 'nonce' ),
			tab_to_display: tabTriggered.data( 'action' ),
			element_id: tabTriggered.data( 'id' )
	  };

		jQuery.post( window.ajaxurl, data, function( response ) {
			jQuery( '.' + tabTriggered.data( 'target' ) ).replaceWith( response.data.template );

			window.digirisk.tab.callTabChanged();
		} );

	}

};

window.digirisk.tab.callTabChanged = function() {
	var key = undefined;
	for ( key in window.digirisk ) {
		if ( window.digirisk[key].tabChanged ) {
			window.digirisk[key].tabChanged();
		}
	}
};
