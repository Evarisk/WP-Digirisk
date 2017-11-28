/**
 * Initialise l'objet 'legalDisplay' ainsi que la méthode 'init' obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 6.3.0
 * @version 6.4.0
 */

window.eoxiaJS.digirisk.pageSorter = {};

window.eoxiaJS.digirisk.pageSorter.init = function() {
	jQuery( document ).on( 'click', '.sorter-page .button.button-primary', function( event ) {
		window.removeEventListener( 'beforeunload', window.eoxiaJS.digirisk.pageSorter.safeExit );
	} );

	if ( jQuery( '.sorter-page' ).length ) {
		jQuery( '.treetable' ).treetable( {	expandable: true } );
		jQuery( '.treetable' ).treetable( 'expandAll' );

		jQuery( '.treetable .digi-workunit, .treetable .digi-group' ).draggable( {
			helper: 'clone',
			opacity: .75,
			refreshPositions: true,
			revert: 'invalid',
			revertDuration: 300,
			scroll: true
		} );

		jQuery( '.treetable .digi-group, .digi-society' ).each( function() {
			jQuery( this ).parents( '.treetable tr' ).droppable( {
				accept: '.digi-workunit, .digi-group',
				drop: function( e, ui ) {
					var droppedEl = ui.draggable.parents( 'tr' );

					if ( droppedEl.data( 'ttId' ) == jQuery( this ).data( 'ttParentId' ) ) {
						e.preventDefault();
						return false;
					} else {
						window.addEventListener( 'beforeunload', window.eoxiaJS.digirisk.pageSorter.safeExit );

						jQuery( 'input[type="submit"]' ).attr( 'disabled', false );

						jQuery( 'input[name="menu_item_parent_id[' + droppedEl.data( 'ttId' ) + ']"]' ).val( jQuery( this ).data( 'ttId' ) );
						jQuery( '.treetable' ).treetable( 'move', droppedEl.data( 'ttId' ), jQuery( this ).data( 'ttId' ) );
					}
				},
				hoverClass: 'accept',
				over: function( e, ui ) {
					var droppedEl = ui.draggable.parents( 'tr' );
					if ( this != droppedEl[0] && ! jQuery( this ).is( '.expanded' ) ) {
						jQuery( '.treetable' ).treetable( 'expandNode', jQuery( this ).data( 'ttId' ) );
					}
				}
			});
		});
	}
};

/**
 * Vérification avant la fermeture de la page si toutes les données sont enregistrées.
 *
 * @since 6.3.0
 * @version 6.4.0
 *
 * @param  {WindowEventHandlers} event L'évènement de la fenêtre.
 * @return {string}
 */
window.eoxiaJS.digirisk.pageSorter.safeExit = function( event ) {
	var confirmationMessage = 'Vos données sont en attentes d\'enregistrement';

	event.returnValue = confirmationMessage;
	return confirmationMessage;
};
