/**
 * Initialise l'objet "handleModel" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.0.0
 * @version 6.3.0
 */

window.eoxiaJS.digirisk.handleModel = {};

/**
 * Keep the button in memory.
 *
 * @type {Object}
 */
window.eoxiaJS.digirisk.handleModel.currentButton;

/**
 * Keep the media frame in memory.
 * @type {Object}
 */
window.eoxiaJS.digirisk.handleModel.mediaFrame;

/**
 * Keep the selected media in memory.
 * @type {Object}
 */
window.eoxiaJS.digirisk.handleModel.selectedInfos = {
	JSON: undefined,
	fileID: undefined
};

window.eoxiaJS.digirisk.handleModel.init = function() {
	window.eoxiaJS.digirisk.handleModel.event();
};

/**
 * Les évènements
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.handleModel.event = function() {
	jQuery( document ).on( 'click', '.digi-tools-main-container .upload-model', window.eoxiaJS.digirisk.handleModel.openMediaFrame );
};

/**
 * Open the media frame from WordPress.
 *
 * @return void
 *
 * @since 6.3.0
 * @version 6.3.0
 */
window.eoxiaJS.digirisk.handleModel.openMediaFrame = function() {
	window.eoxiaJS.digirisk.handleModel.currentButton = jQuery( this );
	window.eoxiaJS.digirisk.handleModel.mediaFrame = new window.wp.media.view.MediaFrame.Post({
		library: {
			type: 'application/vnd.oasis.opendocument.text'
		}
	}).open();
	window.eoxiaJS.digirisk.handleModel.mediaFrame.on( 'insert', function() { window.eoxiaJS.digirisk.handleModel.selectedFile(); } );
};

/**
 * Get the media selected and call associateFile.
 *
 * @return void
 *
 * @since 6.3.0
 * @version 6.3.0
 */
window.eoxiaJS.digirisk.handleModel.selectedFile = function() {
	window.eoxiaJS.digirisk.handleModel.mediaFrame.state().get( 'selection' ).map( function( attachment ) {
		window.eoxiaJS.digirisk.handleModel.selectedInfos.JSON = attachment.toJSON();
		window.eoxiaJS.digirisk.handleModel.selectedInfos.id = attachment.id;
	} );
	window.eoxiaJS.digirisk.handleModel.associateFile();
};

/**
 * Make request for associate file
 *
 * @return void
 *
 * @since 6.3.0
 * @version 6.3.0
 */
window.eoxiaJS.digirisk.handleModel.associateFile = function() {
	var data = {
		action: 'set_model',
		type: window.eoxiaJS.digirisk.handleModel.currentButton.data( 'type' ),
		file_id: window.eoxiaJS.digirisk.handleModel.selectedInfos.id
	};

	window.eoxiaJS.loader.display( window.eoxiaJS.digirisk.handleModel.currentButton );

	jQuery.post( window.ajaxurl, data, function( response ) {
		jQuery( '#digi-handle-model' ).html( response.data.view );
	} );
};

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
	element.closest( '.block' ).find( 'li:first a' ).attr( 'href', response.data.url );
};
