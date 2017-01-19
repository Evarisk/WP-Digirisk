window.digirisk.tab = {};

window.digirisk.tab.init = function() {
	window.digirisk.tab.event();
};

/**
 * Ajoutes l'évènement du clique sur ".tab-element"
 *
 * @return {void}
 *
 * @since 0.1
 * @version 6.2.4.0
 */
window.digirisk.tab.event = function() {
  jQuery( document ).on( 'click', '.tab-element', window.digirisk.tab.load );
};

window.digirisk.tab.load = function( event ) {
	var a = jQuery( this );
	var data = {};

	event.preventDefault();

	jQuery( this ).closest( '.content' ).removeClass( 'active' );

	// Pour éviter que ça réouvre le toggle.
	event.stopPropagation();

	if ( ! a.hasClass( 'no-tab' ) && a.data( 'action' ) ) {
		jQuery( '.tab .tab-element.active' ).removeClass( 'active' );
		a.addClass( 'active' );

		data = {
			action: 'load_tab_content',
			_wpnonce: a.data( 'nonce' ),
			tab_to_display: a.data( 'action' ),
			title: a.data( 'title' ),
			element_id: a.data( 'id' )
	  };

		jQuery( '.main-content' ).addClass( 'loading' );

		jQuery.post( window.ajaxurl, data, function( response ) {
			jQuery( '.main-content' ).replaceWith( response.data.template );

			window.digirisk.tab.call_tab_changed();
		} );
	}
};

window.digirisk.tab.call_tab_changed = function() {
	for ( var key in window.digirisk ) {
		if (window.digirisk[key].tab_changed) {
			window.digirisk[key].tab_changed();
		}
	}
}
