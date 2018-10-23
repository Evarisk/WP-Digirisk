/**
 * Initialise l'objet "search" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 */

window.eoxiaJS.search = {};

/**
 * Init func.
 *
 *
 * @since 1.1.0
 */
window.eoxiaJS.search.init = function() {
	window.eoxiaJS.search.event();
};

/**
 * Event func.
 *
 * @since 1.1.0
 */
window.eoxiaJS.search.event = function() {
	jQuery( document ).on( 'click', '.autocomplete-result', window.eoxiaJS.search.select );
};


/**
 * Lors de la séléction d'un utilisateur, affectes son ID dans un input caché.
 * Affectes également le "data-result" de l'élement cliqué à l'input
 * ".autocomplete-search-input".
 *
 * @since 1.1.0
 */
window.eoxiaJS.search.select = function() {
	jQuery( this ).closest( '.form-element' ).find( 'input[type="hidden"]' ).val( jQuery( this ).data( 'id' ) );
	jQuery( this ).closest( '.form-element' ).find( '.autocomplete-search-input' ).val( jQuery( this ).data( 'result' ) );

	jQuery( this ).closest( '.wpeo-autocomplete' ).trigger( 'change', {
		element: jQuery( this ),
	} );
};
