window.digirisk.handle_model = {};

window.digirisk.handle_model.init = function() {
	window.digirisk.handle_model.event();
};

/**
 * Les évènements
 *
 * @return {void}
 */
window.digirisk.handle_model.event = function() {};

/**
 * Après la requête AJAX qui ouvre la popup "Historique des modèles"
 *
 * @param  {HTMLAnchorElement} element  Le lien qui permet d'ouvrir la popup
 * @param  {Object}            response Les données de la réponse de la requête XHR
 * @return {void}
 */
window.digirisk.handle_model.popup_historic_loaded = function( element, response ) {
	element.closest( '.block' ).find( '.popup .title' ).text( response.data.title );
	element.closest( '.block' ).find( '.popup .content' ).html( response.data.view );
};
