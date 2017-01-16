window.digirisk.user_dashboard = {};

window.digirisk.user_dashboard.init = function() {
	window.digirisk.user_dashboard.event();
};

window.digirisk.user_dashboard.event = function() {
	jQuery( document ).on( 'keyup', '.user-dashboard .input-domain-mail', window.digirisk.user_dashboard.keyupUpdateEmail );
	jQuery( document ).on( 'keyup', '.user-dashboard table.users tr:last input.lastname', window.digirisk.user_dashboard.keyupUpdateEmail );
	jQuery( document ).on( 'keyup', '.user-dashboard table.users tr:last input.firstname', window.digirisk.user_dashboard.keyupUpdateEmail );
	jQuery( document ).on( 'keyup', '.user-dashboard table.users tr:last input.email', window.digirisk.user_dashboard.keyEnterSendForm );
	jQuery( document ).on( 'click', '.user-dashboard .wp-digi-action-save-domain-mail', window.digirisk.user_dashboard.save_domain_mail );
};

window.digirisk.user_dashboard.save_domain_mail = function( event ) {
	var element = jQuery( this );
	var data = {};

  event.preventDefault();

	element.closest( 'li' ).addClass( 'wp-digi-bloc-loading' );

	data = {
		action: 'save_domain_mail',
		_wpnonce: element.data( 'nonce' ),
		domain_mail: element.closest( '.form-element' ).find( 'input' ).val()
	};

  jQuery.post( window.ajaxurl, data, function() {
		element.closest( 'li' ).removeClass( 'wp-digi-bloc-loading' );
	} );
},

/**
 * Lors qu'une touche est en status "keyup" on met à jour le champ de texte "email" avec les données du champs de texte "nom", "prénom" et "Domaine de l'email".
 *
 * @param  {KeyEvent} event L'état du clavier lors de l'évènement "keyup"
 * @return {void}
 *
 * @since 0.1
 * @version 6.2.4.0
 */
window.digirisk.user_dashboard.keyupUpdateEmail = function( event ) {
	var email = jQuery( '.user-dashboard table.users tr:last .email' ).val();
	var firstname = jQuery( '.user-dashboard table.users tr:last .firstname' ).val();
	var lastname = jQuery( '.user-dashboard table.users tr:last .lastname' ).val();
	var domainMail = jQuery( '.input-domain-mail' ).val();
	var together = window.digirisk.global.remove_diacritics( firstname + '.' + lastname + '@' + domainMail ).toLowerCase();

	jQuery( '.user-dashboard table.users tr:last input[name="email"]' ).val( together );

	// Vérifie que l'évènement n'est pas déclenché dans le champ de texte du domaine de l'email.
	if ( 'input-domain-mail' !== event.target.className ) {
		window.digirisk.user_dashboard.keyEnterSendForm( event, jQuery( this ) );
	}
};

/**
 * Si la touche "entrée" est appuyé, appuies sur le bouton "plus" pour ajouter un utilisateur.
 *
 * @param  {KeyEvent} event L'état du clavier lors de l'évènement "keyup"
 * @return {void}
 */
window.digirisk.user_dashboard.keyEnterSendForm = function( event ) {
	if ( 13 === event.keyCode ) {
		jQuery( '.user-dashboard table.users tr:last .action-input' ).click();
	}
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
 * @version 6.2.4.0
 */
window.digirisk.user_dashboard.deletedUserSuccess = function( element, response ) {
  element.closest( 'tr' ).fadeOut();
};

window.digirisk.user_dashboard.loadedUserSuccess = function( element, response ) {
  element.closest( 'tr' ).replaceWith( response.data.template );
};

/**
 * Le callback en cas de réussite à la requête Ajax "save_user".
 * Remplaces le contenu du tableau "users" par le template renvoyé par la requête Ajax.
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 * @return {void}
 *
 * @since 1.0
 * @version 6.2.4.0
 */
window.digirisk.user_dashboard.savedUserSuccess = function( element, response ) {
  jQuery( '.user-dashboard table.users' ).html( response.data.template );
	jQuery( '.user-dashboard table.users tr:last input.lastname' ).focus();
};
