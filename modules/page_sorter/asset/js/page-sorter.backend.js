window.eoxiaJS.page_sorter = {};
window.evaMenu = {};
window.evaMenu.depth = 0;
window.evaMenu.prev = undefined;
window.evaMenu.startDepth = 0;
window.evaMenu.childs = [];
window.eoxiaJS.page_sorter.init = function() {
	var menu = jQuery( '.sorter-page .menu' );

	jQuery( '.sorter-page .menu' ).sortable( {
		handle: '.menu-item-handle',
		placeholder: 'sortable-placeholder',
		items: '> *',
		start: function( e, ui ) {
			window.evaMenu.startDepth = parseInt( ui.item.attr( 'data-depth' ) );
			window.evaMenu.childs = window.evaMenu.getChildItems(ui.item);
			ui.item.children( '.menu-item-transport' ).append( window.evaMenu.childs );
		},
		sort: function(e, ui) {
			var menuEdge = jQuery( '#menu-to-edit' ).offset().left;
			var offset = ui.helper.offset();
			var edge = offset.left - menuEdge;
			window.evaMenu.depth = Math.floor(edge / 30);

			window.evaMenu.prev = ui.placeholder.prev( 'li' );
			var next = ui.placeholder.next( 'li' );

			if( window.evaMenu.prev[0] == ui.item[0] ) window.evaMenu.prev = window.evaMenu.prev.prev( 'li' );
			if( next[0] == ui.item[0] ) next = next.next( 'li' );

			var prevDepth = 0;

			if (window.evaMenu.prev && window.evaMenu.prev.attr('class')) {
				prevDepth = parseInt( window.evaMenu.prev.attr( 'data-depth' ) );
			}

			var nextDepth = 0;

			if (next && next.attr('class')) {
				nextDepth = parseInt( next.attr( 'data-depth' ) );
			}

			if (window.evaMenu.depth < prevDepth) {
				window.evaMenu.depth = prevDepth;
			}
			else if (window.evaMenu.depth > prevDepth + 1) {
				window.evaMenu.depth = prevDepth + 1;
			}

			if (nextDepth - window.evaMenu.depth == 1) {
				window.evaMenu.depth = prevDepth + 1;
			}

			if (!window.evaMenu.prev.data('drop')) {
				window.evaMenu.depth = prevDepth;
			}

			ui.placeholder[0].className = 'menu-item-depth-' + window.evaMenu.depth + ' sortable-placeholder';
		},
		stop: function(e, ui) {
			ui.item[0].className = 'menu-item-depth-' + window.evaMenu.depth;
			ui.item.attr( 'data-depth', window.evaMenu.depth );

			if (!ui.item.data('drop')) {
				ui.item[0].className += " no-drop";
			}

			window.evaMenu.childs.insertAfter( ui.item );

			var diffDepth = window.evaMenu.depth - window.evaMenu.startDepth;

			if (window.evaMenu.childs.length > 0) {
				for ( var i = 0; i < window.evaMenu.childs.length; i++ ) {
					if (window.evaMenu.childs[i]) {
						var currentDepth = parseInt( jQuery( window.evaMenu.childs[i] ).attr( 'data-depth' ) );
						var newDepth = currentDepth + diffDepth;

						window.evaMenu.childs[i].className = 'menu-item-depth-' + newDepth;
						jQuery( window.evaMenu.childs[i] ).attr( 'data-depth', newDepth );
						if (! jQuery( window.evaMenu.childs[i] ).data('drop')) {
							window.evaMenu.childs[i].className += " no-drop";
						}
					}
				}
			}

			window.evaMenu.updateParentId(ui.item);
		}
	}	);
};

window.evaMenu.getChildItems = function(ui) {
	var result = jQuery();
	ui.each( function() {
		var t = jQuery(this);
		var depth = parseInt( t.attr( 'data-depth' ) );
		var next = t.next( 'li' ).next('li');

		if (next.attr( 'class' )) {
			var nextDepth = parseInt( next.attr( 'data-depth' ) );

			while( next.length && nextDepth > depth ) {
				result = result.add( next );
				next = next.next( 'li' );
				if (next && next.attr( 'class' )) {
					nextDepth = parseInt( next.attr( 'data-depth' ) );
				}
			}
		}

	} );
	return result;
}

window.evaMenu.updateParentId = function( item ) {
	var parentId = 0;
	var itemDepth = parseInt( jQuery( item ).attr( 'data-depth' ) );
	var prevDepth = itemDepth - 1;
	var parent = undefined;

	console.log(itemDepth);

	if ( prevDepth >= 0 ) {
		parent = item.prevAll( '.menu-item-depth-' + prevDepth ).first();
		parentId = parent.find( '.menu-item-data-db-id' ).val();
	}

	item.find( '.menu-item-data-parent-id' ).val( parentId );
}
