window.digirisk.page_sorter = {};
window.digirisk.page_sorter.init = function() {
	jQuery( 'ul' ).sortable( {
		axis: "y",
		handle: "span",
		placeholder: "ui-state-highlight",
		connectWith: "ul"
	}	);
};
