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
	},
	updateParentMenuItemDBId : function() {
		return this.each(function(){
			var item = jQuery(this),
				input = item.find( '.menu-item-data-parent-id' ),
				depth = parseInt( item.menuItemDepth(), 10 ),
				parentDepth = depth - 1,
				parent = item.prevAll( '.menu-item-depth-' + parentDepth ).first();

			if ( 0 === depth ) { // Item is on the top level, has no parent
				input.val(0);
			} else { // Find the parent item, and retrieve its object id.
				input.val( parent.find( '.menu-item-data-db-id' ).val() );
			}
		});
	}
});

function updateSharedVars(ui) {
	var depth;
	var t = window.digirisk.page_sorter;

	t.prev = ui.placeholder.prev( '.menu-item:not(.no-drop)' );
	t.next = ui.placeholder.next( '.menu-item' );

	// Make sure we don't select the moving item.
	if( t.prev[0] == ui.item[0] ) t.prev = t.prev.prev( '.menu-item:not(.no-drop)' );
	if( t.next[0] == ui.item[0] ) t.next = t.next.next( '.menu-item' );

	t.prevBottom = (t.prev.length) ? t.prev.offset().top + t.prev.height() : 0;
	t.nextThreshold = (t.next.length) ? t.next.offset().top + t.next.height() / 3 : 0;
	t.minDepth = (t.next.length) ? t.next.menuItemDepth() : 0;

	depth = t.prev.menuItemDepth() + 1;
	t.maxDepth = ( depth > t.globalMaxDepth ) ? t.globalMaxDepth : depth;
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
			var parent, children, height, width, tempHolder;

			window.digirisk.page_sorter.transport = ui.item.children('.menu-item-transport');
			window.digirisk.page_sorter.originalDepth = ui.item.menuItemDepth();
			window.digirisk.page_sorter.api.updateCurrentDepth(ui, window.digirisk.page_sorter.originalDepth);
			parent = ( ui.item.next()[0] == ui.placeholder[0] ) ? ui.item.next() : ui.item;
			children = parent.childMenuItems();
			window.digirisk.page_sorter.transport.append( children );

			// Update the height of the placeholder to match the moving item.
			height = window.digirisk.page_sorter.transport.outerHeight();
			// If there are children, account for distance between top of children and parent
			height += ( height > 0 ) ? (ui.placeholder.css('margin-top').slice(0, -2) * 1) : 0;
			height += ui.helper.outerHeight();
			window.digirisk.page_sorter.helperHeight = height;
			height -= 2; // Subtract 2 for borders
			ui.placeholder.height(height);

			// Update the width of the placeholder to match the moving item.
			window.digirisk.page_sorter.maxChildDepth = window.digirisk.page_sorter.originalDepth;
			children.each(function(){
				var depth = jQuery(this).menuItemDepth();
				window.digirisk.page_sorter.maxChildDepth = (depth > window.digirisk.page_sorter.maxChildDepth) ? depth : window.digirisk.page_sorter.maxChildDepth;
			});
			width = ui.helper.find('.menu-item-handle').outerWidth(); // Get original width
			width += window.digirisk.page_sorter.api.depthToPx(window.digirisk.page_sorter.maxChildDepth - window.digirisk.page_sorter.originalDepth); // Account for children
			width -= 2; // Subtract 2 for borders
			ui.placeholder.width(width);

			// Update the list of menu items.
			tempHolder = ui.placeholder.next( '.menu-item' );
			tempHolder.css( 'margin-top', window.digirisk.page_sorter.helperHeight + 'px' ); // Set the margin to absorb the placeholder
			ui.placeholder.detach(); // detach or jQuery UI will think the placeholder is a menu item
			jQuery(this).sortable( 'refresh' ); // The children aren't sortable. We should let jQ UI know.
			ui.item.after( ui.placeholder ); // reattach the placeholder.
			tempHolder.css('margin-top', 0); // reset the margin

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
			if ( depth > window.digirisk.page_sorter.maxDepth || offset.top < ( window.digirisk.page_sorter.prevBottom - 50 ) ) {
				depth = window.digirisk.page_sorter.maxDepth;
			} else if ( depth < window.digirisk.page_sorter.minDepth ) {
				depth = window.digirisk.page_sorter.minDepth.minDepth;
			}

			if( depth != window.digirisk.page_sorter.currentDepth && depth != undefined )
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
			ui.item.updateParentMenuItemDBId();

			// address sortable's incorrectly-calculated top in opera
			ui.item[0].style.top = 0;
		}

	}	);
};
