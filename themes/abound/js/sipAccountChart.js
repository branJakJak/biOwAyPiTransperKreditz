window.updateChartData = function(data) {
	window.chartObj.series[0].setData(data,true);
	jQuery.each(window.chartObj.series[0].data, function(index, val) {
	  val.setState('hover');
	  val.setState();
	});


	// jQuery.ajax({
	//   url: '/sipAccount/getBarChartReportData',
	//   type: 'GET',
	//   dataType: 'json',
	//   success: function(data, textStatus, xhr) {
	//   	window.chartObj.series[0].setData(data,true);
	//   },
	// });
	
}