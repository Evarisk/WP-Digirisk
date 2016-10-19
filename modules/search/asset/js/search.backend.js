window.digirisk.search = {};

window.digirisk.search.init = function() {
	window.digirisk.search.event();
};

window.digirisk.search.tab_changed = function() {
	window.digirisk.search.event();
};

window.digirisk.search.render_changed = function() {
	window.digirisk.search.event();
};

window.digirisk.search.event = function() {
	/**
	* Paramètre à ajouter sur la balise html
	* Ne pas oublier la classe : wp-digi-bloc-loader
	* int data-element-id : ID d'un élément ex: workunit_id
	* string data-callback : Pour appeler une fonction après avoir récupére la liste des ID des utilisateurs.
	* string append-to : Le bloc ou sera affiche le rendu
	*/

	jQuery.each( jQuery( '.wp-list-search input' ), function( key, element ) {
		// Automatiser la source
		var list_option = {
			'source': 'admin-ajax.php?action=digi_search'
								+ '&next_action='	+ jQuery( element ).data( "next-action" )
								// + '&field=' 			+ jQuery( element ).data( 'field' )
								+ '&class=' 			+ jQuery( element ).data( 'class' )
								+ '&id=' 					+ jQuery( element ).data( "id" )
								+ '&type=' 				+ jQuery( element ).data( "type" ),
			'minLength': 0,
		};

		if ( jQuery ( element ).data( 'target' ) ) {
			list_option.search = function( event, ui ) {
				jQuery( '.' + jQuery( element ).data( 'target' ) ).addClass( 'wp-digi-bloc-loading' );
			};

			list_option.response = function( event, response ) {
				jQuery( '.' + jQuery( element ).data( 'target' ) ).replaceWith( response.content[1].template );
			};

			list_option.open = function( event, ui ) {
				jQuery( element ).autocomplete( 'close' );
			};
		}

		if( jQuery( element ).data( 'field' ) ) {
			list_option.select = function( event, ui ) {
				// jQuery( 'input[name="' + jQuery( element ).data('field') + '"]' ).val( ui.item.id );
				// digi_global.$( '.wp-digi-group-action-container' ).removeClass( "hidden" );
	    	// digi_global.$( '.wp-digi-group-action-container .wp-digi-bton-fourth' ).text( 'Déplacer' );
			};
		}

		jQuery( element ).autocomplete( list_option );
	} );
};
