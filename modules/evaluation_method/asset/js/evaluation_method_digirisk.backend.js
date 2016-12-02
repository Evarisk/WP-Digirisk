window.digirisk.evaluation_method_digirisk = {};

window.digirisk.evaluation_method_digirisk.init = function() {
	window.digirisk.evaluation_method_digirisk.event();
};

window.digirisk.evaluation_method_digirisk.event = function() {
	jQuery( document ).on( 'click', 'ul.wp-digi-risk-cotation-chooser li.level-chooser', window.digirisk.evaluation_method_digirisk.select_cotation );
};

window.digirisk.evaluation_method_digirisk.select_cotation = function( event ) {
	var li 										= jQuery( this );
	var level 								= li.data( 'level' );
	var method_evaluation_id 	= li.closest( '.wp-digi-list-item' ).find( 'input.digi-method-simple' ).val();
	var toggle 								= li.closest( 'toggle' );
	var div 									= toggle.find( 'div.wp-digi-risk-level');
	div[0].className 					= div[0].className.replace( /wp-digi-risk-level-[0-4]/, 'wp-digi-risk-level-' + level );

	// Met la valeur dans la case toggle
	div.html( li.text() );

	// Met le niveau de la cotation dans le input risk-level
	li.closest( '.wp-digi-list-item' ).find( '.risk-level' ).val( level );

	// Met le méthode d'évaluation dans le input input-hidden-method-id
	li.closest( '.wp-digi-list-item' ).find( 'input.input-hidden-method-id' ).val( method_evaluation_id );
}
