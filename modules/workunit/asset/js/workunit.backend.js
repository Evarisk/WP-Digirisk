window.eoxiaJS.digirisk.workunit = {};

window.eoxiaJS.digirisk.workunit.init = function() {
	window.eoxiaJS.digirisk.workunit.event();
};

/**
 * Initialise deux évènements:
 * -Lorque qu'une touche du clavier est remontée dans le champ de texte pour ajouter une nouvelle unité de travail.
 * -Lorsque qu'un clic est effectué sur unité de travail dans le menu de navigation.
 *
 * @return {void}
 *
 * @since 0.1
 * @version 6.2.4.0
 */
window.eoxiaJS.digirisk.workunit.event = function() {
	jQuery( document ).on( 'keyup', '.digirisk-wrap .workunit-add input[type="text"]', window.eoxiaJS.digirisk.workunit.keyEnterSendForm );
	jQuery( document ).on( 'click', '.digirisk-wrap .workunit-list span[data-action="load_society"]', window.eoxiaJS.digirisk.workunit.setActive );
};

/**
 * Cette méthode clic sur le bouton "add" lorsque la touche "entrée" est remontée afin d'ajouter une unité de travail.
 *
 * @param  {KeyboardEvent} event Contient toutes les valeurs du clavier lorsqu'une touche remonte.
 * @return void
 *
 * @since 0.1
 * @version 6.2.4.0
 */
window.eoxiaJS.digirisk.workunit.keyEnterSendForm = function( event ) {
	if ( 13 === event.keyCode ) {
		jQuery( '.digirisk-wrap .workunit-add .add' ).click();
	}
};

/**
 * Le callback en cas de réussite à la requête Ajax "save_workunit".
 * Remplace le template de l'application en entier et clique sur la nouvelle unité de travail pour la charger.
 *
 * @param  {HTMLDivElement} triggeredElement L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response         Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 0.1
 * @version 6.2.4.0
 */
window.eoxiaJS.digirisk.workunit.saved_workunit_success = function( triggeredElement, response ) {
	jQuery( '.digirisk-wrap' ).replaceWith( response.data.template );
	jQuery( '.workunit-list .unit-header[data-workunit-id="' + response.data.id + '"] span[data-action="load_society"]' ).click();
};

/**
 * Ajoutes la classe "active" à l'unité de travail cliquée.
 *
 * @param {ClickEvent} event Contient toutes les valeurs de la souris lors du clic sur l'élément.
 *
 * @since 0.1
 * @version 6.2.4.0
 */
window.eoxiaJS.digirisk.workunit.setActive = function( event ) {
	jQuery( '.digirisk-wrap .workunit-list li.active' ).removeClass( 'active' );
	jQuery( this ).closest( 'li' ).addClass( 'active' );
};
