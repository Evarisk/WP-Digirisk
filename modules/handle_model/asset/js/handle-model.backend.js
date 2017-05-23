/**
 * Initialise l'objet "handleModel" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 1.0
 * @version 6.2.5.0
 */

window.eoxiaJS.digirisk.handleModel = {};

window.eoxiaJS.digirisk.handleModel.init = function() {
	window.eoxiaJS.digirisk.handleModel.event();
};

/**
 * Les évènements
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.handleModel.event = function() {};

/**
 * Après la requête AJAX qui ouvre la popup "Historique des modèles"
 *
 * @param  {HTMLAnchorElement} element  Le lien qui permet d'ouvrir la popup
 * @param  {Object}            response Les données de la réponse de la requête XHR
 * @return {void}
 */
window.eoxiaJS.digirisk.handleModel.loadedPopupHistoric = function( element, response ) {
	element.closest( '.block' ).find( '.popup .title' ).text( response.data.title );
	element.closest( '.block' ).find( '.popup .content' ).html( response.data.view );
	jQuery( '.container.loading' ).removeClass( 'loading' );
};

/**
 * Met à jour le bouton "Télécharger le modèle courant" de response.data.type
 * @param {HTMLAnchorElement} element  Le lien "Télécharger le modèle courant"
 * @param {void}
 */
window.eoxiaJS.digirisk.handleModel.reset_default_model_success = function( element, response ) {
	element.closest( '.block' ).find( '.wp-digi-bton-second' ).attr( 'href', response.data.url );
};
