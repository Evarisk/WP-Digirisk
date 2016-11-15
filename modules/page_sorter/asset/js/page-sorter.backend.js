window.digirisk.page_sorter = {};
window.digirisk.page_sorter.init = function() {
	jQuery( '.sorter-page ul' ).sortable( {
		opacity: "0.5",
		placeholder: "ui-state-highlight",
		forcePlaceholderSize: true,
		connectWith: '.sorter-page ul',
		update: window.digirisk.page_sorter.send_request,
	}	);
};

window.digirisk.page_sorter.send_request = function( event, ui ) {
	if ( this === ui.item.parent()[0] ) {
		var parent_id = jQuery( ui )[0].item.closest( 'ul.child' ).data( 'id' );
		var item_id = jQuery( ui )[0].item.data( 'id' );

		var data = {
			action: "sorter_parent",
			_wpnonce: jQuery( '.sorter-page #_wpnonce' ).val(),
			parent_id: parent_id,
			id: item_id
		};

		// Envoie de la requête
		jQuery.post( ajaxurl, data, function() {
			jQuery( '.sorter-page .updated' ).show();
			setTimeout( function() {
				jQuery( '.sorter-page .updated' ).fadeOut();
			}, 2000 );
		} );
	}
};
