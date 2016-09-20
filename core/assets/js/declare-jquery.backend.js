jQuery( document ).ready(function( $ ) {

	digi_global.init( $ );
	legal_display.init( $ );
	digi_recommendation.init( true, $ );
	digi_risk.init( true, $ );
	digi_danger.init( true, $ );
	digi_search.event( $ );
	digi_tools.event( $ );
	digi_installer.event( $ );
	digi_global.event( $ );
	digi_evaluation_method.event( $ );
	digi_evaluator.event( $ );
	file_management.event( $ );
	wpeo_gallery.event( $ );
	digi_group.event( $ );
	digi_society.event( $ );
	digi_workunit.event( $ );
	digi_tab.event( $ );
	digi_user.event( $ );
	digi_document.event( $ );
} );
