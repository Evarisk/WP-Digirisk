"use strict"

jQuery( document ).ready( function(){
  digi_tools.event();
});


var digi_tools = {

  event: function() {
	  jQuery( document ).on( 'click', '.reset-method-evaluation', function( event ) { digi_tools.reset( event, jQuery( this ) ); } );
	  jQuery( document ).on( 'click', '.digi-tools-main-container .nav-tab', function( event ) { digi_tools.tab_switcher( event, jQuery( this ) ); } );
	  jQuery( document ).on( 'click', '.element-risk-compilation', function( event ) { digi_tools.risk_fixer( event, jQuery( this ) ); } );
  },

  tab_switcher: function( event, element ) {
	  event.preventDefault();

	  /**	Remove all calss active on all tabs	*/
	  jQuery( element ).closest( "h2" ).children( ".nav-tab" ).each( function(){
		  jQuery( this ).removeClass( "nav-tab-active" );
	  });
	  /**	Add the active class on clicked tab	*/
	  jQuery( element ).addClass( "nav-tab-active" );

	  /**	Hide the different container and display the selected container	*/
	  jQuery( element ).closest( ".digi-tools-main-container" ).children( "div" ).each( function(){
		  jQuery( this ).hide();
	  });
	  jQuery( "#" + jQuery( element ).attr( "data-id" ) ).show();
  },

  reset: function( event, element ) {
    event.preventDefault();

    if ( confirm ( digi_tools_confirm ) ) {
      jQuery( element ).addClass( "wp-digi-loading" );
      jQuery( element ).closest( '.wrap' ).find( 'ul' ).html('');

      var li = document.createElement( 'li' );
      li.innerHTML = digi_tools_in_progress;
      jQuery( element ).closest( '.wrap' ).find( 'ul' ).append( li );

      var data = {
        action: 'reset_method_evaluation',
        _wpnonce: jQuery( element ).data( 'nonce' )
      };

      jQuery.post( ajaxurl, data, function() {
        jQuery( element ).removeClass( "wp-digi-loading" );
        li.innerHTML += ' ' + digi_tools_done;
      } );
    }
  },

  risk_fixer: function( event, element ) {
	  event.preventDefault();

      jQuery( element ).addClass( "wp-digi-loading" );
      jQuery( element ).closest( '.wrap' ).find( 'ul' ).html('');

      var li = document.createElement( 'li' );
      li.innerHTML = digi_tools_in_progress;
      jQuery( element ).closest( '.wrap' ).find( 'ul' ).append( li );

      var data = {
        action: 'compil_risk_list',
        _wpnonce: jQuery( element ).data( 'nonce' )
      };

      jQuery.post( ajaxurl, data, function() {
        jQuery( element ).removeClass( "wp-digi-loading" );
        li.innerHTML += ' ' + digi_tools_done;
      } );
  }

}
