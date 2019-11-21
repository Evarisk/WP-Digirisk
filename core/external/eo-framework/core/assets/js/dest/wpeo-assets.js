'use strict';

/**
 * @namespace EO_Framework_Init
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*

 */

if ( ! window.eoxiaJS ) {

	/**
	 * [eoxiaJS description]
	 *
	 * @memberof EO_Framework_Init
	 *
	 * @type {Object}
	 */
	window.eoxiaJS = {};

	/**
	 * [scriptsLoaded description]
	 *
	 * @memberof EO_Framework_Init
	 *
	 * @type {Boolean}
	 */
	window.eoxiaJS.scriptsLoaded = false;
}

if ( ! window.eoxiaJS.scriptsLoaded ) {

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Init
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.init = function() {
		window.eoxiaJS.load_list_script();
		window.eoxiaJS.init_array_form();
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Init
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.load_list_script = function() {
		if ( ! window.eoxiaJS.scriptsLoaded ) {
			var key = undefined, slug = undefined;
			for ( key in window.eoxiaJS ) {

				if ( window.eoxiaJS[key].init ) {
					window.eoxiaJS[key].init();
				}

				for ( slug in window.eoxiaJS[key] ) {

					if ( window.eoxiaJS[key] && window.eoxiaJS[key][slug] && window.eoxiaJS[key][slug].init ) {
						window.eoxiaJS[key][slug].init();
					}

				}
			}

			window.eoxiaJS.scriptsLoaded = true;
		}
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Init
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.init_array_form = function() {
		 window.eoxiaJS.arrayForm.init();
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Init
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.refresh = function() {
		var key = undefined;
		var slug = undefined;
		for ( key in window.eoxiaJS ) {
			if ( window.eoxiaJS[key].refresh ) {
				window.eoxiaJS[key].refresh();
			}

			for ( slug in window.eoxiaJS[key] ) {

				if ( window.eoxiaJS[key] && window.eoxiaJS[key][slug] && window.eoxiaJS[key][slug].refresh ) {
					window.eoxiaJS[key][slug].refresh();
				}
			}
		}
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Init
	 *
	 * @param  {void} cbName [description]
	 * @param  {void} cbArgs [description]
	 * @returns {void}        [description]
	 */
	window.eoxiaJS.cb = function( cbName, cbArgs ) {
		var key = undefined;
		var slug = undefined;
		for ( key in window.eoxiaJS ) {

			for ( slug in window.eoxiaJS[key] ) {

				if ( window.eoxiaJS[key] && window.eoxiaJS[key][slug] && window.eoxiaJS[key][slug][cbName] ) {
					window.eoxiaJS[key][slug][cbName](cbArgs);
				}
			}
		}
	};

	jQuery( document ).ready( window.eoxiaJS.init );
}

/**
 * @namespace EO_Framework_Actions
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 *
 * @since 0.1.0
 * @version 1.0.0
 * @license GPLv3
 *
 * @description Gestion des actions XHR principaux
 *
 * * action-input: Déclenches une requête XHR avec les balises inputs contenu dans le contenaire parent.
 * * action-attribute: Déclenches une requête XHR avec les attributs de l'élément déclencheur.
 * * action-delete: Déclenches une requête XHR avec les attributs de l'élément déclencheur si l'utilisateur confirme la popin "confirm" du navigateur.
 */

if ( ! window.eoxiaJS.action ) {
	/**
	 * @summary L'objet principal "Action" ajouté à l'objet eoxiaJS afin de permêttre au fichier init.js de booter la méthode "init" de cet objet.
	 *
	 * @memberof EO_Framework_Actions
	 *
	 * @since 0.1.0
	 * @version 1.0.0
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.action = {};

	/**
	 * @summary Méthode obligatoire pour le boot de l'objet "Action". Cette méthode est appelée automatiquement par init.js.
	 *
	 * Cette méthode appelle la méthode "event" de l'objet "Action".
	 *
	 * @since 0.1.0
	 * @version 1.0.0
	 *
	 * @memberof EO_Framework_Actions
	 *
	 * @returns {void}
	 */
	window.eoxiaJS.action.init = function() {
		window.eoxiaJS.action.event();
	};

	/**
	 * @summary Méthode "event" définie les 3 events principaux des actions de EO Framework: "action-input", "action-attribute" et "action-delete".
	 *
	 * Ses trois évènements sont déclenchés au clic gauche de la souris.
	 *
	 * La classe "no-action" permet d'annuler l'évènement.
	 *
	 * @since 0.1.0
	 * @version 1.0.0
	 *
	 * @memberof EO_Framework_Actions
	 *
	 * @returns {void}
	 */
	window.eoxiaJS.action.event = function() {
		jQuery( document ).on( 'click', '.action-input:not(.no-action)', window.eoxiaJS.action.execInput );
		jQuery( document ).on( 'click', '.action-attribute:not(.no-action)', window.eoxiaJS.action.execAttribute );
		jQuery( document ).on( 'click', '.action-delete:not(.no-action)', window.eoxiaJS.action.execDelete );
		jQuery( '#wpeo-task-metabox h2 span .action-attribute' ).click( window.eoxiaJS.action.execAttribute );
		jQuery( '#wpeo-task-metabox h2 span .action-input' ).click( window.eoxiaJS.action.execInput );
		jQuery( '#wpeo-task-metabox h2 span .action-delete' ).click( window.eoxiaJS.action.execDelete );
	};

	/**
	 * @summary Permet de lancer une requête avec les valeurs des inputs trouvés dans le contenaire défini par l'attribut "data-parent".
	 *
	 * @since 0.1.0
	 * @version 1.0.0
	 * @memberof EO_Framework_Actions
	 *
	 * @example
	 *
	 * <div class="my-form">
	 * 	<input type="hidden" name="action" value="create_post" />
	 * 	<input type="text" name="title" />
	 * 	<button class="action-input" data-parent="my-form">Envoyé</button>
	 * </div>
	 *
	 * @param  {MouseEvent} event Toutes les propriétés de la souris lors du clic.
	 *
	 * @returns {void}
	 */
	window.eoxiaJS.action.execInput = function( event ) {
		var element = jQuery( this ), loaderElement = element, parentElement = element, listInput = undefined, data = {}, i = 0, doAction = true, key = undefined, inputAlreadyIn = [];
		event.preventDefault();

		if ( element.attr( 'data-parent' ) ) {
			parentElement = element.closest( '.' + element.attr( 'data-parent' ) );
		}

		/** Méthode appelée avant l'action */
		if ( element.attr( 'data-module' ) && element.attr( 'data-before-method' ) ) {
			doAction = false;
			doAction = window.eoxiaJS[element.attr( 'data-namespace' )][element.attr( 'data-module' )][element.attr( 'data-before-method' )]( element );
		} else {
			doAction = window.eoxiaJS.action.checkBeforeCB(element);
		}

		if ( doAction ) {
			if ( element.attr( 'data-loader' ) ) {
				loaderElement = element.closest( '.' + element.attr( 'data-loader' ) );
			}

			window.eoxiaJS.loader.display( loaderElement );

			listInput = window.eoxiaJS.arrayForm.getInput( parentElement );
			for ( i = 0; i < listInput.length; i++ ) {
				if ( listInput[i].name && -1 === inputAlreadyIn.indexOf( listInput[i].name ) ) {
					inputAlreadyIn.push( listInput[i].name );
					data[listInput[i].name] = window.eoxiaJS.arrayForm.getInputValue( listInput[i] );
				}
			}

			element.get_data( function( attrData ) {
				for ( key in attrData ) {
					data[key] = attrData[key];
				}

				if ( element[0].request ) {
					element[0].request.abort();
				}


				element[0].request = window.eoxiaJS.request.send( element, data );
			} );
		}
	};

	/**
	 * @summary Permet de lancer une requête avec les valeurs des attributs commençant par data-* sur la balise ou le classe action-attribute est placée.
	 *
	 * L'attribut data-action et obligatoire pour lancer une requête XHR, c'est sur celle-ci que l'action AJAX WordPress sera attaché avec le hook wp_ajax_*.
	 *
	 * @since 0.1.0
	 * @version 1.0.0
	 * @memberof EO_Framework_Actions
	 *
	 * @example
	 *
	 * <span class="action-attribute" data-action="create_post" data-title="Mon super titre">Créer un post</span>
	 *
	 * @param  {MouseEvent} event Toutes les propriétés de la souris lors du clic.
	 *
	 * @returns {void}
	 */
	window.eoxiaJS.action.execAttribute = function( event ) {
	  	var element       = jQuery( this );
		var loaderElement = element;
		var doAction      = true;

		event.preventDefault();

		/** Méthode appelée avant l'action */
		if ( element.attr( 'data-module' ) && element.attr( 'data-before-method' ) ) {
			doAction = false;
			doAction = window.eoxiaJS[element.attr( 'data-namespace' )][element.attr( 'data-module' )][element.attr( 'data-before-method' )]( element );
		} else {
			doAction = window.eoxiaJS.action.checkBeforeCB(element);
		}

		if ( element.hasClass( '.grey' ) ) {
			doAction = false;
		}

		if ( element.attr( 'data-loader' ) ) {
			loaderElement = element.closest( '.' + element.attr( 'data-loader' ) );
		}

		if ( doAction ) {
			if ( jQuery( this ).attr( 'data-confirm' ) ) {
				if ( window.confirm( jQuery( this ).attr( 'data-confirm' ) ) ) {
					element.get_data( function( data ) {
						window.eoxiaJS.loader.display( loaderElement );
						window.eoxiaJS.request.send( element, data );
					} );
				}
			} else {
				element.get_data( function( data ) {
					window.eoxiaJS.loader.display( loaderElement );
					window.eoxiaJS.request.send( element, data );
				} );
			}
		}

		event.stopPropagation();
	};

	/**
	 * Make a request with data on HTML element clicked with a custom delete message.
	 *
	 * @memberof EO_Framework_Actions
	 *
	 * @since 0.1.0
	 * @version 1.0.0
	 *
	 * @param  {MouseEvent} event Properties of element triggered by the MouseEvent.
	 *
	 * @returns {void}
	 */
	window.eoxiaJS.action.execDelete = function( event ) {
		var element = jQuery( this );
		var loaderElement = element;
		var doAction = true;


		event.preventDefault();

		/** Méthode appelée avant l'action */
		if ( element.attr( 'data-namespace' ) && element.attr( 'data-module' ) && element.attr( 'data-before-method' ) ) {
			doAction = false;
			doAction = window.eoxiaJS[element.attr( 'data-namespace' )][element.attr( 'data-module' )][element.attr( 'data-before-method' )]( element );
		}

		if ( element.hasClass( '.grey' ) ) {
			doAction = false;
		}

		if ( element.attr( 'data-loader' ) ) {
			loaderElement = element.closest( '.' + element.attr( 'data-loader' ) );
		}

		if ( doAction ) {
			if ( window.confirm( element.attr( 'data-message-delete' ) ) ) {
				element.get_data( function( data ) {
					window.eoxiaJS.loader.display( element );
					window.eoxiaJS.request.send( element, data );
				} );
			}
		}
	};

	/**
	 * Si une méthode de callback existe avant l'action, cette méthode l'appel.
	 *
	 * @memberof EO_Framework_Actions
	 *
	 * @since 0.1.0
	 * @version 1.0.0
	 *
	 * @param  {Object} element L'élément déclencheur.
	 *
	 * @returns {bool}           True si l'action peut être envoyé, sinon False.
	 */
	window.eoxiaJS.action.checkBeforeCB = function( element ) {
		var beforeMethod = element.attr( 'wpeo-before-cb' );

		if ( ! beforeMethod ) {
			return true;
		}

		beforeMethod = beforeMethod.split( '/' );

		if ( ! beforeMethod[0] || ! beforeMethod[1] || ! beforeMethod[2] ) {
			return true;
		}

		return window.eoxiaJS[beforeMethod[0]][beforeMethod[1]][beforeMethod[2]]( element );
	}
}

/**
 * @namespace EO_Framework_Array_Form
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*
 * Action for make request AJAX.
 *
 * @since 1.0.0-easy
 * @version 1.0.0-easy
 */

if ( ! window.eoxiaJS.arrayForm ) {
	/**
	 * Declare the object arrayForm.
	 *
	 * @memberof EO_Framework_Array_Form
	 *
	 * @since 1.0.0-easy
	 * @version 1.0.0-easy
	 * @type {Object}
	 */
	window.eoxiaJS.arrayForm = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Array_Form
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.arrayForm.init = function() {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Array_Form
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.arrayForm.event = function() {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Array_Form
	 *
	 * @param  {void} parent [description]
	 * @returns {void}        [description]
	 */
	window.eoxiaJS.arrayForm.getInput = function( parent ) {
		return parent.find( 'input, textarea, select' );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Array_Form
	 *
	 * @param  {void} input [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.arrayForm.getInputValue = function( input ) {
		switch ( input.getAttribute( 'type' ) ) {
			case 'checkbox':
				return input.checked;
				break;
			case 'radio':
				return jQuery( 'input[name="' + jQuery( input ).attr( 'name' ) + '"]:checked' ).val();
				break;
			default:
				return input.value;
				break;
		}
	};
}

/**
 * @namespace EO_Framework_Attribute
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */
/*

 */
if ( ! jQuery.fn.get_data ) {

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Attribute
	 *
	 * @param  {Function} cb [description]
	 * @returns {void}      [description]
	 */
	jQuery.fn.get_data = function( cb ) {
		this.each( function() {
			var data = {};
			var i = 0;
			var localName = undefined;

			for ( i = 0; i <  jQuery( this )[0].attributes.length; i++ ) {
				localName = jQuery( this )[0].attributes[i].localName;
				if ( 'data' === localName.substr( 0, 4 ) || 'action' === localName ) {
					localName = localName.substr( 5 );

					if ( 'nonce' === localName ) {
						localName = '_wpnonce';
					}

					localName = localName.replace( '-', '_' );
					data[localName] =  jQuery( this )[0].attributes[i].value;
				}
			}

			cb( data );
		} );
	};
}

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

/**
 * @namespace EO_Framework_Date
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*
 * Handle date
 *
 * @since 1.0.0
 * @version 1.0.0
 */

if ( ! window.eoxiaJS.date ) {

	/**
	 * [date description]
	 *
	 * @memberof EO_Framework_Date
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.date = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Date
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.date.init = function() {
		jQuery( document ).on ('click', '.group-date .date', function( e ) {
			var format = 'd/m/Y';
			var timepicker = false;

			if ( jQuery( this ).closest( '.group-date' ).data( 'time' ) ) {
				format += ' H:i:s';
				timepicker = true;
			}

			jQuery( this ).datetimepicker( {
				lang: 'fr',
				format: format,
				mask: true,
				timepicker: timepicker,
				closeOnDateSelect: true,
				onChangeDateTime : function(ct, $i) {
					if ( $i.closest( '.group-date' ).data( 'time' ) ) {
						$i.closest( '.group-date' ).find( '.mysql-date' ).val( ct.dateFormat('Y-m-d H:i:s') );
					} else {
						$i.closest( '.group-date' ).find( '.mysql-date' ).val( ct.dateFormat('Y-m-d') );
					}

					if ( $i.closest( '.group-date' ).attr( 'data-namespace' ) && $i.closest( '.group-date' ).attr( 'data-module' ) && $i.closest( '.group-date' ).attr( 'data-after-method' ) ) {
						window.eoxiaJS[$i.closest( '.group-date' ).attr( 'data-namespace' )][$i.closest( '.group-date' ).attr( 'data-module' )][$i.closest( '.group-date' ).attr( 'data-after-method' )]( $i );
					}
				}
			} ).datetimepicker( 'show' );
		});
	};
}

/**
 * @namespace EO_Framework_Dropdown
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*
 * Gestion du dropdown.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
 if ( ! window.eoxiaJS.dropdown  ) {

 	/**
 	 * [dropdown description]
 	 *
 	 * @memberof EO_Framework_Dropdown
 	 *
 	 * @type {Object}
 	 */
 	window.eoxiaJS.dropdown = {};

 	/**
 	 * [description]
 	 *
 	 * @memberof EO_Framework_Dropdown
 	 *
 	 * @returns {void} [description]
 	 */
 	window.eoxiaJS.dropdown.init = function() {
 		window.eoxiaJS.dropdown.event();
 	};

 	/**
 	 * [description]
 	 *
 	 * @memberof EO_Framework_Dropdown
 	 *
 	 * @returns {void} [description]
 	 */
 	window.eoxiaJS.dropdown.event = function() {
 		jQuery( document ).on( 'keyup', window.eoxiaJS.dropdown.keyup );
 		jQuery( document ).on( 'click', '.wpeo-dropdown:not(.dropdown-active) .dropdown-toggle:not(.disabled)', window.eoxiaJS.dropdown.open );
 		jQuery( document ).on( 'click', '.wpeo-dropdown.dropdown-active .dropdown-content', function(e) { e.stopPropagation() } );
 		jQuery( document ).on( 'click', '.wpeo-dropdown.dropdown-active:not(.dropdown-force-display) .dropdown-content .dropdown-item', window.eoxiaJS.dropdown.close  );
 		jQuery( document ).on( 'click', '.wpeo-dropdown.dropdown-active', function ( e ) { window.eoxiaJS.dropdown.close( e ); e.stopPropagation(); } );
 		jQuery( document ).on( 'click', 'body', window.eoxiaJS.dropdown.close );
 	};

 	/**
 	 * [description]
 	 *
 	 * @memberof EO_Framework_Dropdown
 	 *
 	 * @param  {void} event [description]
 	 * @returns {void}       [description]
 	 */
 	window.eoxiaJS.dropdown.keyup = function( event ) {
 		if ( 27 === event.keyCode ) {
 			window.eoxiaJS.dropdown.close();
 		}
 	};

 	/**
 	 * [description]
 	 *
 	 * @memberof EO_Framework_Dropdown
 	 *
 	 * @param  {void} event [description]
 	 * @returns {void}       [description]
 	 */
 	window.eoxiaJS.dropdown.open = function( event ) {
 		var triggeredElement = jQuery( this );
 		var angleElement = triggeredElement.find('[data-fa-i2svg]');
 		var callbackData = {};
 		var key = undefined;

 		window.eoxiaJS.dropdown.close( event, jQuery( this ) );

 		if ( triggeredElement.attr( 'data-action' ) ) {
 			window.eoxiaJS.loader.display( triggeredElement );

 			triggeredElement.get_data( function( data ) {
 				for ( key in callbackData ) {
 					if ( ! data[key] ) {
 						data[key] = callbackData[key];
 					}
 				}

 				window.eoxiaJS.request.send( triggeredElement, data, function( element, response ) {
 					triggeredElement.closest( '.wpeo-dropdown' ).find( '.dropdown-content' ).html( response.data.view );

 					triggeredElement.closest( '.wpeo-dropdown' ).addClass( 'dropdown-active' );

 					/* Toggle Button Icon */
 					if ( angleElement ) {
 						window.eoxiaJS.dropdown.toggleAngleClass( angleElement );
 					}
 				} );
 			} );
 		} else {
 			triggeredElement.closest( '.wpeo-dropdown' ).addClass( 'dropdown-active' );

 			/* Toggle Button Icon */
 			if ( angleElement ) {
 				window.eoxiaJS.dropdown.toggleAngleClass( angleElement );
 			}
 		}

 		event.stopPropagation();
 	};

 	/**
 	 * [description]
 	 *
 	 * @memberof EO_Framework_Dropdown
 	 *
 	 * @param  {void} event [description]
 	 * @returns {void}       [description]
 	 */
 	window.eoxiaJS.dropdown.close = function( event ) {
 		var _element = jQuery( this );
 		jQuery( '.wpeo-dropdown.dropdown-active:not(.no-close)' ).each( function() {
 			var toggle = jQuery( this );
 			var triggerObj = {
 				close: true
 			};

 			_element.trigger( 'dropdown-before-close', [ toggle, _element, triggerObj ] );

 			if ( triggerObj.close ) {
 				toggle.removeClass( 'dropdown-active' );

 				/* Toggle Button Icon */
 				var angleElement = jQuery( this ).find('.dropdown-toggle').find('[data-fa-i2svg]');
 				if ( angleElement ) {
 					window.eoxiaJS.dropdown.toggleAngleClass( angleElement );
 				}
 			} else {
 				return;
 			}
 		});
 	};

 	/**
 	 * [description]
 	 *
 	 * @memberof EO_Framework_Dropdown
 	 *
 	 * @param  {void} button [description]
 	 * @returns {void}        [description]
 	 */
 	window.eoxiaJS.dropdown.toggleAngleClass = function( button ) {
 		if ( button.hasClass('fa-caret-down') || button.hasClass('fa-caret-up') ) {
 			button.toggleClass('fa-caret-down').toggleClass('fa-caret-up');
 		}
 		else if ( button.hasClass('fa-caret-circle-down') || button.hasClass('fa-caret-circle-up') ) {
 			button.toggleClass('fa-caret-circle-down').toggleClass('fa-caret-circle-up');
 		}
 		else if ( button.hasClass('fa-angle-down') || button.hasClass('fa-angle-up') ) {
 			button.toggleClass('fa-angle-down').toggleClass('fa-angle-up');
 		}
 		else if ( button.hasClass('fa-chevron-circle-down') || button.hasClass('fa-chevron-circle-up') ) {
 			button.toggleClass('fa-chevron-circle-down').toggleClass('fa-chevron-circle-up');
 		}
 	}
 }

/**
 * @namespace EO_Framework_Form
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */
/*

 */

if ( ! window.eoxiaJS.form ) {

	/**
	 * [form description]
	 *
	 * @memberof EO_Framework_Form
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.form = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Form
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.form.init = function() {
	    window.eoxiaJS.form.event();
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Form
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.form.event = function() {
	    jQuery( document ).on( 'click', '.submit-form', window.eoxiaJS.form.submitForm );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Form
	 *
	 * @param  {void} event [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.form.submitForm = function( event ) {
		var element = jQuery( this );
		var doAction = true;

		event.preventDefault();

	/** Méthode appelée avant l'action */
		if ( element.attr( 'data-module' ) && element.attr( 'data-before-method' ) ) {
			doAction = false;
			doAction = window.eoxiaJS[element.attr( 'data-module' )][element.attr( 'data-before-method' )]( element );
		}

		if ( doAction ) {
			element.closest( 'form' ).ajaxSubmit( {
				success: function( response ) {
					if ( response && response.data.module && response.data.callback ) {
						window.eoxiaJS[response.data.module][response.data.callback]( element, response );
					}

					if ( response && response.success ) {
						if ( response.data.module && response.data.callback_success ) {
							window.eoxiaJS[response.data.module][response.data.callback_success]( element, response );
						}
					} else {
						if ( response.data.module && response.data.callback_error ) {
							window.eoxiaJS[response.data.module][response.data.callback_error]( element, response );
						}
					}
				}
			} );
		}
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Form
	 *
	 * @param  {void} formElement [description]
	 * @returns {void}             [description]
	 */
	window.eoxiaJS.form.reset = function( formElement ) {
		var fields = formElement.find( 'input, textarea, select' );

		fields.each(function () {
			switch( jQuery( this )[0].tagName ) {
				case 'INPUT':
				case 'TEXTAREA':
					jQuery( this ).val( jQuery( this )[0].defaultValue );
					break;
				case 'SELECT':
					// 08/03/2018: En dur pour TheEPI il faut absolument le changer
					jQuery( this ).val( 'OK' );
					break;
				default:
					jQuery( this ).val( jQuery( this )[0].defaultValue );
					break;
			}
		} );
	};
}

/**
 * @namespace EO_Framework_Global
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*

 */
if ( ! window.eoxiaJS.global ) {

	/**
	 * [global description]
	 *
	 * @memberof EO_Framework_Global
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.global = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Global
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.global.init = function() {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Global
	 *
	 * @param  {void} urlToFile [description]
	 * @param  {void} filename  [description]
	 * @returns {void}           [description]
	 */
	window.eoxiaJS.global.downloadFile = function( urlToFile, filename ) {
		var alink = document.createElement( 'a' );
		alink.setAttribute( 'href', urlToFile );
		alink.setAttribute( 'download', filename );
		if ( document.createEvent ) {
			var event = document.createEvent( 'MouseEvents' );
			event.initEvent( 'click', true, true );
			alink.dispatchEvent( event );
		} else {
			alink.click();
		}
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Global
	 *
	 * @param  {void} input [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.global.removeDiacritics = function( input ) {
		var output = '';
		var normalized = input.normalize( 'NFD' );
		var i = 0;
		var j = 0;

		while ( i < input.length ) {
			output += normalized[j];

			j += ( input[i] == normalized[j] ) ? 1 : 2;
			i++;
		}

		return output;
	};

	}

/**
 * @namespace EO_Framework_Loader
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*
 * Gestion du loader.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! window.eoxiaJS.loader ) {

	/**
	 * [loader description]
	 *
	 * @memberof EO_Framework_Loader
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.loader = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Loader
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.loader.init = function() {
		window.eoxiaJS.loader.event();
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Loader
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.loader.event = function() {
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Loader
	 *
	 * @param  {void} element [description]
	 * @returns {void}         [description]
	 */
	window.eoxiaJS.loader.display = function( element ) {
		// Loader spécial pour les "button-progress".
		if ( element.hasClass( 'button-progress' ) ) {
			element.addClass( 'button-load' )
		} else {
			element.addClass( 'wpeo-loader' );
			var el = jQuery( '<span class="loader-spin"></span>' );
			element[0].loaderElement = el;
			element.append( element[0].loaderElement );
		}
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Loader
	 *
	 * @param  {void} element [description]
	 * @returns {void}         [description]
	 */
	window.eoxiaJS.loader.remove = function( element ) {
		if ( 0 < element.length && ! element.hasClass( 'button-progress' ) ) {
			element.removeClass( 'wpeo-loader' );

			jQuery( element[0].loaderElement ).remove();
		}
	};
}

/**
 * @namespace EO_Framework_Modal
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*
 * Gestion de la modal.
 *
 * La modal peut être ouverte par deux moyens:
 * -Avec une requête AJAX.
 * -En plaçant la vue directement dans le DOM.
 *
 * Dans tous les cas, il faut placer un élément HTML avec la classe ".wpeo-modal-event".
 *
 * Cette élement doit contenir différent attributs.
 *
 * Les attributs pour ouvrir la popup avec une requête AJAX:
 * - data-action: Le nom de l'action WordPress.
 * - data-title : Le titre de la popup.
 * - data-class : Pour ajouter une classe dans le contenaire principale de la popup.
 *
 * Les attributs pour ouvrir la popup avec une vue implémentée directement dans le DOM:
 * - data-parent: La classe de l'élement parent contenant la vue de la popup
 * - data-target: La classe de la popup elle même.
 *
 * La modal généré en AJAX est ajouté dans la balise <body> temporairement. Une fois celle-ci fermée
 * elle se détruit du DOM.
 *
 * La modal implémentée dans le DOM (donc non généré en AJAX) reste dans le DOM une fois fermée.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! window.eoxiaJS.modal  ) {

	/**
	 * [modal description]
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.modal = {};

	/**
	 * La vue de la modal (Utilisé pour la requête AJAX, les variables dans la vue *{{}}* ne doit pas être modifiées.).
	 * Voir le fichier /core/view/modal.view.php
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @type string
	 */
	window.eoxiaJS.modal.popupTemplate = wpeo_framework.modalView;

	/**
	 * Les boutons par défault de la modal (Utilisé pour la requête AJAX, les variables dans la vue *{{}}* ne doit pas être modifiées.).
	 * Voir le fichier /core/view/modal-buttons.view.php
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @type string
	 */
	window.eoxiaJS.modal.defaultButtons = wpeo_framework.modalDefaultButtons;

	/**
	 * Le titre par défault de la modal (Utilisé pour la requête AJAX, les variables dans la vue *{{}}* ne doit pas être modifiées.).
	 * Voir le fichier /core/view/modal-title.view.php
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 *
	 * @type string
	 */
	window.eoxiaJS.modal.defaultTitle = wpeo_framework.modalDefaultTitle;

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.modal.init = function() {
		window.eoxiaJS.modal.event();
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.modal.event = function() {
		jQuery( document ).on( 'keyup', window.eoxiaJS.modal.keyup );
		jQuery( document ).on( 'click', '.wpeo-modal-event', window.eoxiaJS.modal.open );
		jQuery( document ).on( 'click', '.wpeo-modal .modal-container', window.eoxiaJS.modal.stopPropagation );
		jQuery( document ).on( 'click', '.wpeo-modal .modal-close', window.eoxiaJS.modal.close );
		//  jQuery( document ).on( 'click', 'body', window.eoxiaJS.modal.close ); //09/07/2019
		jQuery( document ).on( 'mousedown', '.modal-active:not(.modal-container)', window.eoxiaJS.modal.close );
		jQuery( '#wpeo-task-metabox h2 span .wpeo-modal-event' ).click( window.eoxiaJS.modal.open );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @param  {void} event [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.modal.keyup = function( event ) {
		if ( 27 === event.keyCode ) {
			jQuery( '.wpeo-modal.modal-active:not(.no-close) .modal-close:first' ).click();
		}
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @param  {void} event [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.modal.open = function( event ) {
		var triggeredElement = jQuery( this );
		var callbackData = {};
		var key = undefined;

		window.eoxiaJS.action.checkBeforeCB( triggeredElement );

		// Si data-action existe, ce script ouvre la popup en lançant une requête AJAX.
		if ( triggeredElement.attr( 'data-action' ) ) {
			window.eoxiaJS.loader.display( triggeredElement );

			triggeredElement.get_data( function( data ) {
				for ( key in callbackData ) {
					if ( ! data[key] ) {
						data[key] = callbackData[key];
					}
				}

				window.eoxiaJS.request.send( triggeredElement, data, function( element, response ) {
					window.eoxiaJS.loader.remove( triggeredElement );

					if ( response.data.view ) {
						var el = jQuery( document.createElement( 'div' ) );
						el[0].className = 'wpeo-modal modal-active';
						el[0].innerHTML = window.eoxiaJS.modal.popupTemplate;
						el[0].typeModal = 'ajax';
						triggeredElement[0].modalElement = el;

						if ( triggeredElement.attr( 'data-class' ) ) {
							el[0].className += ' ' + triggeredElement.attr( 'data-class' );
						}

						jQuery( 'body' ).append( triggeredElement[0].modalElement );

						el[0].innerHTML = el[0].innerHTML.replace( '{{content}}', response.data.view );

						if ( typeof response.data.buttons_view !== 'undefined' ) {
							el[0].innerHTML = el[0].innerHTML.replace( '{{buttons}}', response.data.buttons_view );
						} else {
							el[0].innerHTML = el[0].innerHTML.replace( '{{buttons}}', window.eoxiaJS.modal.defaultButtons );
						}

						if ( triggeredElement.attr( 'data-title' ) ) {
							el[0].innerHTML = el[0].innerHTML.replace( '{{title}}', triggeredElement.attr( 'data-title' ) );
						} else if ( response.data.modal_title ) {
							el[0].innerHTML = el[0].innerHTML.replace( '{{title}}', response.data.modal_title );
						} else if ( ! triggeredElement.attr( 'data-title' ) ) {
							el[0].innerHTML = el[0].innerHTML.replace( '{{title}}', window.eoxiaJS.modal.defaultTitle );
						}

						if ( window.eoxiaJS.refresh ) {
							window.eoxiaJS.refresh();
						}

						triggeredElement[0].modalElement.trigger( 'modal-opened', triggeredElement );
					}
				} );
			});
		} else {
			// Stop le script si un de ses deux attributs n'est pas déclaré.
			if ( ! triggeredElement.attr( 'data-parent' ) || ! triggeredElement.attr( 'data-target' ) ) {
				event.stopPropagation();
				return;
			}


			var target = triggeredElement.closest( '.' + triggeredElement.attr( 'data-parent' ) ).find( '.' + triggeredElement.attr( 'data-target' ) );

			jQuery( target ).find( 'h2.modal-title' ).text( '{{title}}' );

			if ( triggeredElement.attr( 'data-title' ) ) {
				target[0].querySelector( '.modal-title' ).innerHTML = target[0].querySelector( '.modal-title' ).innerHTML.replace( '{{title}}', triggeredElement.attr( 'data-title' ) );
			}

			if ( triggeredElement.attr( 'data-class' ) ) {
				target[0].className += ' ' + triggeredElement.attr( 'data-class' );
			}

			target.addClass( 'modal-active' );
			target[0].typeModal = 'default';
			triggeredElement[0].modalElement = target;

			target.trigger( 'modal-opened', triggeredElement );

		}

		event.stopPropagation();
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @param  {void} event [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.modal.stopPropagation = function( event ) {
		event.stopPropagation();
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Modal
	 *
	 * @param  {void} event [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.modal.close = function( event ) {
		if( ! jQuery( event.target ).hasClass( "wpeo-modal" ) && event.type == "mousedown" ){ // Si le click se situe dans la modal
			return;
		}
		jQuery( '.wpeo-modal.modal-active:last:not(.modal-force-display)' ).each( function() {
			var popup = jQuery( this );
			popup.removeClass( 'modal-active' );
			if ( popup[0].typeModal && 'default' !== popup[0].typeModal ) {
				setTimeout( function() {
					popup.remove();
				}, 200 );
			}
			popup.trigger( 'modal-closed', popup );
		} );
	};
}

/**
 * @namespace EO_Framework_Popover
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*

 */
if ( ! window.eoxiaJS.popover ) {

	/**
	 * [popover description]
	 *
	 * @memberof EO_Framework_Popover
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.popover = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Popover
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.popover.init = function() {
		window.eoxiaJS.popover.event();
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Popover
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.popover.event = function() {
		jQuery( document ).on( 'click', '.wpeo-popover-event.popover-click', window.eoxiaJS.popover.click );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Popover
	 *
	 * @param  {void} event [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.popover.click = function( event ) {
		window.eoxiaJS.popover.toggle( jQuery( this ) );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Popover
	 *
	 * @param  {void} element [description]
	 * @returns {void}         [description]
	 */
	window.eoxiaJS.popover.toggle = function( element ) {
		var direction = ( element.data( 'direction' ) ) ? element.data( 'direction' ) : 'top';
		var el = jQuery( '<span class="wpeo-popover popover-' + direction + '">' + element.attr( 'aria-label' ) + '</span>' );
		var pos = element.position();
		var offset = element.offset();

		if ( element[0].popoverElement ) {
			jQuery( element[0].popoverElement ).remove();
			delete element[0].popoverElement;
		} else {
			element[0].popoverElement = el;
			jQuery( 'body' ).append( element[0].popoverElement );

			if ( element.data( 'color' ) ) {
				el.addClass( 'popover-' + element.data( 'color' ) );
			}

			var top = 0;
			var left = 0;

			switch( element.data( 'direction' ) ) {
				case 'left':
					top = ( offset.top - ( el.outerHeight() / 2 ) + ( element.outerHeight() / 2 ) ) + 'px';
					left = ( offset.left - el.outerWidth() - 10 ) + 3 + 'px';
					break;
				case 'right':
					top = ( offset.top - ( el.outerHeight() / 2 ) + ( element.outerHeight() / 2 ) ) + 'px';
					left = offset.left + element.outerWidth() + 8 + 'px';
					break;
				case 'bottom':
					top = ( offset.top + element.height() + 10 ) + 10 + 'px';
					left = ( offset.left - ( el.outerWidth() / 2 ) + ( element.outerWidth() / 2 ) ) + 'px';
					break;
				case 'top':
					top = offset.top - el.outerHeight() - 4  + 'px';
					left = ( offset.left - ( el.outerWidth() / 2 ) + ( element.outerWidth() / 2 ) ) + 'px';
					break;
				default:
					top = offset.top - el.outerHeight() - 4  + 'px';
					left = ( offset.left - ( el.outerWidth() / 2 ) + ( element.outerWidth() / 2 ) ) + 'px';
					break;
			}

			el.css( {
				'top': top,
				'left': left,
				'opacity': 1
			} );
		}
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Popover
	 *
	 * @param  {void} element [description]
	 * @returns {void}         [description]
	 */
	window.eoxiaJS.popover.remove = function( element ) {
		if ( element[0].popoverElement ) {
			jQuery( element[0].popoverElement ).remove();
			delete element[0].popoverElement;
		}
	};
}

/**
 * @namespace EO_Framework_Regex
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*

 */

var regex = {
	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Regex
	 *
	 * @param  {void} email [description]
	 * @returns {void}       [description]
	 */
	validateEmail: function(email) {
	    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	    return re.test(email);
	},

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Regex
	 *
	 * @param  {void} endEmail [description]
	 * @returns {void}          [description]
	 */
	validateEndEmail: function( endEmail ) {
		var re = /^[a-zA-Z0-9]+\.[a-zA-Z0-9]+(\.[a-z-A-Z0-9]+)?$/;
		return re.test( endEmail );
	}
};

/**
 * @namespace EO_Framework_Render
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */
/*

 */
if ( ! window.eoxiaJS.render ) {
	/**
	 * [render description]
	 *
	 * @memberof EO_Framework_Render
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.render = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Render
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.render.init = function() {
		window.eoxiaJS.render.event();
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Render
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.render.event = function() {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Render
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.render.callRenderChanged = function() {
		var key = undefined;
		var slug = undefined;

		for ( key in window.eoxiaJS ) {
			if ( window.eoxiaJS[key].renderChanged ) {
				window.eoxiaJS[key].renderChanged();
			}

			for ( slug in window.eoxiaJS[key] ) {
				if ( window.eoxiaJS[key][slug].renderChanged ) {
					window.eoxiaJS[key][slug].renderChanged();
				}
			}
		}
	};
}

/**
 * @namespace EO_Framework_Request
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*
 * Gestion des requêtes XHR.
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! window.eoxiaJS.request ) {

	/**
	 * [request description]
	 *
	 * @memberof EO_Framework_Request
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.request = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Request
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.request.init = function() {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Request
	 *
	 * @param  {void}   element [description]
	 * @param  {void}   data    [description]
	 * @param  {Function} cb      [description]
	 * @returns {void}           [description]
	 */
	window.eoxiaJS.request.send = function( element, data, cb ) {
		return jQuery.post( window.ajaxurl, data, function( response ) {
			// Normal loader.
			if ( element instanceof jQuery ) {
				window.eoxiaJS.loader.remove( element.closest( '.wpeo-loader' ) );
			}

			// Handle button progress.
			if ( element instanceof jQuery && element.hasClass( 'button-progress' ) ) {
				element.removeClass( 'button-load' ).addClass( 'button-success' );
				setTimeout( function() {
					element.removeClass( 'button-success' );

					window.eoxiaJS.request.callCB( element, response, cb )
				}, 1000 );
			} else {
				window.eoxiaJS.request.callCB( element, response, cb )
			}
		}, 'json').fail( function() {
			window.eoxiaJS.request.fail( element );
		} );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Request
	 *
	 * @param  {void}   element [description]
	 * @param  {void}   url     [description]
	 * @param  {void}   data    [description]
	 * @param  {Function} cb      [description]
	 * @returns {void}           [description]
	 */
	window.eoxiaJS.request.get = function( element, url, data, cb ) {
		jQuery.get( url, data, function( response ) {
			window.eoxiaJS.request.callCB( element, response, cb );
		}, 'json' ).fail( function() {
			window.eoxiaJS.request.fail( element );
		} );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Request
	 *
	 * @param  {void}   element  [description]
	 * @param  {void}   response [description]
	 * @param  {Function} cb       [description]
	 * @returns {void}            [description]
	 */
	window.eoxiaJS.request.callCB = function( element, response, cb ) {
		if ( cb ) {
			cb( element, response );
		} else {
			if ( response && response.success ) {
				if ( response.data && response.data.namespace && response.data.module && response.data.callback_success ) {
					window.eoxiaJS[response.data.namespace][response.data.module][response.data.callback_success]( element, response );
				} else if ( response.data && response.data.module && response.data.callback_success ) {
					window.eoxiaJS[response.data.module][response.data.callback_success]( element, response );
				}
			} else {
				if ( response.data && response.data.namespace && response.data.module && response.data.callback_error ) {
					window.eoxiaJS[response.data.namespace][response.data.module][response.data.callback_error]( element, response );
				}
			}
		}
	}

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Request
	 *
	 * @param  {void} element [description]
	 * @returns {void}         [description]
	 */
	window.eoxiaJS.request.fail = function( element ) {
		if ( element && element instanceof jQuery ) {
			window.eoxiaJS.loader.remove( element.closest( '.wpeo-loader' ) );

			if ( element.hasClass( 'button-progress' ) ) {
				element.removeClass( 'button-load' ).addClass( 'button-error' );
				setTimeout( function() {
					element.removeClass( 'button-error' );
				}, 1000 );
			}
		}
	}
}

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

/**
 * @namespace EO_Framework_Tooltip
 *
 * @author Eoxia <dev@eoxia.com>
 * @copyright 2015-2018 Eoxia
 */

/*

 */
if ( ! window.eoxiaJS.tooltip ) {

	/**
	 * [tooltip description]
	 *
	 * @memberof EO_Framework_Tooltip
	 *
	 * @type {Object}
	 */
	window.eoxiaJS.tooltip = {};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Tooltip
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.tooltip.init = function() {
		window.eoxiaJS.tooltip.event();
	};

	window.eoxiaJS.tooltip.tabChanged = function() {
		jQuery( '.wpeo-tooltip' ).remove();
	}

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Tooltip
	 *
	 * @returns {void} [description]
	 */
	window.eoxiaJS.tooltip.event = function() {
		jQuery( document ).on( 'mouseenter', '.wpeo-tooltip-event:not([data-tooltip-persist="true"])', window.eoxiaJS.tooltip.onEnter );
		jQuery( document ).on( 'mouseleave', '.wpeo-tooltip-event:not([data-tooltip-persist="true"])', window.eoxiaJS.tooltip.onOut );
	};

	window.eoxiaJS.tooltip.onEnter = function( event ) {
		window.eoxiaJS.tooltip.display( jQuery( this ) );
	};

	window.eoxiaJS.tooltip.onOut = function( event ) {
		window.eoxiaJS.tooltip.remove( jQuery( this ) );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Tooltip
	 *
	 * @param  {void} event [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.tooltip.display = function( element ) {
		var direction = ( jQuery( element ).data( 'direction' ) ) ? jQuery( element ).data( 'direction' ) : 'top';
		var el = jQuery( '<span class="wpeo-tooltip tooltip-' + direction + '">' + jQuery( element ).attr( 'aria-label' ) + '</span>' );
		var pos = jQuery( element ).position();
		var offset = jQuery( element ).offset();
		jQuery( element )[0].tooltipElement = el;
		jQuery( 'body' ).append( jQuery( element )[0].tooltipElement );

		if ( jQuery( element ).data( 'color' ) ) {
			el.addClass( 'tooltip-' + jQuery( element ).data( 'color' ) );
		}

		var top = 0;
		var left = 0;

		switch( jQuery( element ).data( 'direction' ) ) {
			case 'left':
				top = ( offset.top - ( el.outerHeight() / 2 ) + ( jQuery( element ).outerHeight() / 2 ) ) + 'px';
				left = ( offset.left - el.outerWidth() - 10 ) + 3 + 'px';
				break;
			case 'right':
				top = ( offset.top - ( el.outerHeight() / 2 ) + ( jQuery( element ).outerHeight() / 2 ) ) + 'px';
				left = offset.left + jQuery( element ).outerWidth() + 8 + 'px';
				break;
			case 'bottom':
				top = ( offset.top + jQuery( element ).height() + 10 ) + 10 + 'px';
				left = ( offset.left - ( el.outerWidth() / 2 ) + ( jQuery( element ).outerWidth() / 2 ) ) + 'px';
				break;
			case 'top':
				top = offset.top - el.outerHeight() - 4  + 'px';
				left = ( offset.left - ( el.outerWidth() / 2 ) + ( jQuery( element ).outerWidth() / 2 ) ) + 'px';
				break;
			default:
				top = offset.top - el.outerHeight() - 4  + 'px';
				left = ( offset.left - ( el.outerWidth() / 2 ) + ( jQuery( element ).outerWidth() / 2 ) ) + 'px';
				break;
		}

		el.css( {
			'top': top,
			'left': left,
			'opacity': 1
		} );

		jQuery( element ).on("remove", function() {
			jQuery( jQuery( element )[0].tooltipElement ).remove();

		} );
	};

	/**
	 * [description]
	 *
	 * @memberof EO_Framework_Tooltip
	 *
	 * @param  {void} event [description]
	 * @returns {void}       [description]
	 */
	window.eoxiaJS.tooltip.remove = function( element ) {
		if ( jQuery( element )[0] && jQuery( element )[0].tooltipElement ) {
			jQuery( jQuery( element )[0].tooltipElement ).remove();
		}
	};
}
