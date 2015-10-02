function updateChartData () {
	jQuery.ajax({
	  url: '/sipAccount/getBarChartReportData',
	  type: 'GET',
	  dataType: 'json',
	  success: function(data, textStatus, xhr) {
		jQuery.each(data, function(index, val) {
		  if (val.y < 10) {
		  	data[index].color =  "red";
		  }else if(val.y >= 10 && window.chartObj.series[0].data[index].color == "red"){
		  	data[index].color = "#7CB5EC";

		  }else{
		  	data[index].color = window.chartObj.series[0].data[index].color;
		  }
		});

	  	window.chartObj.series[0].setData(data,true);

		jQuery.each(window.chartObj.series[0].data, function(index, val) {
		  val.setState('hover');
		  val.setState();
		  //console.log(val);
		});
	  	
	  },
	});
	//independently update the chart
	setTimeout(updateChartData, 3 * 1000);
}