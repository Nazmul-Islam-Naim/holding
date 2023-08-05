$(function () {
    stockProductAjaxRequest();
});


/**
 * Load stock chart.
 */
// function stockProductAjaxRequest() {
//     var urlPath = null;
//     if (location.hostname === "localhost" || location.hostname === "127.0.0.1") {
//         var urlPath = 'http://' + window.location.host + '/product/stock-product-chart';
//     } else {
//         var urlPath = 'https://' + window.location.hostname + '/product/stock-product-chart';
//     }

//     $.ajax({
//         url: urlPath,
//         type: 'GET',
//         dataType: 'json',
//         success: function (response) {
//             stockProduct(response);
//         },
//         error: function (errors) {
//             console.log(errors)
//         }
//     });

// }
// function stockProduct(response) {
// 	var options = {
// 		chart: {
// 			width: 400,
// 			type: 'pie',
// 		},
// 		labels: ['Stock Out', 'Stock Low', 'Stock Ok'],
// 		series: [response.out, response.low, response.ok],
// 		responsive: [{
// 			breakpoint: 480,
// 			options: {
// 				chart: {
// 					width: 200
// 				},
// 				legend: {
// 					position: 'bottom'
// 				}
// 			}
// 		}],
// 		stroke: {
// 			width: 0,
// 		},
// 		colors: ['#FF0000', '#FFFF00', '#23AC1F'],
// 	}
// 	var chart = new ApexCharts(
// 		document.querySelector("#basic-pie-graph"),
// 		options
// 	);
// 	chart.render();
// }