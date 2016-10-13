window.digirisk.risk = {};

window.digirisk.risk.init = function() {};

window.digirisk.risk.delete_success = function( element, response ) {
  element.closest( 'li' ).fadeOut();
}
