jQuery( document ).ready( function() {
  legal_display.init();
} );

var legal_display = {
  init: function() {
    legal_display.init_form();
  },

  init_form: function() {
    var options = {
      beforeSubmit: function( formData, jqForm, options ) {
        /**	Adding loading class to form button	*/
        jQuery( '.form-legal-display .generate-legal-display' ).addClass( "wp-digi-loading" );
      },
      success: function( responseText, statusText, xhr, $form ) {
        jQuery( '.form-legal-display .generate-legal-display' ).removeClass( "wp-digi-loading" );
      }
    };
    jQuery( '.form-legal-display' ).ajaxForm(options);
  }
};
