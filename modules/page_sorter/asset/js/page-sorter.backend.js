window.digirisk.page_sorter = {};
window.evaMenu = {};
window.evaMenu.depth = 0;
window.evaMenu.startDepth = 0;
window.evaMenu.childs = [];
window.digirisk.page_sorter.init = function() {
	var menu = jQuery( '.sorter-page .menu' );

	jQuery( '.sorter-page .menu' ).sortable( {
		handle: '.menu-item-handle',
		placeholder: 'sortable-placeholder',
		items: '> *',
		start: function( e, ui ) {
			window.evaMenu.startDepth = parseInt(ui.item.closest('li').attr( 'class' ).replace( 'menu-item-depth-', '' ));
			window.evaMenu.childs = window.evaMenu.getChildItems(ui.item);
			ui.item.children( '.menu-item-transport' ).append( window.evaMenu.childs );
		},
		sort: function(e, ui) {
			var menuEdge = jQuery( '#menu-to-edit' ).offset().left;
			var offset = ui.helper.offset();
			var edge = offset.left - menuEdge;
			window.evaMenu.depth = Math.floor(edge / 30);

			var prev = ui.placeholder.prev( 'li' );
			var next = ui.placeholder.next( 'li' );

			if( prev[0] == ui.item[0] ) prev = prev.prev( 'li' );
			if( next[0] == ui.item[0] ) next = next.next( 'li' );

			var prevDepth = 0;

			if (prev && prev.attr('class')) {
				prevDepth = parseInt(prev.attr( 'class' ).replace( 'menu-item-depth-', '' ));
			}

			var nextDepth = 0;

			if (next && next.attr('class')) {
				nextDepth = parseInt(next.attr( 'class' ).replace( 'menu-item-depth-', '' ));
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

			ui.placeholder[0].className = 'menu-item-depth-' + window.evaMenu.depth + ' sortable-placeholder';
		},
		stop: function(e, ui) {
			ui.item[0].className = 'menu-item-depth-' + window.evaMenu.depth;
			window.evaMenu.childs.insertAfter( ui.item );

			var diffDepth = window.evaMenu.depth - window.evaMenu.startDepth;

			for ( var key in window.evaMenu.childs ) {
				var currentDepth = parseInt(window.evaMenu.childs[key].className.replace( 'menu-item-depth-', '' ));
				var newDepth = currentDepth + diffDepth;
				window.evaMenu.childs[key].className = 'menu-item-depth-' + newDepth;
			}
		}
	}	);
};

window.evaMenu.getChildItems = function(ui) {
	var result = jQuery();
	ui.each( function() {
		var t = jQuery(this);
		var depth = parseInt(t.attr( 'class' ).replace( 'menu-item-depth-', '' ))
		var next = t.next( 'li' ).next('li');

		if (next.attr( 'class' )) {
			var nextDepth = parseInt(next.attr( 'class' ).replace( 'menu-item-depth-', '' ));

			while( next.length && nextDepth > depth ) {
				result = result.add( next );
				next = next.next( 'li' );
				if (next && next.attr( 'class' )) {
					nextDepth = parseInt(next.attr( 'class' ).replace( 'menu-item-depth-', '' ));
				}
			}
		}

	} );
	return result;
}
