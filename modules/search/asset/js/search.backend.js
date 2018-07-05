/**
 * Initialise l'objet "search" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.0.0
 */
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
 * @since 6.0.0
 */
window.eoxiaJS.digirisk.search.event = function() {
	jQuery( document ).on( 'click', '.autocomplete-result', window.eoxiaJS.digirisk.search.select );
};

/**
 * Lors de la séléction d'un utilisateur, affectes son ID dans un input caché.
 * Affectes également le "data-result" de l'élement cliqué à l'input
 * ".autocomplete-search-input".
 *
 * @since 7.0.0
 */
window.eoxiaJS.digirisk.search.select = function() {
	jQuery( this ).closest( '.form-element' ).find( 'input[type="hidden"]' ).val( jQuery( this ).data( 'id' ) );
	jQuery( this ).closest( '.form-element' ).find( '.autocomplete-search-input' ).val( jQuery( this ).data( 'result' ) );
};
