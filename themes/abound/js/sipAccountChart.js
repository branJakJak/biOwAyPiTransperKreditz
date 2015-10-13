window.chartBlink = function(){
	dataClone = window.chartObj.series[0].data;
	/*iterate data*/
	jQuery.each(window.chartObj.series[0].data, function(index, val) {
		/*if value is between 4 and 3*/
		if (val.y <= 4 && val.y >= 3 ) {
			if (val.color == "orange") {
				dataClone[index].color = "yellow";
			}else if (val.color == "yellow") {
				dataClone[index].color = "orange";
			}
		}
	});
	window.chartObj.series[0].setData(dataClone,true);
	jQuery.each(window.chartObj.series[0].data, function(index, val) {
	  val.setState('hover');
	  val.setState();
	});

}

window.updateChartData = function(data) {
	/*flush blink interval*/
	window.blinkerInterval = null;
	window.chartObj.series[0].setData(data,true);
	jQuery.each(window.chartObj.series[0].data, function(index, val) {
	  val.setState('hover');
	  val.setState();
	});
	/*start blink interval*/
	window.blinkerInterval = setInterval(window.chartBlink, 600);
}

