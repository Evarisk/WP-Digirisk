/**
 * @namespace EO_Framework_Auto_Complete
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/**
 * Gestion du dropdown.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
 /**
  * Gestion du dropdown.
  *
  * @since 1.0.0
  * @version 1.0.0
  */
 if ( ! window.eoxiaJS.autoComplete  ) {

 	/**
 	 * [autoComplete description]
 	 *
 	 * @memberof EO_Framework_Auto_Complete
 	 *
 	 * @type {Object}
 	 */
 	window.eoxiaJS.autoComplete = {};

 	/**
 	 * [description]
 	 *
 	 * @memberof EO_Framework_Auto_Complete
 	 *
 	 * @returns {void} [description]
 	 */
 	window.eoxiaJS.autoComplete.init = function() {
 		window.eoxiaJS.autoComplete.event();
 	};

 	/**
 	 * [description]
 	 *
 	 * @memberof EO_Framework_Auto_Complete
 	 *
 	 * @returns {void} [description]
 	 */
 	window.eoxiaJS.autoComplete.event = function() {
 		jQuery( document ).on( 'keyup', '.wpeo-autocomplete input', window.eoxiaJS.autoComplete.keyUp );
 		jQuery( document ).on( 'click', '.wpeo-autocomplete .autocomplete-icon-after', window.eoxiaJS.autoComplete.deleteContent );
 		jQuery( document ).on( 'click', 'body .wpeo-autocomplete input', window.eoxiaJS.autoComplete.preventClic );
 		jQuery( document ).on( 'click', 'body', window.eoxiaJS.autoComplete.close );
 	};

 	/**
 	 * Make request when keyUp.
 	 *
 	 * @memberof EO_Framework_Auto_Complete
 	 *
 	 * @since 1.0.0
 	 * @version 1.0.0
 	 *
 	 * @param  {KeyboardEvent} event Status of keyboard when keyUp event.
 	 *
 	 * @returns {void}
 	 */
 	window.eoxiaJS.autoComplete.keyUp = function(event) {
 		var element = jQuery( this );
 		var parent  = element.closest( '.wpeo-autocomplete' );
 		var label   = element.closest( '.autocomplete-label' );

 		// If is not a letter or a number, stop func.
 		if ( ! (event.which <= 90 && event.which >= 48 ) && event.which != 8 &&  event.which <= 96 && event.which >= 105  ) {
 			return;
 		}

 		parent.find( 'input.eo-search-value' ).val( '' );

 		// If empty searched value, stop func.
 		if ( element.val().length === 0 ) {
 			parent.removeClass( 'autocomplete-full' );
 			return;
 		} else {

 			// Add this class for display the empty button.
 			if ( ! parent.hasClass( 'autocomplete-full' ) ) {
 				parent.addClass( 'autocomplete-full' );
 			}
 		}

 		// If already request in queue, abort it.
 		if ( parent[0].xhr ) {
 			parent[0].xhr.abort();
 		}

 		var data = {
 			action: parent.attr( 'data-action' ),
 			_wpnonce: parent.attr( 'data-nonce' ),
 			term: element.val(),
 			slug: parent.find( 'input[name="slug"]' ).val(),
 			args: parent.find( 'textarea' ).val()
 		};

 		window.eoxiaJS.autoComplete.initProgressBar( parent, label );
 		window.eoxiaJS.autoComplete.handleProgressBar( parent, label );

 		parent.get_data( function( attribute_data ) {
 			for (var key in attribute_data) {
 					if ( ! data[key] ) {
 						data[key] = attribute_data[key];
 					}
 			}

 			parent[0].xhr = window.eoxiaJS.request.send( jQuery( this ), data, function( triggeredElement, response ) {
 				window.eoxiaJS.autoComplete.clear( parent, label );

 				parent.addClass( 'autocomplete-active' );
 				parent.find( '.autocomplete-search-list' ).addClass( 'autocomplete-active' );

 				if ( response.data && response.data.view && ! response.data.output ) {
 					parent.find( '.autocomplete-search-list' ).html( response.data.view );
 				} else if (response.data && response.data.view && response.data.output ) {
 					jQuery( response.data.output ).replaceWith( response.data.view );
 				}
 			} );
 		} );
 	};

 	/**
 	 * Delete the content and result list.
 	 *
 	 * @memberof EO_Framework_Auto_Complete
 	 *
 	 * @since 1.0.0
 	 * @version 1.0.0
 	 *
 	 * @param  {void} event [description]
 	 * @returns {void}       [description]
 	 */
 	window.eoxiaJS.autoComplete.deleteContent = function( event ) {
 		var element = jQuery( this );
 		var parent  = element.closest( '.wpeo-autocomplete' );
 		var label   = element.closest( '.autocomplete-label' );

 		parent.find( 'input' ).val( '' );
 		parent.find( 'input[type=hidden]' ).change();
 		parent.find( 'input' ).trigger( 'keyUp' );

 		parent.removeClass( 'autocomplete-active' );
 		parent.removeClass( 'autocomplete-full' );
 		parent.find( '.autocomplete-search-list' ).removeClass( 'autocomplete-active' );

 		if ( parent[0].xhr ) {
 			parent[0].xhr.abort();
 			window.eoxiaJS.autoComplete.clear(parent, label);
 		}
 	};

 	/**
 	 * Permet de ne pas fermer la liste des résultats si on clic sur le champ de recherche.
 	 *
 	 * @memberof EO_Framework_Auto_Complete
 	 *
 	 * @since 1.0.0
 	 * @version 1.0.0
 	 *
 	 * @param  {MouseEvent} event [description]
 	 * @return {void}       [description]
 	 */
 	window.eoxiaJS.autoComplete.preventClic = function( event ) {
 		event.stopPropagation();
 	}

 	/**
 	 * Close result list
 	 *
 	 * @memberof EO_Framework_Auto_Complete
 	 *
 	 * @since 1.0.0
 	 * @version 1.0.0
 	 *
 	 * @param  {void} event [description]
 	 * @returns {void}       [description]
 	 */
 	window.eoxiaJS.autoComplete.close = function( event ) {
 		jQuery( '.wpeo-autocomplete.autocomplete-active' ).each ( function() {
 			jQuery( this ).removeClass( 'autocomplete-active' );
 			jQuery( this ).find( '.autocomplete-search-list' ).removeClass( 'autocomplete-active' );
 		} );
 	};

 	/**
 	 * Handle progress bar.
 	 *
 	 * @memberof EO_Framework_Auto_Complete
 	 *
 	 * @since 1.0.0
 	 * @version 1.0.0
 	 *
 	 * @param {} parent
 	 * @param {} label
 	 *
 	 * @returns {void}
 	 */
 	window.eoxiaJS.autoComplete.initProgressBar = function( parent, label ) {
 		// Init two elements for loading bar.
 		if ( label.find( '.autocomplete-loading').length == 0 ) {
 			var el = jQuery( '<span class="autocomplete-loading"></span>' );
 			label[0].autoCompleteLoading = el;
 			label.append( label[0].autoCompleteLoading );

 			var elBackground = jQuery( '<span class="autocomplete-loading-background"></span>' );
 			label[0].autoCompletedLoadingBackground = elBackground;
 			label.append( label[0].autoCompletedLoadingBackground );
 		}
 	};

 	/**
 	 * Handle with of the progress bar.
 	 *
 	 * @since 1.0.0
 	 * @version 1.0.0
 	 *
 	 * @memberof EO_Framework_Auto_Complete
 	 *
 	 * @param {} parent
 	 * @param {} label
 	 *
 	 * @returns {void}
 	 */
 	window.eoxiaJS.autoComplete.handleProgressBar = function( parent, label ) {
 		parent.find( '.autocomplete-loading' ).css({
 			width: '0%'
 		});

 		setTimeout(function() {
 			parent.find( '.autocomplete-loading' ).css({
 				width: '5%'
 			});
 		}, 10 );

 		label[0].currentTime = 5;

 		if ( ! label[0].interval ) {
 			label[0].interval = setInterval( function() {
 				label[0].currentTime += 3;

 				if ( label[0].currentTime >= 90 ) {
 					label[0].currentTime = 90;
 				}

 				label.find( '.autocomplete-loading' ).css({
 					width: label[0].currentTime + '%',
 				});
 			}, 1000 );
 		}
 	};

 	/**
 	 * Clear data of the autocomplete.
 	 *
 	 * @since 1.0.0
 	 * @version 1.0.0
 	 *
 	 * @memberof EO_Framework_Auto_Complete
 	 *
 	 * @param {} parent
 	 * @param {} label
 	 *
 	 * @returns {void}
 	 */
 	window.eoxiaJS.autoComplete.clear = function( parent, label ) {
 		if ( label[0] ) {
 			clearInterval(label[0].interval);
 			label[0].interval = undefined;
 		}

 		if ( parent[0] ) {
 			parent[0].xhr = undefined;
 		}

 		parent.find( '.autocomplete-search-list' ).html( '' );
 		parent.find( '.autocomplete-loading' ).css({
 			width: '100%',
 		});

 		setTimeout( function() {
 			jQuery( label[0].autoCompleteLoading ).remove();
 			jQuery( label[0].autoCompletedLoadingBackground ).remove();
 		}, 600 );
 	};
 }
