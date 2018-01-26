var expect = require('chai').expect;
var fs = require("fs");

var recommendationData = fs.readFileSync("./test/module/establishment/data/recommendation.json");
var recommendationData = JSON.parse(recommendationData);

module.exports.create = function(nightmare, done) {
	for ( var key in recommendationData.recommendations ) {
		nightmare
			.click( '.recommendation-row.edit .categorie-container' )
			.click( '.recommendation-row.edit .content.active li[aria-label="' + recommendationData.recommendations[key].name + '"]' )
			.click( '.recommendation-row.edit .action-input' )
			.wait(function() {
				if (window.currentResponse['savedRecommendationSuccess']) {
					return true;
				}
			})
			.evaluate(() => {
				var response = window.currentResponse['savedRecommendationSuccess'];
				delete window.currentResponse['savedRecommendationSuccess'];

				var success = true;
				var errors = [];

				if ( ! document.body.contains( document.querySelector( '.recommendation-row[data-id="' + response.data.element.id + '"]' ) ) ) {
					response.success = false;
				}

				response.data.errors = errors;

				if ( response.data.errors.length ) {
					response.success = false;
				}

				window.allRecommendationsResponse.push( response );
				return window.allRecommendationsResponse;
			})

	}

	nightmare.then((response) => {
		for ( var i = 0; i < response.length; i++ ) {
			expect(response[i].data.callback_success).to.equal('savedRecommendationSuccess');
			expect(response[i].success).to.equal(true);
		}

	})
	.then(done, done);
};

module.exports.load = function(nightmare, done) {
	nightmare.
		click( '.recommendation-row .action-attribute.edit' )
		.wait(function() {
			if (window.currentResponse['loadedRecommendationSuccess']) {
				return true;
			}
		})
		.evaluate(() => {
			var response = window.currentResponse['loadedRecommendationSuccess'];
			delete window.currentResponse['loadedRecommendationSuccess'];

			var success = true;
			var errors = [];

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			return response;
		})
		.then((response) => {
			expect(response.data.callback_success).to.equal('loadedRecommendationSuccess');
			expect(response.success).to.equal(true);
		})
		.then(done, done);
};

module.exports.edit = function(nightmare, done) {
	nightmare
	.click( '.recommendation-row.edit .action .action-input.save' )
	.wait(function() {
		if (window.currentResponse['savedRecommendationSuccess']) {
			return true;
		}
	})
	.evaluate(() => {
		var response = window.currentResponse['savedRecommendationSuccess'];
		delete window.currentResponse['savedRecommendationSuccess'];

		var success = true;
		var errors = [];

		if ( ! document.body.contains( document.querySelector( '.recommendation-row[data-id="' + response.data.element.id + '"]' ) ) ) {
			response.success = false;
		}

		response.data.errors = errors;

		if ( response.data.errors.length ) {
			response.success = false;
		}

		return response;
	})
	.then((response) => {
		expect(response.data.callback_success).to.equal('savedRecommendationSuccess');
		expect(response.success).to.equal(true);
	})
	.then(done, done);
};

module.exports.delete = function(nightmare, done) {
	nightmare
	.click( '.recommendation-row .action-delete' )
	.wait(function() {
		if (window.currentResponse['deletedRecommendationSuccess']) {
			return true;
		}
	})
	.evaluate(() => {
		var response = window.currentResponse['deletedRecommendationSuccess'];
		delete window.currentResponse['deletedRecommendationSuccess'];

		var success = true;
		var errors = [];

		response.data.errors = errors;

		if ( response.data.errors.length ) {
			response.success = false;
		}

		return response;
	})
	.then((response) => {
		expect(response.data.callback_success).to.equal('deletedRecommendationSuccess');
		expect(response.success).to.equal(true);
	})
	.then(done, done);
};
