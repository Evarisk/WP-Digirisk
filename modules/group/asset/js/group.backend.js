/**
 * Initialise l'objet "group" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 1.0
 * @version 6.2.4.0
 */

window.digirisk.group = {};

window.digirisk.group.init = function() {};

window.digirisk.group.callback_create_group = function( element, response ) {
	jQuery( ".wp-digi-societytree-main-container" ).replaceWith( response.data.template );
	jQuery( '.wp-digi-develop-list span.action-attribute[data-groupment-id="' + response.data.groupment_id + '"]' ).click();
};
