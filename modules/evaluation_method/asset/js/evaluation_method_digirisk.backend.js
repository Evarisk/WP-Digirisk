window.digirisk.evaluation_method_digirisk = {};

window.digirisk.evaluation_method_digirisk.init = function() {
	window.digirisk.evaluation_method_digirisk.event();
};

window.digirisk.evaluation_method_digirisk.event = function() {
	jQuery( document ).on( 'click', '.table.risk .cotation-container li.item:not(.open-popup)', window.digirisk.evaluation_method_digirisk.select_cotation );
};

window.digirisk.evaluation_method_digirisk.select_cotation = function( event ) {
	var element = jQuery( this );
	var level = element.data( 'level' );
	var methodEvaluationId = element.closest( 'tr' ).find( 'input.digi-method-simple' ).val();
	var div = element.closest( '.cotation-container' );

	div.find( '.action span' ).html( element.text() );
	div.find( '.action i' ).hide();
	element.closest( '.content' ).removeClass( 'active' );
	div.find( '.action' )[0].className = div.find( '.action' )[0].className.replace( /level[0-4]/, 'level' + level );
	event.stopPropagation();

	// Met le niveau de la cotation dans le input risk-level
	element.closest( 'tr' ).find( '.risk-level' ).val( level );

	// Met le méthode d'évaluation dans le input input-hidden-method-id
	element.closest( 'tr' ).find( 'input.input-hidden-method-id' ).val( methodEvaluationId );
};
