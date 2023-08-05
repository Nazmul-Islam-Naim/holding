/**
 * map.
 */
function stockProductAjaxRequest() {
    var urlPath = null;
    if (location.hostname === "localhost" || location.hostname === "127.0.0.1") {
        var urlPath = 'http://' + window.location.host + '/customer/get-lat-long';
    } else {
        var urlPath = 'https://' + window.location.hostname + '/customer/get-lat-long';
    }

    $.ajax({
        url: urlPath,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            stockProduct(response);
        },
        error: function (errors) {
            console.log(errors)
        }
    });

}
function stockProduct(response) {
	console.log(response);
	var latlong;
	$.each(response, function (key, value) { 
		latlong = {latLng: [value.lat, value.long]}
		});
	$('#world-map-markers').vectorMap({
		map: 'world_mill_en',
		normalizeFunction: 'polynomial',
		hoverOpacity: 0.7,
		hoverColor: false,
		zoomOnScroll: false,
		markerStyle: {
			initial: {
				fill: '#333333',
				stroke: '#FFFFFF',
				r: 6
			}
		},
		zoomMin: 1,
		hoverColor: true,
		series: {
			regions: [{
				values: gdpData,
				scale: ['#17995e'],
				normalizeFunction: 'polynomial'
			}]
		},
		backgroundColor: 'transparent',
		markers: [ latlong
		]
	});
}