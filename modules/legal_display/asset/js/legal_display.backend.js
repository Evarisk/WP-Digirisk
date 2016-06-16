jQuery( document ).ready( function() {
  legal_display.init();
} );

var legal_display = {
  init: function() {
    legal_display.init_form();
  },

  init_form: function() {
    jQuery( '.form-legal-display' ).ajaxForm();
  }
};
