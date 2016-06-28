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

    jQuery( document ).on( "click", '.form-legal-display button', function(){
	    jQuery( this ).closest( 'form' ).ajaxSubmit(options);
	    return false;
	  });
  }

};
