module.exports = function() {
	return function (nightmare) {
		nightmare
			.type('input[name="workunit[title]"]', 'Mon unité de travail')
			.click('.wp-digi-new-workunit-action a')
			.wait(10000)
			.evaluate( function() {
				return window.__responses[window.currentAction];
			})
			.end()
			.then(function(result) {
				if( !result ) {
					console.error('error');
				}
				if ( !result.success ) {
					console.error('STOP');
				}
			})
			.catch(function(error) {
				console.error(error);
			})
	};
};
