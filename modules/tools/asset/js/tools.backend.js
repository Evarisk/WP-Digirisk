"use strict";

var digi_tools = {
	$: undefined,

  event: function( $ ) {
		digi_tools.$ = $;

	  digi_tools.$( document ).on( 'click', '.reset-method-evaluation', function( event ) { digi_tools.reset( event, digi_tools.$( this ) ); } );
	  digi_tools.$( document ).on( 'click', '.digi-tools-main-container .nav-tab', function( event ) { digi_tools.tab_switcher( event, digi_tools.$( this ) ); } );
	  digi_tools.$( document ).on( 'click', '.element-risk-compilation', function( event ) { digi_tools.risk_fixer( event, digi_tools.$( this ) ); } );
  },

  tab_switcher: function( event, element ) {
	  event.preventDefault();

	  /**	Remove all calss active on all tabs	*/
	  digi_tools.$( element ).closest( "h2" ).children( ".nav-tab" ).each( function(){
		  digi_tools.$( this ).removeClass( "nav-tab-active" );
	  });
	  /**	Add the active class on clicked tab	*/
	  digi_tools.$( element ).addClass( "nav-tab-active" );

	  /**	Hide the different container and display the selected container	*/
	  digi_tools.$( element ).closest( ".digi-tools-main-container" ).children( "div" ).each( function(){
		  digi_tools.$( this ).hide();
	  });
	  digi_tools.$( "#" + digi_tools.$( element ).attr( "data-id" ) ).show();
  },

  reset: function( event, element ) {
    event.preventDefault();

    if ( window.confirm( window.digi_tools_confirm ) ) {
      digi_tools.$( element ).addClass( "wp-digi-loading" );
      digi_tools.$( element ).closest( 'div' ).find( 'ul' ).html('');

      var li = document.createElement( 'li' );
      li.innerHTML = window.digi_tools_in_progress;
      digi_tools.$( element ).closest( 'div' ).find( 'ul' ).append( li );

      var data = {
        action: 'reset_method_evaluation',
        _wpnonce: digi_tools.$( element ).data( 'nonce' )
      };

			digi_tools.exec_request( li, data, element );
    }
  },

  risk_fixer: function( event, element ) {
	  event.preventDefault();

    digi_tools.$( element ).addClass( "wp-digi-loading" );
    digi_tools.$( element ).closest( 'div' ).find( 'ul' ).html('');

    var li = document.createElement( 'li' );
    li.innerHTML = window.digi_tools_in_progress;
    digi_tools.$( element ).closest( 'div' ).find( 'ul' ).append( li );

    var data = {
      action: 'compil_risk_list',
      _wpnonce: digi_tools.$( element ).data( 'nonce' )
    };

    digi_tools.exec_request( li, data, element );
  },

	exec_request: function( li, data, element ) {
		digi_tools.$.post( window.ajaxurl, data, function() {
			digi_tools.$( element ).removeClass( "wp-digi-loading" );
			li.innerHTML += ' ' + window.digi_tools_done;
		} );
	}
};
