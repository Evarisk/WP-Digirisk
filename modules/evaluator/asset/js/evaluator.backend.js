window.digirisk.evaluator = {};

window.digirisk.evaluator.init = function() {
	window.digirisk.evaluator.event();
};

window.digirisk.evaluator.event = function() {
	jQuery( document ).on( 'click', '.digirisk-wrap table.evaluators input[type="checkbox"]', window.digirisk.evaluator.set_time );
	jQuery( document ).on( 'click', '.wp-form-evaluator-to-assign .wp-digi-pagination a', window.digirisk.evaluator.pagination );
};

/**
 * Lorsque que l'utilisateur coche la checkbox "affecter", la valeur dans le champ de texte du header du tableau est remplis dans le champs à gauche de la checkbox.
 *
 * @param {MouseEvent} event Le clique de la souris
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.digirisk.evaluator.set_time = function( event ) {
	var element = jQuery( this );
	element.closest( 'tr' ).find( 'input.affect' ).val( jQuery( '.table.evaluators input[type="text"]' ).val() );
};

/**
 * Le callback en cas de réussite à la requête Ajax "edit_evaluator_assign".
 * Remplaces le contenu du tableau "affected-evaluator" par le template renvoyé par la requête Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax
 * @param  {Object}         response          Les données renvoyées par la requête Ajax
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.digirisk.evaluator.callback_edit_evaluator_assign_success = function( triggeredElement, response ) {
	jQuery( 'table.affected-evaluator' ).replaceWith( response.data.template );
};

/**
 * Le callback en cas de réussite à la requête Ajax "detach_evaluator".
 * Remplaces le contenu du tableau "affected-evaluator" par le template renvoyé par la requête Ajax.
 *
 * @param  {HTMLAnchorElement} triggeredElement  L'élement HTML déclenchant la requête Ajax
 * @param  {Object}            response          Les données renvoyées par la requête Ajax
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.digirisk.evaluator.callback_detach_evaluator_success = function( triggeredElement, response ) {
	jQuery( 'table.affected-evaluator' ).replaceWith( response.data.template );
};

/**
 * Gestion de la pagination des évalateurs.
 *
 * @param  {[type]} event [description]
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.digirisk.evaluator.pagination = function( event ) {
	var href = jQuery( this ).attr( 'href' ).split( '&' );
	var nextPage = href[1].replace( 'current_page=', '' );
	var elementId = href[2].replace( 'element_id=', '' );

	var data = {
		action: 'paginate_evaluator',
		element_id: elementId,
		next_page: nextPage
	};

	event.preventDefault();

	jQuery( '.wp-digi-content' ).load( window.ajaxurl, data );
};
