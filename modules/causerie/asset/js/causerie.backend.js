/**
 * Initialise l'objet "causerie" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.5.0
 * @version 6.5.0
 */
window.eoxiaJS.digirisk.causerie = {};
window.eoxiaJS.digirisk.causerie.canvas;

window.eoxiaJS.digirisk.causerie.init = function() {
	window.eoxiaJS.digirisk.causerie.event();
};

window.eoxiaJS.digirisk.causerie.refresh = function() {
	window.eoxiaJS.digirisk.causerie.canvas = document.querySelectorAll("canvas");
	for( var i = 0; i < window.eoxiaJS.digirisk.causerie.canvas.length; i++ ) {
		window.eoxiaJS.digirisk.causerie.canvas[i].signaturePad = new SignaturePad( window.eoxiaJS.digirisk.causerie.canvas[i], {
			penColor: "rgb(66, 133, 244)"
		} );
	}
};

window.eoxiaJS.digirisk.causerie.event = function() {
};


/**
 * Le callback en cas de réussite à la requête Ajax "edit_causerie".
 * Remplaces le contenu du tableau par la vue renvoyée par la réponse Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.6.0
 * @version 6.6.0
 */
window.eoxiaJS.digirisk.causerie.editedCauserieSuccess = function( triggeredElement, response ) {
	triggeredElement.closest( 'table.causerie' ).replaceWith( response.data.view );
};

/**
 * Le callback en cas de réussite à la requête Ajax "load_causerie".
 * Remplaces le contenu de la ligne du tableau "causerie" par le template renvoyé par la requête Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.6.0
 * @version 6.6.0
 */
window.eoxiaJS.digirisk.causerie.loadedCauserieSuccess = function( element, response ) {
	jQuery( element ).closest( 'tr' ).replaceWith( response.data.view );
};

/**
 * Le callback en cas de réussite à la requête Ajax "delete_causerie".
 * Supprimes la ligne du tableau.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.6.0
 * @version 6.6.0
 */
window.eoxiaJS.digirisk.causerie.deletedCauserieSuccess = function( element, response ) {
	element.closest( 'tr' ).fadeOut();
};

/**
 * Le callback en cas de réussite à la requête Ajax "start_causerie".
 * Redirige vers la page de la causerie.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.6.0
 * @version 6.6.0
 */
window.eoxiaJS.digirisk.causerie.startedCauserie = function( element, response ) {
	alert('ok');
};
