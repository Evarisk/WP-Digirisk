module.exports = function() {
	return function (nightmare) {
		nightmare
			.goto('http://localhost/wp-login.php')
			.wait()
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
