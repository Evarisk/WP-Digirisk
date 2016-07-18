"use strict";

var legal_display = {
	$: undefined,
  init: function( $ ) {
		legal_display.$ = $;

    legal_display.init_form();
  },

  init_form: function() {
    var options = {
      beforeSubmit: function( formData, jqForm, options ) {
        /**	Adding loading class to form button	*/
        legal_display.$( '.form-legal-display .generate-legal-display' ).addClass( "wp-digi-loading" );
      },
      success: function( responseText, statusText, xhr, $form ) {
        legal_display.$( '.form-legal-display .generate-legal-display' ).removeClass( "wp-digi-loading" );
				legal_display.$( '.wp-digi-global-sheet-tab li[data-action="digi-sheet"]' ).click();
      }
    };

    legal_display.$( document ).on( "click", '.form-legal-display button', function(){
	    legal_display.$( this ).closest( 'form' ).ajaxSubmit(options);
	    return false;
	  });
  }

};
