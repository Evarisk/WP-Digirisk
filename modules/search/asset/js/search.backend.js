"use strict";

var digi_search = {
	$: undefined,
	event: function( $ ) {
		digi_search.$ = $;

		/** Auto complete */
		/**
		* Paramètre à ajouter sur la balise html
		* Ne pas oublier la classe : wp-digi-bloc-loader
		* int data-element-id : ID d'un élément ex: workunit_id
		* string data-callback : Pour appeler une fonction après avoir récupére la liste des ID des utilisateurs.
		* string append-to : Le bloc ou sera affiche le rendu
		*/
		digi_search.$.each( digi_search.$( '.wp-list-search input' ), function( key, element ) {
			// Automatiser la source
			var list_option = {
				'source': 'admin-ajax.php?action=digi_search'
									+ '&next_action='	+ digi_search.$( element ).data( "next-action" )
									// + '&field=' 			+ digi_search.$( element ).data( 'field' )
									+ '&class=' 			+ digi_search.$( element ).data( 'class' )
									+ '&id=' 					+ digi_search.$( element ).data( "id" )
									+ '&type=' 				+ digi_search.$( element ).data( "type" ),
				'minLength': 0,
			};

			if ( digi_search.$ ( element ).data( 'target' ) ) {
				list_option.search = function( event, ui ) {
					digi_search.$( '.' + digi_search.$( element ).data( 'target' ) ).addClass( 'wp-digi-bloc-loading' );
				};

				list_option.response = function( event, response ) {
					digi_search.$( '.' + digi_search.$( element ).data( 'target' ) ).replaceWith( response.content[1].template );
				};

				list_option.open = function( event, ui ) {
					digi_search.$( element ).autocomplete( 'close' );
				};
			}

			if( digi_search.$( element ).data( 'field' ) ) {
				list_option.select = function( event, ui ) {
					digi_search.$( 'input[name="' + digi_search.$( element ).data('field') + '"]' ).val( ui.item.id );
					digi_global.$( '.wp-digi-group-action-container' ).removeClass( "hidden" );
        	digi_global.$( '.wp-digi-group-action-container .wp-digi-bton-fourth' ).text( 'Déplacer' );
				};
			}

			digi_search.$( element ).autocomplete( list_option );
		} );
  }
};
