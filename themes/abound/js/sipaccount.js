/**
* sipAccountModule Module
*
* The Sip account module for table organization
*/
(function(){
	sipAccountModule = angular.module('sipAccountModule', []);
	sipAccountModule.controller('IndexCtrl', ['$scope','$http','$q','$timeout', function ($scope,$http,$q,$timeout) {
		var currentController = this;
		$scope.sipAccounts = [];
		$scope.freeVoipAccts = [];
		$scope.activateAllAccounts = false;
		$scope.globalUpdateText = 'Global Update';

		
		$scope.$watch('activateAllAccounts',function(newVal, oldVal){
		  	if (newVal) {
		  		currentController.activateAllAccountsFunc();
		  	}
		});

		this.constantDataRefresh = function(){
			$timeout(function(){
				/*get fresh balance data*/
				$http.get("/sipAccount/sipData").then(function(response){
					/* iterate through data and set teh fresh data to sipAccounts*/
					angular.forEach(response.data, function(freshData, index){
						angular.forEach($scope.sipAccounts, function(oldData, index){
							if (  freshData.parent_sip_id === oldData.parent_sip_id  ) {
								oldData.account_status = freshData.account_status;
								oldData.subSipAccounts[0].balance = freshData.subSipAccounts[0].balance;
								oldData.subSipAccounts[0].exact_balance = freshData.subSipAccounts[0].balance;
							}
						});
					});
					$scope.globalUpdateText = "Global Update";
				}, function(response){
					alertify.error("We met some problems while retrieving the data");
					$scope.globalUpdateText = "Global Update";
				}).then(function(){
					currentController.constantDataRefresh();
				}, function(){
					//when something went wrong
				});
			}, 5000);
		}


		this.syncWithRemoteApi = function(mainSipAccount){
			return $http.post("/sipAccount/syncApi",{'mainSipAccount':mainSipAccount});
		}
		this.activateAllAccountsFunc = function(){
			angular.forEach($scope.sipAccounts, function(curData, index){
				curData.account_status = "active";
			});
		}
		this.globalUpdate = function(){
			defer  = $q.defer();
			updateStack  = [];
			angular.forEach($scope.sipAccounts, function(curData, index){
				curPromise = null;
				if (curData.account_status === "active") {
					curPromise = $http.get("/subSipAccount/ajaxActivate?subAccount="+curData.subSipAccounts[0].sub_sip_id);
				}else{
					curPromise = $http.get("/subSipAccount/ajaxDeactivate?subAccount="+curData.subSipAccounts[0].sub_sip_id);
				}
				curPromise.then(function(){
 					defer.resolve();
				}, function(){});
				updateStack.push(curPromise);
			});

			 $q.all(updateStack).then(function(){
			 	alertify.success("Success : Accounts updated");
			 	alertify.success("Please wait while we refresh the data.");
				currentController.synchronizeData().then(function(){
					alertify.success("Success : All the data are now refreshed.");
				}, function(){
					alertify.error("Something went wrong while refreshing the data.");
				});
			 }, function(){
			 	alertify.success("Something went wrong while refreshing the data");
			 });
			
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
			alertify.confirm(
				"Activate account", 
				"Are you sure you want to activate this account ?", 
				function(){
					alertify.success("Updating current data.Please wait.");
					currentController.updateCurrentRowInfo(currentRow)
					.then(function(){
						alertify.success("Success : Current data updated.");
					}, function(){
						alertify.error("We cant seem to update this data . Please try again later.");
					});
				},
				function(){
					if (currentRow.account_status === "active") {
						currentRow.account_status = "blocked";
					}else{
						currentRow.account_status = "active";
					}
				}
			);
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
		this.constantDataRefresh();
	}])
})();

