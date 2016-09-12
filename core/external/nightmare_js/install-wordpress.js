module.exports = function() {
	return function (nightmare) {
		nightmare
			.goto('http://localhost/wordpress/wp-login.php')
			.evaluate(function() {
				return document.querySelector('body').innerHTML;
			})
			.end()
			.then(function(result) {
				// nightmare
				console.log('HERE');
				console.log(result);
			})
			.catch(function(err) {
				console.log(err);
			})

	};
};
