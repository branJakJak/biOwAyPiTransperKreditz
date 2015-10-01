
/**
* angular chart` Module
*
* Description
*/
var angularChart = angular.module('angularChart', ['chart.js']);
angularChart.controller('IndexCtrl', ['$scope','$http', function($scope,$http){

	$scope.labels = ['2006', '2007', '2008', '2009', '2010', '2011', '2012'];
	$scope.series = ['Series A', 'Series B'];

	$scope.data = [
	    [65, 59, 80, 81, 56, 55, 40, 40, 40, 40, 40, 40],
	  ];

	this.retrieveReportData = function(){
		
	}
	
}])