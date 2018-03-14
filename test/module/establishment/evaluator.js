var expect = require('chai').expect;
var fs = require("fs");

var evaluatorData = fs.readFileSync("./test/module/establishment/data/evaluator.json");
var evaluatorData = JSON.parse(evaluatorData);

module.exports.affect = function(nightmare, done, action) {

	for ( var i = 1; i < evaluatorData[action].number + 1; i++ ) {
		nightmare.click( '.form-edit-evaluator-assign .table tr:nth-child(' + i + ') input[type="checkbox"]' );
	}

	nightmare
		.click( '.action-input[data-parent="form-edit-evaluator-assign"]' )
		.wait(function() {
			if (window.currentResponse['callback_edit_evaluator_assign_success']) {
				return true;
			}
		})
		.evaluate(() => {
			var response = window.currentResponse['callback_edit_evaluator_assign_success'];
			delete window.currentResponse['callback_edit_evaluator_assign_success'];

			var success = true;
			var errors = [];

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			return response;
		})
		.then((response) => {
			expect(response.data.callback_success).to.equal('callback_edit_evaluator_assign_success');
			expect(response.success).to.equal(true);
		})
		.then(done, done);
}

module.exports.detach = function(nightmare, done) {

	nightmare
		.click( '.affected-evaluator .action-delete' )
		.wait(function() {
			if (window.currentResponse['callback_detach_evaluator_success']) {
				return true;
			}
		})
		.evaluate(() => {
			var response = window.currentResponse['callback_detach_evaluator_success'];
			delete window.currentResponse['callback_detach_evaluator_success'];

			var success = true;
			var errors = [];

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			return response;
		})
		.then((response) => {
			expect(response.data.callback_success).to.equal('callback_detach_evaluator_success');
			expect(response.success).to.equal(true);
		})
		.then(done, done);
}

module.exports.searchEvaluatorToAffect = function(nightmare, done) {

	nightmare
		.wait(1000)
		.type( 'input[data-target="form-edit-evaluator-assign"]', evaluatorData['searchEvaluatorToAffect'] )
		.wait(function() {
			if (window.currentResponse['searchedDisplayedEvaluatorToAffect']) {
				return true;
			}
		})
		.evaluate(() => {
			var response = window.currentResponse['searchedDisplayedEvaluatorToAffect'];
			delete window.currentResponse['searchedDisplayedEvaluatorToAffect'];

			var success = true;
			var errors = [];

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			return response;
		})
		.then((response) => {
			expect(response.data.callback_success).to.equal('searchedDisplayedEvaluatorToAffect');
			expect(response.success).to.equal(true);
		})
		.then(done, done);
}

module.exports.searchEvaluatorAffected = function(nightmare, done) {

	nightmare
		.wait(1000)
		.type( 'input[data-target="affected-evaluator"]', evaluatorData['searchEvaluatorAffected'] )
		.wait(function() {
			if (window.currentResponse['searchedDisplayedEvaluatorAffected']) {
				return true;
			}
		})
		.evaluate(() => {
			var response = window.currentResponse['searchedDisplayedEvaluatorAffected'];
			delete window.currentResponse['searchedDisplayedEvaluatorAffected'];

			var success = true;
			var errors = [];

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			return response;
		})
		.then((response) => {
			expect(response.data.callback_success).to.equal('searchedDisplayedEvaluatorAffected');
			expect(response.success).to.equal(true);
		})
		.then(done, done);
}

module.exports.paginate = function(nightmare, done) {

	nightmare
		.wait(1000)
		.click( '.wp-digi-pagination .dashicons-arrow-right' )
		.wait(function() {
			if ( document.body.contains( document.querySelector( '.wp-digi-pagination .prev' ) ) ) {
				return true;
			}
		})
		.evaluate(() => {
			return true;
		})
		.then((response) => {
			expect(response).to.equal(true);
		})
		.then(done, done);
}
