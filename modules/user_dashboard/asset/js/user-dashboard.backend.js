/**
 * Initialise l'objet "userDashboard" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 1.0
 * @version 6.2.5.0
 */

window.eoxiaJS.digirisk.userDashboard = {};

window.eoxiaJS.digirisk.userDashboard.init = function() {
	window.eoxiaJS.digirisk.userDashboard.event();
};

window.eoxiaJS.digirisk.userDashboard.event = function() {
	jQuery( document ).on( 'keyup', '.user-dashboard .input-domain-mail', window.eoxiaJS.digirisk.userDashboard.keyupUpdateEmail );
	jQuery( document ).on( 'keyup', '.user-dashboard table.users tr:last input.lastname', window.eoxiaJS.digirisk.userDashboard.keyupUpdateEmail );
	jQuery( document ).on( 'keyup', '.user-dashboard table.users tr:last input.firstname', window.eoxiaJS.digirisk.userDashboard.keyupUpdateEmail );
	jQuery( document ).on( 'keyup', '.user-dashboard table.users tr:last input.email', window.eoxiaJS.digirisk.userDashboard.keyEnterSendForm );

	jQuery( document ).on( 'keyup', '.user-dashboard table.users tr:last input.lastname', window.eoxiaJS.digirisk.userDashboard.changeColorInputSubmit );
	jQuery( document ).on( 'keyup', '.user-dashboard table.users tr:last input.firstname', window.eoxiaJS.digirisk.userDashboard.changeColorInputSubmit );
	jQuery( document ).on( 'keyup', '.user-dashboard table.users tr:last input.email', window.eoxiaJS.digirisk.userDashboard.changeColorInputSubmit );

	jQuery( document ).on( 'click', '.user-dashboard .wp-digi-action-save-domain-mail', window.eoxiaJS.digirisk.userDashboard.save_domain_mail );
};

/**
 * Vérifie si le domaine de l'email a un format valide.
 *
 * @param  {HTMLDivElement} triggeredElement
 * @return {void}
 *
 * @since 6.2.5.0
 * @version 6.2.5.0
 */
window.eoxiaJS.digirisk.userDashboard.checkDomainEmailValid = function( triggeredElement ) {
	if ( ! window.regex.validateEndEmail( triggeredElement.closest( '.email-domain' ).find( 'input[type="text"]' ).val() ) ) {
		triggeredElement.closest( '.email-domain' ).find( 'label' ).addClass( 'active' );
		return false;
	} else {
		triggeredElement.closest( '.email-domain' ).find( 'label' ).removeClass( 'active' );
		return true;
	}
};

/**
 * Envoies une requête pour enregister le domaine de l'email.
 *
 * @param  {ClickEvent} event L'état de la souris lors du clic sur le bouton.
 *
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.5.0
 */
window.eoxiaJS.digirisk.userDashboard.save_domain_mail = function( event ) {
	var element = jQuery( this );
	var data = {};

	event.preventDefault();

	data = {
		action: 'save_domain_mail',
		_wpnonce: element.data( 'nonce' ),
		domain_mail: element.closest( '.form-element' ).find( 'input' ).val()
	};

	jQuery.post( window.ajaxurl, data );
};

/**
 * Lors qu'une touche est en status "keyup" on met à jour le champ de texte "email" avec les données du champs de texte "nom", "prénom" et "Domaine de l'email".
 *
 * @param  {KeyEvent} event L'état du clavier lors de l'évènement "keyup"
 * @return {void}
 *
 * @since 0.1
 * @version 6.2.5.0
 */
window.eoxiaJS.digirisk.userDashboard.keyupUpdateEmail = function( event ) {
	var email = jQuery( '.user-dashboard table.users tr:last .email' ).val();
	var firstname = jQuery( '.user-dashboard table.users tr:last .firstname' ).val();
	var lastname = jQuery( '.user-dashboard table.users tr:last .lastname' ).val();
	var domainMail = jQuery( '.input-domain-mail' ).val();
	var together = window.eoxiaJS.global.removeDiacritics( firstname + '.' + lastname + '@' + domainMail ).toLowerCase();

	jQuery( '.user-dashboard table.users tr:last input[name="email"]' ).val( together );

	// Vérifie que l'évènement n'est pas déclenché dans le champ de texte du domaine de l'email.
	if ( 'input-domain-mail' !== event.target.className ) {
		window.eoxiaJS.digirisk.userDashboard.keyEnterSendForm( event, jQuery( this ) );
	}
};

/**
 * Si la touche "entrée" est appuyé, appuies sur le bouton "plus" pour ajouter un utilisateur.
 *
 * @param  {KeyEvent} event L'état du clavier lors de l'évènement "keyup"
 * @return {void}
 *
 * @since 0.1
 * @version 6.2.4.0
 */
window.eoxiaJS.digirisk.userDashboard.keyEnterSendForm = function( event ) {
	if ( 13 === event.keyCode ) {
		jQuery( '.user-dashboard table.users tr:last .action-input' ).click();
	}
};

/**
 * Si la ligne a un contenu, change la couleur du bouton.
 *
 * @param  {KeyboardEvent} event L'état du clavier.
 * @return {void}
 *
 * @since 6.2.6.0
 * @version 6.2.6.0
 */
window.eoxiaJS.digirisk.userDashboard.changeColorInputSubmit = function( event ) {
	jQuery( this ).closest( 'tr' ).find( '.action .button.disable' ).removeClass( 'disable' ).addClass( 'blue' );
};

/**
 * Le callback en cas de réussite à la requête Ajax "delete_user".
 * Supprimes la ligne de l'utilisateur.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.5.0
 */
window.eoxiaJS.digirisk.userDashboard.deletedUserSuccess = function( element, response ) {
	element.closest( 'tr' ).fadeOut();
};

/**
 * Le callback en cas de réussite à la requête Ajax "load_user".
 * Remplaces la vue de la ligne.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.5.0
 */
window.eoxiaJS.digirisk.userDashboard.loadedUserSuccess = function( element, response ) {
  element.closest( 'tr' ).replaceWith( response.data.template );
};

/**
 * Le callback en cas de réussite à la requête Ajax "save_user".
 * Remplaces le contenu du tableau "users" par le template renvoyé par la requête Ajax.
 *
 * Si response.data.error est égale à true, affiches le tooltip disant "Cette adresse email est déjà utilisée."
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.5.0
 */
window.eoxiaJS.digirisk.userDashboard.savedUserSuccess = function( element, response ) {
	jQuery( '.user-dashboard table.users .tooltip.red.active' ).removeClass( 'active' );

	if ( response.data.error ) {
		jQuery( '.user-dashboard table.users .tooltip.red' ).addClass( 'active' );
	} else {
		jQuery( '.user-dashboard table.users' ).html( response.data.template );
		jQuery( '.user-dashboard table.users tr:last input.lastname' ).focus();
	}
};
