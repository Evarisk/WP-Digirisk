/**
 * Initialise l'objet "setting" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.0.0
 */
window.eoxiaJS.digirisk.setting = {};

window.eoxiaJS.digirisk.setting.init = function() {
	window.eoxiaJS.digirisk.setting.event();
};

window.eoxiaJS.digirisk.setting.event = function() {
	jQuery( document ).on( 'click', '#digi-danger-preset .save-all', window.eoxiaJS.digirisk.setting.savePresetRisks );
	jQuery( document ).on( 'click', '#digi-danger-preset .wpeo-table .table-row input:not(input[type="checkbox"]), #digi-danger-preset .table-row .toggle, #digi-danger-preset .dropdown-toggle, #digi-danger-preset .table-row textarea, #digi-danger-preset .table-row .popup, #digi-danger-preset .table-row .action', window.eoxiaJS.digirisk.setting.checkTheCheckbox );
	jQuery( document ).on( 'click', '.digirisk_page_digirisk-setting .list-users .wp-digi-pagination a', window.eoxiaJS.digirisk.setting.pagination );
	jQuery( document ).on( 'click', '.section-capability input[type="checkbox"]', window.eoxiaJS.digirisk.setting.activeSave );

	jQuery( document ).on( 'click', '.wpeo-notification .notification-close', window.eoxiaJS.digirisk.setting.closeWpeo );
	jQuery( document ).on( 'keyup', '#digi-accronym input[type="text"], #digi-htpasswd input, #digi-data input', window.eoxiaJS.digirisk.setting.buttonSave );

	jQuery( document ).on( 'click', '.section-capability .all', window.eoxiaJS.digirisk.setting.checkAllCapability );
	jQuery( document ).on( 'click', '.section-capability .one', window.eoxiaJS.digirisk.setting.uncheckAllCase );
};

window.eoxiaJS.digirisk.setting.savePresetRisks = function( event ) {
	if ( event ) {
		event.preventDefault();
	}

	if ( jQuery( '#digi-danger-preset .table-row.risk-row.edit.checked .save.action-input' ).length ) {
		window.eoxiaJS.loader.display( jQuery( '#digi-danger-preset .save-all' ) );
		jQuery( '#digi-danger-preset .table-row.risk-row.edit.checked .save.action-input' ).click();
	}
};


/**
 * Gestion de la pagination des utilisateurs.
 *
 * @param  {ClickEvent} event [description]
 *
 * @since 6.4.0
 */
window.eoxiaJS.digirisk.setting.pagination = function( event ) {
	var href = jQuery( this ).attr( 'href' ).split( '&' );
	var nextPage = href[2].replace( 'current_page=', '' );

	jQuery( '.list-users' ).addClass( 'loading' );

	var data = {
		action: 'paginate_setting_page_user',
		next_page: nextPage,
		s: jQuery( '.autocomplete-search-input' ).val()
	};

	event.preventDefault();

	jQuery.post( window.ajaxurl, data, function( view ) {
		jQuery( '.settings-users-content' ).replaceWith( view );
		window.eoxiaJS.digirisk.search.renderChanged();
	} );
};


/**
 * Coches la case à cocher lors de l'action dans une ligne du tableau.
 *
 * @param  {ClickEvent} event L'état du clic.
 * @return {void}
 *
 * @since 6.2.3
 */
window.eoxiaJS.digirisk.setting.checkTheCheckbox = function( event ) {
	jQuery( this ).closest( '.table-row.risk-row.edit' ).addClass( 'checked' );
	jQuery( '#digi-danger-preset .save-all' ).removeClass( 'button-disable' ).addClass( 'green' );
};

window.eoxiaJS.digirisk.setting.savedRiskSuccess = function( element, response ) {
	if ( jQuery( '#digi-danger-preset .table-row.risk-row.edit.checked .save.action-input' ).length <= 1 ) {
		window.eoxiaJS.loader.remove( jQuery( '#digi-danger-preset .save-all' ) );
	}

	jQuery( element ).closest( '.table-row' ).replaceWith( response.data.template );
};


/**
 * Le callback en cas de réussite à la requête Ajax "save_capacity".
 * Affiches le message de "success".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.4.0
 */
window.eoxiaJS.digirisk.setting.savedCapability = function( triggeredElement, response ) {
	jQuery( '.section-capability .action-input' ).addClass( 'button-disable' );
};

/**
 * Le callback en cas de réussite à la requête Ajax "general_settings".
 * Affiches le message de "success".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 6.4.0
 */
window.eoxiaJS.digirisk.setting.generalSettingsSaved = function( triggeredElement, response ) {
	document.location.href = response.data.url;
};

window.eoxiaJS.digirisk.setting.activeSave = function( event ) {
	jQuery( this ).closest( '.section-capability' ).find( '.wpeo-button.button-blue' ).removeClass( 'button-disable' );
}

window.eoxiaJS.digirisk.setting.savePrefixSettingsDigiriskSuccess = function( triggeredElement, response ) {
	if( response.data.text_info != "" ){
		var notif_element = triggeredElement.closest( '.tab-content' ).find( '.prefix-response-success' );
		notif_element.show( '50' );
		notif_element.find( '.notification-title' ).html( response.data.text_info );
		triggeredElement.closest( '.tab-content' ).find( '.save-prefix' ).addClass( 'button-disable' );
	}
}
window.eoxiaJS.digirisk.setting.saveDefaultValuesSettingsDigiriskSuccess = function( triggeredElement, response ) {
	if( response.data.text_info != "" ){
		var notif_element = triggeredElement.closest( '.tab-content' ).find( '.default-values-response-success' );
		notif_element.show( '50' );
		notif_element.find( '.notification-title' ).html( response.data.text_info );
		triggeredElement.closest( '.tab-content' ).find( '.save-default-values' ).addClass( 'button-disable' );
	}
}

window.eoxiaJS.digirisk.setting.closeWpeo = function( event ){
	jQuery( this ).closest( '.wpeo-notification' ).hide( '200' );
}

window.eoxiaJS.digirisk.setting.buttonSave = function( event ){
	jQuery( this ).closest( '.tab-content ').find( '.button-disable' ).removeClass( 'button-disable' );
	jQuery( '#digi-accronym .prefix-response-success' ).hide( '200' );
	jQuery( '#digi-data .default-values-response-success' ).hide( '200' );

}

/**
 * Le callback en cas de réussite à la requête Ajax "save_htpasswd".
 * Affiches le message de "success".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 7.5.0
 */
window.eoxiaJS.digirisk.setting.savedHtpasswd = function( triggeredElement, response ) {
	jQuery( '.section-htpasswd' ).replaceWith( response.data.view );
};

/**
 * Le callback en cas de réussite à la requête Ajax "delete_parent_site".
 * Affiches le message de "success".
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 7.5.0
 */
window.eoxiaJS.digirisk.setting.deletedParentSite = function( triggeredElement, response ) {
	triggeredElement.closest( '.table-row' ).fadeOut();
};

window.eoxiaJS.digirisk.setting.savedChildSettings = function( triggeredElement, response ) {
	window.location.href = response.data.url;
};

window.eoxiaJS.digirisk.setting.checkAllCapability = function( event ) {
	if ( jQuery( this ).is( ':checked' ) ) {
		jQuery(this).closest('.user-row').find('input[type="checkbox"]').each(function () {
			jQuery(this).prop('checked', true);
		} );
	} else {
		jQuery(this).closest('.user-row').find('input[type="checkbox"]').each(function () {
			jQuery(this).prop('checked', false);
		} );
	}
};

window.eoxiaJS.digirisk.setting.uncheckAllCase = function ( event ) {
	jQuery( this ).closest( '.user-row' ).find( '.all' ).prop( 'checked', false );
};
