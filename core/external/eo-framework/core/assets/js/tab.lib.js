if ( ! window.eoxiaJS.tab ) {
	window.eoxiaJS.tab = {};

	window.eoxiaJS.tab.init = function() {
		window.eoxiaJS.tab.event();
	};

	window.eoxiaJS.tab.event = function() {
	  jQuery( document ).on( 'click', '.tab-element', window.eoxiaJS.tab.load );
	};

	window.eoxiaJS.tab.load = function( event ) {
		var tabTriggered = jQuery( this );
		var data = {};

	  event.preventDefault();
		event.stopPropagation();

		tabTriggered.closest( '.content' ).removeClass( 'active' );

		if ( ! tabTriggered.hasClass( 'no-tab' ) && tabTriggered.data( 'action' ) ) {
			jQuery( '.tab .tab-element.active' ).removeClass( 'active' );
			tabTriggered.addClass( 'active' );

			data = {
				action: 'load_tab_content',
				_wpnonce: tabTriggered.data( 'nonce' ),
				tab_to_display: tabTriggered.data( 'action' ),
				title: tabTriggered.data( 'title' ),
				element_id: tabTriggered.data( 'id' )
		  };

			jQuery( '.' + tabTriggered.data( 'target' ) ).addClass( 'loading' );

			jQuery.post( window.ajaxurl, data, function( response ) {
				jQuery( '.' + tabTriggered.data( 'target' ) ).replaceWith( response.data.template );

				window.eoxiaJS.tab.callTabChanged();
			} );

		}

	};

	window.eoxiaJS.tab.callTabChanged = function() {
		var key = undefined, slug = undefined;
		for ( key in window.eoxiaJS ) {
			for ( slug in window.eoxiaJS[key] ) {
				if ( window.eoxiaJS[key][slug].tabChanged ) {
					window.eoxiaJS[key][slug].tabChanged();
				}
			}
		}
	};
}
