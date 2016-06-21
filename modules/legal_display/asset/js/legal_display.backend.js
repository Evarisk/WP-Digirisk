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
        legal_display.download_export( responseText.data.path );
      }
    };

    jQuery( document ).on( "click", '.form-legal-display button', function(){
	    jQuery( this ).closest( 'form' ).ajaxSubmit(options);
	    return false;
	  });
  },

  download_export: function(url_to_file) {

		var url = jQuery('<a href="' + url_to_file + '" download="affichage_legal.odt"></a>');
		jQuery('.form-legal-display').append(url);
		url[0].click();
		url.remove();
	}

};
