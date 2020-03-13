/**
 * Initialise l'objet "statistics" ainsi que la méthode "init" obligatoire pour la bibliothèque EoxiaJS.
 *
 * @since 7.5.3
 * @version 7.5.3
 */
window.eoxiaJS.digirisk.statistics = {};

window.eoxiaJS.digirisk.statistics.init = function() {
	window.eoxiaJS.digirisk.statistics.event();
};

window.eoxiaJS.digirisk.statistics.event = function() {
	jQuery( document ).on( 'click', '.tab-list .tab-element[data-target="digi-statistic"]', window.eoxiaJS.digirisk.statistics.loadContent );
};

window.eoxiaJS.digirisk.statistics.loadContent = function() {
	setTimeout( window.eoxiaJS.digirisk.statistics.loadCharts, 100 );

};

window.eoxiaJS.digirisk.statistics.loadCharts = function () {

	let data = {
		action: 'load_data_chart',
		id: jQuery( document ).find( '.tab-element ' ).attr( 'data-id' ),
	};

	jQuery.ajax(
		{
			type: 'POST',
			url: ajaxurl,
			data: data,
			success: function( response ) {
				for ( let i = 0; i <= 4; i++ ) {
					let background_color_rgba = [];
					let border_color_rgba     = [];
					for ( let a = 0; a < response.data.chart[i].data.datasets.data.length; a++ ) {
						background_color_rgba[a] = 'rgba('
							+ response.data.chart[i].data.datasets.backgroundColor[0] + ','
							+ response.data.chart[i].data.datasets.backgroundColor[1] + ','
							+ response.data.chart[i].data.datasets.backgroundColor[2] + ','
							+ response.data.chart[i].data.datasets.backgroundColor[3] +
						')';

						border_color_rgba[a] = 'rgba('
							+ response.data.chart[i].data.datasets.borderColor[0] + ','
							+ response.data.chart[i].data.datasets.borderColor[1] + ','
							+ response.data.chart[i].data.datasets.borderColor[2] + ','
							+ response.data.chart[i].data.datasets.borderColor[3] +
						')';
					}

					let ctx = document.getElementById( 'myChart[' + i + ']' ).getContext( '2d' );
					new Chart(
						ctx,
						{
							type: response.data.chart[i].type,
							data: {
								labels: response.data.chart[i].data.labels,
								datasets: [{
									label: response.data.chart[i].data.datasets.label,
									data: response.data.chart[i].data.datasets.data,
									backgroundColor: background_color_rgba,
									borderColor: border_color_rgba,
									borderWidth: 1
								}]
							},
							options: {
								title: {
									display: response.data.chart[i].options.title.display,
									text: response.data.chart[i].options.title.text,
									fontSize: response.data.chart[i].options.title.fontSize,
								},
								barValueSpacing: response.data.chart[i].options.barValueSpacing,
								scales: {
									xAxes: [{
										stacked: false,
									}],
									yAxes: [{
										stacked: false,
										ticks: {
											beginAtZero: true
										}
									}]
								}
							}
						}
					);
				}
				// var label = [];
				// var data = [];
				// var backgroundColor = [];
				// var borderColor = [];
				//
				// var datasets = {
				// 	label: label,
				// 	data: data,
				// 	backgroundColor: backgroundColor,
				// 	borderColor: borderColor,
				// };
				//
				// for ( var b = 0; b < response.data.chart[5].data.datasets.length; b++ ) {
				// 	label[b] = response.data.chart[5].data.datasets[b].label;
				// 	data[b] = response.data.chart[5].data.datasets[b].data;
				// 	backgroundColor[b] = response.data.chart[5].data.datasets[b].backgroundColor;
				// 	borderColor[b] = response.data.chart[5].data.datasets[b].borderColor;
				// 	datasets[label] = label[b];
				// 	datasets[data] = data[b];
				// 	datasets[backgroundColor] = backgroundColor[b];
				// 	datasets[borderColor] = borderColor[b];
				// 	// datasets.push( data[b] );
				// 	// datasets.push( backgroundColor[b] );
				// 	// datasets.push( borderColor[b] );
				// }
				let ctx2 = document.getElementById('myChart[5]' ).getContext( '2d' );
				new Chart(
					ctx2,
					{
						type: response.data.chart[5].type,
						data: {
							labels: response.data.chart[5].data.labels,
							datasets: [{
								label: response.data.chart[5].data.datasets[0].label,
								data: response.data.chart[5].data.datasets[0].data,
								backgroundColor: "black",
							}, {
								label: response.data.chart[5].data.datasets[1].label,
								data: response.data.chart[5].data.datasets[1].data,
								backgroundColor: "red",
							}, {
								label: response.data.chart[5].data.datasets[2].label,
								data: response.data.chart[5].data.datasets[2].data,
								backgroundColor: "orange",
							}, {
								label: response.data.chart[5].data.datasets[3].label,
								data: response.data.chart[5].data.datasets[3].data,
								backgroundColor: "grey",
							}]
						},
						options: {
							title: {
								display: response.data.chart[5].options.title.display,
								text: response.data.chart[5].options.title.text,
								fontSize: response.data.chart[5].options.title.fontSize,
							},
							barValueSpacing: response.data.chart[5].options.barValueSpacing,
							scales: {
								xAxes: [{
									stacked: false,
								}],
								yAxes: [{
									stacked: false,
									ticks: {
										beginAtZero: true
									}
								}]
							}
						}
					}
				);
			},
		}
	);
};

/**
 * Le callback en cas de réussite à la requête Ajax "export_epi".
 * Exporte la fiche de vie d'un EPI au format ODT.
 *
 * @since 0.5.0
 * @version 0.5.0
 *
 * @param  {HTMLDivElement} triggeredElement  L'élement HTML déclenchant la requête Ajax.
 * @param  {Object}         response          Les données renvoyées par la requête Ajax.
 *
 * @return {void}
 */
window.eoxiaJS.digirisk.statistics.exportedCSVFileSuccess = function ( triggeredElement, response ) {
	console.log( response );
	var element = document.createElement('a');
	element.setAttribute('href', response.data.link );
	element.setAttribute('download', response.data.filename);

	element.style.display = 'none';
	document.body.appendChild(element);

	element.click();

	document.body.removeChild(element);
};
