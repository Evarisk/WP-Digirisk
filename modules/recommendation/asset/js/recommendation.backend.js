window.eoxiaJS.digirisk.recommendation = {};

window.eoxiaJS.digirisk.recommendation.init = function() {
	window.eoxiaJS.digirisk.recommendation.event();
};

window.eoxiaJS.digirisk.recommendation.event = function() {
	jQuery( document ).on( 'click', '.table.recommendation .categorie-container .item', window.eoxiaJS.digirisk.recommendation.selectRecommendation );
};

/**
 * Lors du clic sur une recommendation, remplace le contenu du toggle par l'image de la recommendation sélectionnée.
 *
 * @since   6.0.0
 * @version 7.0.0
 *
 * @param  {ClickEvent} event [description]
 * @return {void}
 */
window.eoxiaJS.digirisk.recommendation.selectRecommendation = function( event ) {
	var element = jQuery( this );

	element.closest( '.content' ).removeClass( 'active' );
	element.closest( 'tr' ).find( 'input[name="recommendation_category_id"]' ).val( element.data( 'id' ) );

	element.closest( '.wpeo-dropdown' ).find( '.dropdown-toggle span' ).hide();
	element.closest( '.wpeo-dropdown' ).find( '.dropdown-toggle img' ).show();
	element.closest( '.wpeo-dropdown' ).find( '.dropdown-toggle img' ).attr( 'src', element.find( 'img' ).attr( 'src' ) );
	element.closest( '.wpeo-dropdown' ).find( '.dropdown-toggle img' ).attr( 'srcset', '' );
	element.closest( '.wpeo-dropdown' ).find( '.dropdown-toggle img' ).attr( 'sizes', '' );
	element.closest( '.wpeo-dropdown' ).find( '.dropdown-toggle img' ).attr( 'aria-label', element.closest( '.tooltip' ).attr( 'aria-label' ) );

	element.closest( '.row' ).find( '.categorie-container.tooltip' ).removeClass( 'active' );

	// Rend le bouton "active".
	element.closest( 'tr' ).find( '.action .wpeo-button.button-disable' ).removeClass( 'button-disable' );
};

/**
 * Vérifie que le champs "taxonomy[digi-recommendation][] soit différent de -1".
 *
 * @since 6.0.0
 * @version 7.0.0
 *
 * @param  {HTMLDivElement} triggeredElement L'élément déclenchant l'action.
 * @return {bool}                            Si true, le formulaire est envoyé. Si false, on annule l'envoie du formulaire.
 */
window.eoxiaJS.digirisk.recommendation.beforeSaveRecommendation = function( triggeredElement ) {

	// Remet à 0 les styles.
	triggeredElement.closest( '.recommendation-row' ).find( '.categorie-container' ).removeClass( 'active' );

	// Vérification du danger.
	if ( '-1' === triggeredElement.closest( '.recommendation-row' ).find( 'input[name="recommendation_category_id"]' ).val() ) {
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
