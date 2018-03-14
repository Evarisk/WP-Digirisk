var expect = require('chai').expect;
var fs = require("fs");

var riskData = fs.readFileSync("./test/module/establishment/data/risk.json");
var riskData = JSON.parse(riskData);

module.exports.createRiskSimpleCotation = function(nightmare, done) {
	for ( var key in riskData["createRiskSimpleCotation"] ) {
		nightmare
		.wait(2000)
		.click( '.risk-row.edit .categorie-container' )
		.click( '.risk-row.edit .content.active li[aria-label="' + riskData["createRiskSimpleCotation"][key]["categoryRiskAriaLabel"] + '"]' )
		.click( '.risk-row.edit .cotation-container' )
		.click( '.risk-row.edit .content.active li[data-level="' + riskData["createRiskSimpleCotation"][key]["cotationLevel"] + '"]' )
		.click( '.risk-row.edit .action .action-input' )
		.wait(function() {
			if (window.currentResponse['savedRiskSuccess']) {
				return true;
			}
		})
		.evaluate(() => {
			var response = window.currentResponse['savedRiskSuccess'];
			delete window.currentResponse['savedRiskSuccess'];

			var success = true;
			var errors = [];

			if ( ! document.body.contains( document.querySelector( '.risk-row[data-id="' + response.data.risk.id + '"] .cotation-container .action.level' + window.riskData["createRiskSimpleCotation"][window.allRiskSimpleResponse.length]["cotationLevel"] ) ) ) {
				errors.push( 'risk.cotation level is not equal ' + window.riskData["createRiskSimpleCotation"][window.allRiskSimpleResponse.length]["cotationLevel"]  );
			}

			if ( ! document.body.contains( document.querySelector( '.risk-row[data-id="' + response.data.risk.id + '"] .categorie-container .action .tooltip[aria-label="' + window.riskData["createRiskSimpleCotation"][window.allRiskSimpleResponse.length]["categoryRiskAriaLabel"] + '"]' ) ) ) {
				errors.push( 'risk.categoryRisk is not equal ' + window.riskData["createRiskSimpleCotation"][window.allRiskSimpleResponse.length]["categoryRiskAriaLabel"]  );
			}

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			window.allRiskSimpleResponse.push( response );
			return window.allRiskSimpleResponse;
		})
	}

	nightmare.then((response) => {
		for ( var i = 0; i < response.length; i++ ) {
			expect(response[i].data.callback_success).to.equal('savedRiskSuccess');
			expect(response[i].success).to.equal(true);
		}

	})
	.then(done, done);
}

module.exports.loadRiskSimple = function(nightmare, done) {
	nightmare
		.click( '.risk-row.method-evarisk-simplified .edit.action-attribute' )
		.wait(function() {
			if (window.currentResponse['loadedRiskSuccess']) {
				return true;
			}
		})
		.evaluate(() => {
			var response = window.currentResponse['loadedRiskSuccess'];
			Object.keys(window.currentResponse).forEach(function(key) { delete window.currentResponse[key]; });
			window.currentResponse['loadedRiskSuccess'] = {};
			delete window.currentResponse['loadedRiskSuccess'];

			var success = true;
			var errors = [];

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			return response;
		})
		.then((response) => {
			expect(response.data.callback_success).to.equal('loadedRiskSuccess');
			expect(response.success).to.equal(true);
		})
		.then(done, done);
}


module.exports.editRiskSimple = function(nightmare, done) {
	nightmare
		.click( '.risk-row.edit .cotation-container' )
		.click( '.risk-row.edit .content.active li[data-level="' + riskData["editRiskSimpleCotation"]["cotationLevel"] + '"]' )
		.click( '.risk-row.edit .action .action-input' )
		.wait(function() {
			if (window.currentResponse['savedRiskSuccess']) {
				return true;
			}
		})
		.evaluate(() => {
			var response = window.currentResponse['savedRiskSuccess'];
			delete window.currentResponse['savedRiskSuccess'];

			var success = true;
			var errors = [];

			if ( ! document.body.contains( document.querySelector( '.risk-row[data-id="' + response.data.risk.id + '"] .cotation-container .action.level' + window.riskData["editRiskSimpleCotation"]["cotationLevel"] ) ) ) {
				errors.push( 'risk.cotation level is not equal ' + window.riskData["editRiskSimpleCotation"]["cotationLevel"]  );
			}

			if ( ! document.body.contains( document.querySelector( '.risk-row[data-id="' + response.data.risk.id + '"] .categorie-container .action .tooltip[aria-label="' + window.riskData["editRiskSimpleCotation"]["categoryRiskAriaLabel"] + '"]' ) ) ) {
				errors.push( 'risk.categoryRisk is not equal ' + window.riskData["editRiskSimpleCotation"]["categoryRiskAriaLabel"]  );
			}

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			return response;
		})
		.then((response) => {
			expect(response.data.callback_success).to.equal('savedRiskSuccess');
			expect(response.success).to.equal(true);
		})
		.then(done, done);
}

module.exports.createRiskComplexCotation = function(nightmare, done) {
	nightmare
		.click( '.risk-row.edit .categorie-container' )
		.click( '.risk-row.edit .content.active li[aria-label="' + riskData["createRiskComplexCotation"]["categoryRiskAriaLabel"] + '"]' )
		.click( '.risk-row.edit .cotation-container' )
		.click( '.risk-row.edit .content.active li.open-popup' );

		for( var key in riskData["createRiskComplexCotation"]["cotationLevel"] ) {
			nightmare.click( '.popup.popup-evaluation.active .table-evaluation td[data-slug="' + riskData["createRiskComplexCotation"]["cotationLevel"][key] + '"]' );
		}

		nightmare.click( '.popup.popup-evaluation.active .button.green' )
		.wait(function() {
			if (window.currentResponse['gettedScale']) {
				return true;
			}
		})
		.evaluate(() =>{
			delete window.currentResponse['gettedScale'];
		})
		.wait(3000)
		.click( '.risk-row.edit .action .action-input' )
		.wait(function() {
			if (window.currentResponse['savedRiskSuccess']) {
				return true;
			}
		})
		.evaluate(() => {
			var response = window.currentResponse['savedRiskSuccess'];
			delete window.currentResponse['savedRiskSuccess'];

			var success = true;
			var errors = [];

			if ( ! document.body.contains( document.querySelector( '.risk-row[data-id="' + response.data.risk.id + '"] .cotation-container .action.level' + window.riskData["createRiskComplexCotation"]["cotationLevelValue"] ) ) ) {
				errors.push( 'risk.cotation level is not equal ' + window.riskData["createRiskComplexCotation"]["cotationLevelValue"]  );
			}

			if ( ! document.body.contains( document.querySelector( '.risk-row[data-id="' + response.data.risk.id + '"] .categorie-container .action .tooltip[aria-label="' + window.riskData["createRiskComplexCotation"]["categoryRiskAriaLabel"] + '"]' ) ) ) {
				errors.push( 'risk.categoryRisk is not equal ' + window.riskData["createRiskComplexCotation"]["categoryRiskAriaLabel"]  );
			}

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			return response;
		})
		.then((response) => {
			expect(response.data.callback_success).to.equal('savedRiskSuccess');
			expect(response.success).to.equal(true);
		})
		.then(done, done);
}

module.exports.loadRiskComplex = function(nightmare, done) {
	nightmare
		.click( '.risk-row.method-evarisk .edit.action-attribute' )
		.wait(function() {
			if (window.currentResponse['loadedRiskSuccess']) {
				return true;
			}
		})
		.evaluate(() => {
			var response = window.currentResponse['loadedRiskSuccess'];
			Object.keys(window.currentResponse).forEach(function(key) { delete window.currentResponse[key]; });
			window.currentResponse['loadedRiskSuccess'] = {};
			delete window.currentResponse['loadedRiskSuccess'];

			var success = true;
			var errors = [];

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			return response;
		})
		.then((response) => {
			expect(response.data.callback_success).to.equal('loadedRiskSuccess');
			expect(response.success).to.equal(true);
		})
		.then(done, done);
}


module.exports.editRiskComplex = function(nightmare, done) {
	nightmare
	.click( '.risk-row.edit .cotation-container .action' )

	for( var key in riskData["editRiskComplexCotation"]["cotationLevel"] ) {
		nightmare.click( '.popup.popup-evaluation.active .table-evaluation td[data-slug="' + riskData["editRiskComplexCotation"]["cotationLevel"][key] + '"]' );
	}

	nightmare.click( '.popup.popup-evaluation.active .button.green' )
	.wait(function() {
		if (window.currentResponse['gettedScale']) {
			return true;
		}
	})
	.evaluate(() =>{
		delete window.currentResponse['gettedScale'];
	})
	.wait(100)
	.click( '.risk-row.edit .action .action-input' )
	.wait(function() {
		if (window.currentResponse['savedRiskSuccess']) {
			return true;
		}
	})
	.evaluate(() => {
		var response = window.currentResponse['savedRiskSuccess'];
		delete window.currentResponse['savedRiskSuccess'];

		var success = true;
		var errors = [];

		if ( ! document.body.contains( document.querySelector( '.risk-row[data-id="' + response.data.risk.id + '"] .cotation-container .action.level' + window.riskData["editRiskComplexCotation"]["cotationLevelValue"] ) ) ) {
			errors.push( 'risk.cotation level is not equal ' + window.riskData["editRiskComplexCotation"]["cotationLevelValue"]  );
		}

		if ( ! document.body.contains( document.querySelector( '.risk-row[data-id="' + response.data.risk.id + '"] .categorie-container .action .tooltip[aria-label="' + window.riskData["editRiskComplexCotation"]["categoryRiskAriaLabel"] + '"]' ) ) ) {
			errors.push( 'risk.categoryRisk is not equal ' + window.riskData["editRiskComplexCotation"]["categoryRiskAriaLabel"]  );
		}

		response.data.errors = errors;

		if ( response.data.errors.length ) {
			response.success = false;
		}

		return response;
	})
	.then((response) => {
		expect(response.data.callback_success).to.equal('savedRiskSuccess');
		expect(response.success).to.equal(true);
	})
	.then(done, done);
}

module.exports.deleteRisk = function(nightmare, done) {
	nightmare
		.click( '.risk-row.method-evarisk-simplified .action-delete' )
		.wait(function() {
			if (window.currentResponse['deletedRiskSuccess']) {
				return true;
			}
		})
		.evaluate(() => {
			var response = window.currentResponse['deletedRiskSuccess'];
			delete window.currentResponse['deletedRiskSuccess'];

			var success = true;
			var errors = [];

			if ( document.body.contains( document.querySelector( '.risk.row[data-id="' + response.data.risk.id + '"]' ) ) ) {
				errors.push( 'risk id' + response.data.risk.id + ' is not deleted' );
			}

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			return response;
		})
		.then((response) => {
			expect(response.data.callback_success).to.equal('deletedRiskSuccess');
			expect(response.data.risk.status).to.equal('trash');
			expect(response.success).to.equal(true);
		})
		.then(done, done);
}

module.exports.addComment = function(nightmare, done) {
	nightmare
		.type( '.risk-row.edit .new.comment textarea', 'dzadzadzad' )
		.click( '.risk-row.edit .new.comment .action-input' )
		.wait(function() {
			if (window.currentResponse['saved_comment_success']) {
				return true;
			}
		})
		.evaluate(() => {
			var response = window.currentResponse['saved_comment_success'];
			delete window.currentResponse['saved_comment_success'];

			var success = true;
			var errors = [];

			var comment = document.querySelector( '.risk-row.edit .comment-container textarea[name="list_comment[' + response.data.object.id + '][content]"]' );

			if ( window.riskData.addComment === comment.value ) {
				errors.push( 'comment.value: ' + comment.value + ' is not equal ' + window.riskData.addComment );
			}

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			return response;
		})
		.then((response) => {
			expect(response.data.callback_success).to.equal('saved_comment_success');
			expect(response.success).to.equal(true);
		})
		.then(done, done);
}

module.exports.deleteComment = function(nightmare, done) {
	nightmare
		.click( '.risk-row.edit .comment .action-delete' )
		.wait(function() {
			if (window.currentResponse['delete_success']) {
				return true;
			}
		})
		.evaluate(() => {
			var response = window.currentResponse['delete_success'];
			delete window.currentResponse['delete_success'];

			var success = true;
			var errors = [];
			if ( '' !== document.querySelector( '.risk-row.edit .comment-container textarea[name="list_comment[' + response.data.object.id + '][content]"]' ).style.display ) {
				errors.push( 'risk comment id' + response.data.object.id + ' is not deleted' );
			}

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			return response;
		})
		.then((response) => {
			expect(response.data.callback_success).to.equal('delete_success');
			expect(response.success).to.equal(true);
		})
		.then(done, done);
}
