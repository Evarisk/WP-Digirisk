
var load_user = function(id) {
	return function (nightmare) {
		nightmare
			.click('a.dashicons-edit[data-id="' + id + '"]')
			.wait('form[data-id="'+id+'"]')
			.evaluate( function() {
				return window.__responses[window.currentAction];
			})
			.then(function(result) {
				console.log(result);
				if ( !result ) {
					console.error('error');
				}

				if ( !result.success ) {
					console.error('STOP');
				}

				// nightmare.use(load_user(result.data.id));
			})
			.catch(function(error) {
				console.error(error);
			})
	}
}

module.exports.create_user = function(lastname, firstname) {
	return function (nightmare) {
		nightmare
			.type('input[name="user[lastname]"]', lastname)
			.type('input[name="user[firstname]"]', firstname)
			.click('span.add-staff a')
			.wait(3000)
			.evaluate( function() {
				return window.__responses[window.currentAction];
			})
			.then(function(result) {
				if ( !result ) {
					console.error('error');
				}

				if ( !result.success ) {
					console.error('STOP');
				}

				nightmare.use(load_user(result.data.id));
			})
			.catch(function(error) {
				console.error(error);
			})
	};
};

module.exports.load_user = load_user;
