window.eoxiaJS.digirisk.recommendation = {};

window.eoxiaJS.digirisk.recommendation.init = function() {
	window.eoxiaJS.digirisk.recommendation.event();
};

window.eoxiaJS.digirisk.recommendation.event = function() {
	jQuery( document ).on( 'click', '.table.recommendation .categorie-container.recommendation .item', window.eoxiaJS.digirisk.recommendation.selectRecommendation );
};

/**
 * Lors du clic sur une recommendation, remplace le contenu du toggle par l'image de la recommendation sélectionnée.
 *
 * @param  {ClickEvent} event [description]
 * @return {void}
 *
 * @since 0.1
 * @version 6.2.4.0
 */
window.eoxiaJS.digirisk.recommendation.selectRecommendation = function( event ) {
	var element = jQuery( this );
	element.closest( '.content' ).removeClass( 'active' );
	element.closest( 'tr' ).find( 'input.input-hidden-recommendation' ).val( element.data( 'id' ) );
	element.closest( '.toggle' ).find( '.action span' ).hide();
	element.closest( '.toggle' ).find( '.action img' ).show();
	element.closest( '.toggle' ).find( '.action img' ).attr( 'src', element.find( 'img' ).attr( 'src' ) );
	element.closest( '.toggle' ).find( '.action img' ).attr( 'srcset', '' );
	element.closest( '.toggle' ).find( '.action img' ).attr( 'sizes', '' );

	element.closest( '.recommendation-row' ).find( '.categorie-container' ).removeClass( 'active' );
	event.stopPropagation();

	element.closest( 'tr' ).find( '.action .button.disable' ).removeClass( 'disable' ).addClass( 'blue' );
};

/**
 * Vérifie que le champs "taxonomy[digi-recommendation][] soit différent de -1".
 *
 * @param  {HTMLDivElement} triggeredElement L'élément déclenchant l'action.
 * @return {bool}                            Si true, le formulaire est envoyé. Si false, on annule l'envoie du formulaire.
 *
 * @since 0.1
 * @version 6.2.4.0
 */
window.eoxiaJS.digirisk.recommendation.beforeSaveRecommendation = function( triggeredElement ) {

	// Remet à 0 les styles.
	triggeredElement.closest( '.recommendation-row' ).find( '.categorie-container' ).removeClass( 'active' );

	// Vérification du danger.
	if ( '-1' === triggeredElement.closest( '.recommendation-row' ).find( 'input[name="taxonomy[digi-recommendation][]"]' ).val() ) {
		triggeredElement.closest( '.recommendation-row' ).find( '.categorie-container' ).addClass( 'active' );
		return false;
	}

	return true;
};

/**
 * Le callback en cas de réussite à la requête Ajax "save_recommendation".
 * Remplaces le contenu du tableau "recommendation" par le template renvoyé par la requête Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.eoxiaJS.digirisk.recommendation.savedRecommendationSuccess = function( element, response ) {
	jQuery( 'table.recommendation' ).replaceWith( response.data.template );
	window.eoxiaJS.digirisk.date.init();
};

/**
 * Le callback en cas de réussite à la requête Ajax "load_recommendation".
 * Remplaces le contenu de la ligne du tableau "recommendation" par le template renvoyé par la requête Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.eoxiaJS.digirisk.recommendation.loadedRecommendationSuccess = function( element, response ) {
	jQuery( element ).closest( 'tr' ).replaceWith( response.data.template );
	window.eoxiaJS.digirisk.date.init();
};

/**
 * Le callback en cas de réussite à la requête Ajax "delete_recommendation".
 * Supprimes la ligne du tableau affectée par l'action.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.eoxiaJS.digirisk.recommendation.deletedRecommendationSuccess = function( element, response ) {
	jQuery( element ).closest( 'tr' ).fadeOut();
};
