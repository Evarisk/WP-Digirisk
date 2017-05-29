window.eoxiaJS.digirisk.search = {};

window.eoxiaJS.digirisk.search.init = function() {
	window.eoxiaJS.digirisk.search.event();
};

window.eoxiaJS.digirisk.search.tabChanged = function() {
	window.eoxiaJS.digirisk.search.event();
};

window.eoxiaJS.digirisk.search.renderChanged = function() {
	window.eoxiaJS.digirisk.search.event();
};

/**
 * Initialise l'évènement pour permettre aux champs de recherche de fonctionner
 *
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.eoxiaJS.digirisk.search.event = function() {
	/**
	* Paramètre à ajouter sur la balise html
	* int data-element-id : ID d'un élément ex: workunit_id
	* string data-callback : Pour appeler une fonction après avoir récupére la liste des ID des utilisateurs.
	* string append-to : Le bloc ou sera affiche le rendu
	*/
	jQuery.each( jQuery( '.search input, .digi-search' ), function( key, element ) {
		// Automatiser la source.
		var listOption = {
			'source': 'admin-ajax.php?action=digi_search' +
			'&next_action=' + jQuery( element ).data( 'next-action' ) +
			'&field=' + jQuery( element ).data( 'field' ) +
			'&class=' + jQuery( element ).data( 'class' ) +
			'&id=' + jQuery( element ).data( 'id' ) +
			'&type=' + jQuery( element ).data( 'type' ),
			'minLength': 0
		};

		if ( jQuery( element ).data( 'target' ) ) {
			listOption.search = function( event, ui ) {
				jQuery( '.' + jQuery( element ).data( 'target' ) ).addClass( 'loading' );
			};

			listOption.response = function( event, response ) {
				jQuery( '.' + jQuery( element ).data( 'target' ) ).replaceWith( response.content[1].template );
			};

			listOption.open = function( event, ui ) {
				jQuery( element ).autocomplete( 'close' );
			};
		}

		if ( jQuery( element ).data( 'field' ) ) {
			listOption.select = function( event, ui ) {
				jQuery( 'input[name="' + jQuery( element ).data( 'field' ) + '"]' ).val( ui.item.id );
			};
		}

		jQuery( element ).autocomplete( listOption );
	} );
};
