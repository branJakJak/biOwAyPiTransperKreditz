/**
* sipAccountModule Module
*
* The Sip account module for table organization
*/
(function(){
	sipAccountModule = angular.module('sipAccountModule', []);
	sipAccountModule.controller('IndexCtrl', ['$scope','$http', function ($scope,$http) {
		var currentController = this;
		$scope.sipAccounts = [];
		$scope.freeVoipAccts = [];
		$scope.activateAllAccounts = false;
		$scope.globalUpdateText = 'Global Update';

		
		$scope.$watch('activateAllAccounts',function(newVal, oldVal){
		  	if (newVal) {
		  		currentController.activateAllAccountsFunc();
		  		console.log(newVal);
		  	}
		});

		this.syncWithRemoteApi = function(mainSipAccount){
			return $http.post("/sipAccount/syncApi",{'mainSipAccount':mainSipAccount});
		}
		this.activateAllAccountsFunc = function(){
			angular.forEach($scope.sipAccounts, function(curData, index){
				curData.account_status = "active";
			});
		}
		this.globalUpdate = function(){
			angular.forEach($scope.sipAccounts, function(curData, index){
				currentController.updateCurrentRowInfo(curData);
			});
			currentController.synchronizeData();
		}
		this.topUpCredits = function(freeVoipUsername,mainSipId,subSipId , credits){
			alertify.success("Updating credits..Please wait..");
			/*top up account main SIP account using freeVoipUsername*/
			currentController
			.topUpMainSip(freeVoipUsername,mainSipId,credits)
			.then(function(response){
				if (response.data.success) {
					/*top up sub sip account using main sip account*/
					currentController.topUpSubSip(mainSipId,subSipId,credits)
					.then(function(response){
						if (response.data.success) {
							alertify.success("Please wait while we synchronize the data from the API");
							/*@TODO - syncwith remote api - before synchronizing data*/
							currentController.syncWithRemoteApi(mainSipId).then(function(){
								currentController
									.synchronizeData()
									.then(function(){
										alertify.success("SUCCESS : Main SIP account and sub SIP account are up-to-date")
									}, function(){
										alertify.success("We met some error while synchronizing the data to the database");
									})
							}, function(){
								alertify.error("Something went wrong while synchronizing to the api");
							});
							
						}else{
							alertify.error("Failed : Sorry we cant update this sub account at the moment. Cause of failure : "+response.data.message);
						}
					}, function(){
						alertify.error("Failed : We met some problems while toping up the sub-SIP account.Try again later.");
					})
				}else{
					alertify.error("Failed : Sorry we cant update your this account at the moment. Cause of failure : "+response.data.message);
				}
			}, function(){
				alertify.error("Failed : We met some problems while toping up the main SIP account.Try again later.");
			})
			
			
		}
		this.updateSingleRow = function(currentRow){
			alertify.success("Updating current data.Please wait.");
			this.updateCurrentRowInfo(currentRow)
				.then(function(){
					alertify.success("Success : Current data updated.");
				}, function(){
					alertify.error("We cant seem to update this data . Please try again later.");
				});
		}
		this.updateCurrentRowInfo = function(currentRow){
			/*check subsip account id*/
			activateUrlTarget = "/subSipAccount/ajaxActivate?subAccount="+currentRow.subSipAccounts[0].sub_sip_id;
			deActivateUrlTarget = "/subSipAccount/ajaxDeactivate?subAccount="+currentRow.subSipAccounts[0].sub_sip_id;
			/*check status*/
			if (currentRow.account_status === "active") {
				return $http.get(activateUrlTarget).then(function(){
					currentController.synchronizeData();
				}, function(){

				});
			}else{
				return $http.get(deActivateUrlTarget).then(function(){
					currentController.synchronizeData();
				}, function(){

				});
			}

		}
		this.topUpMainSip = function(freeVoipUsername , mainSipId , credits){
			return $http.post('/topUp/mainSip',  {
				'freeVoipUsername' : freeVoipUsername,
				'mainSipId' : mainSipId,
				'credits' : credits,
			});
		}
		this.topUpSubSip = function(mainSipId , subSipId , credits){
			return $http.post('/topUp/subSip',  {
			 	'mainSipId' : mainSipId,
			 	'subSipId' : subSipId,
			 	'credits' : credits,
			})
		}
		/**
		 * Updates the data value
		 */
		this.synchronizeData = function(){
			$scope.globalUpdateText = "Updating data...";
			return $http.get("/freeVoipAccounts/getList")
			.then(function(response){
				$scope.freeVoipAccts = response.data;
				console.log($scope.freeVoipAccts);
				$scope.globalUpdateText = "Global Update";
			}, function(){
				alertify.error('We met some problems while retrieving the list of FreeVoip Accounts');
				$scope.globalUpdateText = "Global Update";
			})
			.then(function(){
				$http.get("/sipAccount/sipData").then(function(response){
					$scope.sipAccounts = response.data;
					$scope.globalUpdateText = "Global Update";
				}, function(response){
					alertify.error("We met some problems while retrieving the data");
					$scope.globalUpdateText = "Global Update";
				});
			}, function(){
				alertify.error('We met some problems while setting the value of SIP Data');
				$scope.globalUpdateText = "Global Update";
			});
		}
		/*initialize data*/
		this.synchronizeData();
	}])
})();

