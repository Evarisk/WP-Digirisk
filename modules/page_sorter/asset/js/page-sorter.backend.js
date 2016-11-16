window.digirisk.page_sorter = {};
window.digirisk.page_sorter.currentDepth = 0;
window.digirisk.page_sorter.originalDepth;
window.digirisk.page_sorter.menuItemDepthPerLevel = 30;
window.digirisk.page_sorter.globalMaxDepth = 11;
window.digirisk.page_sorter.targetTolerance = 0;
window.digirisk.page_sorter.menuMaxDepth = 0;
window.digirisk.page_sorter.maxDepth = 0;
window.digirisk.page_sorter.minDepth = 0;
window.digirisk.page_sorter.depth = 0;
window.digirisk.page_sorter.menuEdge = 0;
window.digirisk.page_sorter.body = undefined;
window.digirisk.page_sorter.nextThreshold = 0;
window.digirisk.page_sorter.prev = undefined;
window.digirisk.page_sorter.next = undefined;
window.digirisk.page_sorter.prevBottom = undefined;
window.digirisk.page_sorter.transport = undefined;

var api = {};
api.menuList = undefined;

window.digirisk.page_sorter.api = {};
window.digirisk.page_sorter.api.pxToDepth = function(px) {
	return Math.floor(px / window.digirisk.page_sorter.menuItemDepthPerLevel);
}
window.digirisk.page_sorter.api.depthToPx = function(px) {
	return Math.floor(px / window.digirisk.page_sorter.menuItemDepthPerLevel);
}
window.digirisk.page_sorter.api.updateCurrentDepth = function(ui, depth) {
	ui.placeholder.updateDepthClass( depth, window.digirisk.page_sorter.currentDepth );
	window.digirisk.page_sorter.currentDepth = depth;
}

jQuery.fn.extend({
	menuItemDepth : function() {
		var margin = this.eq(0).css('margin-left');
		return window.digirisk.page_sorter.api.pxToDepth( margin && -1 != margin.indexOf('px') ? margin.slice(0, -2) : 0 );
	},
	updateDepthClass : function(current, prev) {
		return this.each(function(){
			var t = jQuery(this);
			prev = prev || t.menuItemDepth();
			jQuery(this).removeClass('menu-item-depth-'+ prev )
				.addClass('menu-item-depth-'+ current );
		});
	},
	childMenuItems : function() {
		var result = jQuery();
		this.each(function(){
			var t = jQuery(this), depth = t.menuItemDepth(), next = t.next( '.menu-item' );
			while( next.length && next.menuItemDepth() > depth ) {
				result = result.add( next );
				next = next.next( '.menu-item' );
			}
		});
		return result;
	},
	shiftDepthClass : function(change) {
		return this.each(function(){
			var t = jQuery(this),
				depth = t.menuItemDepth();
			jQuery(this).removeClass('menu-item-depth-'+ depth )
				.addClass('menu-item-depth-'+ (depth + change) );
		});
	}
});

function updateSharedVars(ui) {
	window.digirisk.page_sorter.prev = ui.placeholder.prev( '.menu-item' );
	window.digirisk.page_sorter.next = ui.placeholder.next( '.menu-item' );

	// Make sure we don't select the moving item.
	if( window.digirisk.page_sorter.prev[0] == ui.item[0] ) window.digirisk.page_sorter.prev = window.digirisk.page_sorter.prev.prev( '.menu-item' );
	if( window.digirisk.page_sorter.next[0] == ui.item[0] ) window.digirisk.page_sorter.next = window.digirisk.page_sorter.next.next( '.menu-item' );

	window.digirisk.page_sorter.prevBottom = (window.digirisk.page_sorter.prev.length) ? window.digirisk.page_sorter.prev.offset().top + window.digirisk.page_sorter.prev.height() : 0;
	window.digirisk.page_sorter.nextThreshold = (window.digirisk.page_sorter.next.length) ? window.digirisk.page_sorter.next.offset().top + window.digirisk.page_sorter.next.height() / 3 : 0;
	window.digirisk.page_sorter.minDepth = (window.digirisk.page_sorter.next.length) ? window.digirisk.page_sorter.next.menuItemDepth() : 0;

	if( window.digirisk.page_sorter.prev.length )
		window.digirisk.page_sorter.maxDepth = ( (window.digirisk.page_sorter.depth = window.digirisk.page_sorter.prev.menuItemDepth() + 1) > window.digirisk.page_sorter.globalMaxDepth ) ? window.digirisk.page_sorter.globalMaxDepth : window.digirisk.page_sorter.depth;
	else
		window.digirisk.page_sorter.maxDepth = 0
}

function initialMenuMaxDepth() {
	if( ! window.digirisk.page_sorter.body[0].className ) return 0;
	var match = window.digirisk.page_sorter.body[0].className.match(/menu-max-depth-(\d+)/);
	return match && match[1] ? parseInt( match[1], 10 ) : 0;
}

function updateMenuMaxDepth( depthChange ) {
	var newDepth = window.digirisk.page_sorter.menuMaxDepth;
	if ( depthChange === 0 ) {
		return;
	} else if ( depthChange > 0 ) {
		window.digirisk.page_sorter.depth = window.digirisk.page_sorter.maxChildDepth + depthChange;
		if( window.digirisk.page_sorter.depth > window.digirisk.page_sorter.menuMaxDepth )
			newDepth = window.digirisk.page_sorter.depth;
	} else if ( depthChange < 0 && window.digirisk.page_sorter.maxChildDepth == window.digirisk.page_sorter.menuMaxDepth ) {
		while( ! jQuery('.menu-item-depth-' + newDepth, api.menuList).length && newDepth > 0 )
			newDepth--;
	}
	// Update the depth class.
	window.digirisk.page_sorter.body.removeClass( 'menu-max-depth-' + window.digirisk.page_sorter.menuMaxDepth ).addClass( 'menu-max-depth-' + newDepth );
	window.digirisk.page_sorter.menuMaxDepth = newDepth;
}

window.digirisk.page_sorter.init = function() {
	api.menuList = jQuery('#menu-to-edit');
	window.digirisk.page_sorter.body = jQuery( 'body' );
	window.digirisk.page_sorter.menuMaxDepth = initialMenuMaxDepth();

	window.digirisk.page_sorter.currentDepth = 0;
	window.digirisk.page_sorter.menuEdge = api.menuList.offset().left;

	jQuery( '.sorter-page ul' ).sortable( {
		handle: '.menu-item-handle',
		placeholder: 'sortable-placeholder',
		items: '> *',
		start: function( e, ui ) {
			var parent, children;

			window.digirisk.page_sorter.transport = ui.item.children('.menu-item-transport');
			//
			window.digirisk.page_sorter.originalDepth = ui.item.menuItemDepth();
			window.digirisk.page_sorter.api.updateCurrentDepth(ui, window.digirisk.page_sorter.originalDepth);
			//
			parent = ( ui.item.next()[0] == ui.placeholder[0] ) ? ui.item.next() : ui.item;
			children = parent.childMenuItems();
			window.digirisk.page_sorter.transport.append( children );

			updateSharedVars( ui );
		},
		change: function(e, ui) {
			// Make sure the placeholder is inside the menu.
			// Otherwise fix it, or we're in trouble.
			if( ! ui.placeholder.parent().hasClass('menu') )
				(window.digirisk.page_sorter.prev.length) ? window.digirisk.page_sorter.prev.after( ui.placeholder ) : api.menuList.prepend( ui.placeholder );

			updateSharedVars(ui);
		},
		sort: function(e, ui) {
			var offset = ui.helper.offset(),
				edge = offset.left,
				depth = 1 * window.digirisk.page_sorter.api.pxToDepth( edge - window.digirisk.page_sorter.menuEdge );

			// Check and correct if depth is not within range.
			// Also, if the dragged element is dragged upwards over
			// an item, shift the placeholder to a child position.
			if ( depth > window.digirisk.page_sorter.maxDepth || offset.top < ( window.digirisk.page_sorter.prevBottom ) ) {
				depth = window.digirisk.page_sorter.maxDepth;
			} else if ( depth < window.digirisk.page_sorter.minDepth ) {
				depth = window.digirisk.page_sorter.minDepth.minDepth;
			}

			if( depth != window.digirisk.page_sorter.currentDepth )
				window.digirisk.page_sorter.api.updateCurrentDepth(ui, depth);

			// If we overlap the next element, manually shift downwards
			if( window.digirisk.page_sorter.nextThreshold && offset.top + window.digirisk.page_sorter.helperHeight > window.digirisk.page_sorter.nextThreshold ) {
				window.digirisk.page_sorter.next.after( ui.placeholder );
				updateSharedVars( ui );
				jQuery( this ).sortable( 'refreshPositions' );
			}
		},
		stop: function(e, ui) {
			var children, subMenuTitle,
				depthChange = window.digirisk.page_sorter.currentDepth - window.digirisk.page_sorter.originalDepth;
			// Return child elements to the list
			children = window.digirisk.page_sorter.transport.children().insertAfter(ui.item);

			// Update depth classes
			if ( 0 !== depthChange ) {
				ui.item.updateDepthClass( window.digirisk.page_sorter.currentDepth );
				children.shiftDepthClass( depthChange );
				updateMenuMaxDepth( depthChange );
			}
			// Register a change
			// api.registerChange();
			// Update the item data.
			// ui.item.updateParentMenuItemDBId();

			// address sortable's incorrectly-calculated top in opera
			ui.item[0].style.top = 0;
		}

	}	);
};


















// window.digirisk.page_sorter.send_request = function( event, ui ) {
// 	if ( this === ui.item.parent()[0] ) {
// 		var parent_id = jQuery( ui )[0].item.closest( 'ul.child' ).data( 'id' );
// 		var item_id = jQuery( ui )[0].item.data( 'id' );
//
// 		var data = {
// 			action: "sorter_parent",
// 			_wpnonce: jQuery( '.sorter-page #_wpnonce' ).val(),
// 			parent_id: parent_id,
// 			id: item_id
// 		};
//
// 		// Envoie de la requête
// 		jQuery.post( ajaxurl, data, function() {
// 			jQuery( '.sorter-page .updated' ).show();
// 			setTimeout( function() {
// 				jQuery( '.sorter-page .updated' ).fadeOut();
// 			}, 2000 );
// 		} );
// 	}
// };
