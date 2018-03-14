var expect     = require('chai').expect;
var fs         = require("fs");

var riskPageData = fs.readFileSync("./test/module/risk-page/data/risk-page.json");
var riskPageData = JSON.parse(riskPageData);


module.exports = function(nightmare, cb) {
	describe('Risk Page', function() {
		it('goTo', function(done) {
			goToRiskPage(nightmare, done);
		});

		it('editRisksSimple', function(done) {
			editRisksSimplePage(nightmare, done);
			cb();
		})
	});
};

function goToRiskPage(nightmare, done) {
	nightmare
		.goto('http://127.0.0.1/wordpress/wp-admin/admin.php?page=digirisk-handle-risk')
		.wait('.risk-page .wp-digi-pagination')
		.wait(2000)
		.evaluate(function() {
			return;
		})
		.then(done, done);
}

function editRisksSimplePage(nightmare, done) {
	var x = 0;
	for ( var key in riskPageData.editRisks.simple ) {
		x++;
		nightmare
		.wait(2000)
		.click( '.table.risk tr:nth-child(' + x + ').risk-row.edit.method-evarisk-simplified .cotation-container' )
		.click( '.table.risk tr:nth-child(' + x + ').risk-row.edit.method-evarisk-simplified .content.active li[data-level="' + riskPageData.editRisks.simple[key]["cotationLevel"] + '"]' )
		.click( '.table.risk tr:nth-child(' + x + ').risk-row.edit.method-evarisk-simplified .action-input' )
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

			if ( ! document.body.contains( document.querySelector( '.risk-row[data-id="' + response.data.risk.id + '"] .cotation-container .action.level' + window.riskPageData.editRisks.simple[window.allRiskSimpleResponse.length]["cotationLevel"] ) ) ) {
				errors.push( 'risk.cotation level is not equal ' + window.riskPageData.editRisks.simple[window.allRiskSimpleResponse.length]["cotationLevel"]  );
			}

			response.data.errors = errors;

			if ( response.data.errors.length ) {
				response.success = false;
			}

			window.allRiskPageSimpleResponse.push( response );
			return window.allRiskPageSimpleResponse;
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
