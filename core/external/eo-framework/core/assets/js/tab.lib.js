/**
 * @namespace EO_Framework_Tab
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*
 * Gestion des onglets.
 *
 * @since 1.0.0
 * @version 1.0.0
 */

if ( ! window.eoxiaJS.tab ) {

	/**
	 * [tab description]
	 *
	 * @memberof EO_Framework_Tab
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.tab = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Tab
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.tab.init = function() {
		window.eoxiaJS.tab.event();
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Tab
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.tab.event = function() {
	  jQuery( document ).on( 'click', '.wpeo-tab li.tab-element:not(.wpeo-dropdown)', window.eoxiaJS.tab.load );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Tab
	 *
	 * @param  {void} event [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.tab.load = function( event ) {
		var tabTriggered = jQuery( this );
		var data = {};
		var key;

	  event.preventDefault();
		event.stopPropagation();

		tabTriggered.closest( '.wpeo-tab' ).find( '.tab-element.tab-active' ).removeClass( 'tab-active' );
		tabTriggered.addClass( 'tab-active' );

		if ( ! tabTriggered.attr( 'data-action' ) ) {
			tabTriggered.closest( '.wpeo-tab' ).find( '.tab-content.tab-active' ).removeClass( 'tab-active' );
			tabTriggered.closest( '.wpeo-tab' ).find( '.tab-content[id="' + tabTriggered.attr( 'data-target' ) + '"]' ).addClass( 'tab-active' );
		} else {
			data = {
				action: tabTriggered.attr( 'data-action' ),
				_wpnonce: tabTriggered.attr( 'data-nonce' ),
				target: tabTriggered.attr( 'data-target' ),
				title: tabTriggered.attr( 'data-title' ),
				element_id: tabTriggered.attr( 'data-id' )
			};

			tabTriggered.get_data( function( attrData ) {
				for ( key in attrData ) {
					if ( ! data[key] ) {
						data[key] = attrData[key];
					}
				}

				window.eoxiaJS.loader.display( tabTriggered );
				window.eoxiaJS.loader.display( tabTriggered.closest( '.wpeo-tab' ).find( '.tab-content' ) );

				jQuery.post( window.ajaxurl, data, function( response ) {
					window.eoxiaJS.loader.remove( tabTriggered );
					tabTriggered.closest( '.wpeo-tab' ).find( '.tab-content.tab-active' ).removeClass( 'tab-active' );
					tabTriggered.closest( '.wpeo-tab' ).find( '.tab-content' ).addClass( 'tab-active' );
					tabTriggered.closest( '.wpeo-tab' ).find( '.tab-content' ).html( response.data.view );
					window.eoxiaJS.loader.remove( tabTriggered.closest( '.wpeo-tab' ).find( '.tab-content' ) );

					window.eoxiaJS.tab.callTabChanged();
				} );
			} );
		}

	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Tab
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.tab.callTabChanged = function() {
		var key = undefined, slug = undefined;
		for ( key in window.eoxiaJS ) {

			if ( window.eoxiaJS && window.eoxiaJS[key] && window.eoxiaJS[key].tabChanged ) {
				window.eoxiaJS[key].tabChanged();
			}

			for ( slug in window.eoxiaJS[key] ) {

				if ( window.eoxiaJS && window.eoxiaJS[key] && window.eoxiaJS[key][slug].tabChanged ) {
					window.eoxiaJS[key][slug].tabChanged();
				}
			}
		}
	};
}
