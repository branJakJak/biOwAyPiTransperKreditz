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
		$scope.continueConstantRefresh = true;
		$scope.tempCounterDataUpdateReport = 1;
		$scope.currentRefreshPromise = null;
		
		$scope.$watch('activateAllAccounts',function(newVal, oldVal){
		  	if (newVal) {
		  		currentController.activateAllAccountsFunc();
		  	}
		});
		$scope.$watch('deactivateAllAccounts',function(newVal, oldVal){
		  	if (newVal) {
		  		/* get all sip accounts */
		  		currentController.deactivateAllAccountsFunc();
		  	}
		});
		this.activateAllAccountsFunc = function(){
			angular.forEach($scope.sipAccounts, function(curData, index){
				curData.status = "ACTIVE";
			});
		}

		this.deactivateAllAccountsFunc = function(){
			angular.forEach($scope.sipAccounts, function(curData, index){
				curData.status = "INACTIVE";
			});
		}
		/**
		 * Gets appropriate clas
		 * @return string            The class name
		 */
		this.getRowClass = function(currentRow){
			classNameContainer = "activateAccount";
			if (currentRow.status === "INACTIVE") {
				classNameContainer = "blockedAccount";
			}
			return classNameContainer;
		}
		this.constantDataRefresh = function(){
			$scope.currentRefreshPromise = $timeout(function(){
				/*get fresh balance data*/
				$http.get("/sipAccount/sipData").then(function(response){
					/* iterate through data and set teh fresh data to sipAccounts*/
					angular.forEach(response.data, function(freshData, index){
						angular.forEach($scope.sipAccounts, function(oldData, index){
							if (  freshData.vici_user === oldData.vici_user  ) {
								//oldData.status = freshData.status;
								oldData.balance = freshData.balance;
								oldData.exact_balance = freshData.exact_balance;
							}
						});
					});
					$scope.globalUpdateText = "Global Update";
				}, function(response){
					alertify.error("We met some problems while retrieving the data");
					$scope.globalUpdateText = "Global Update";
				}).then(function(){
					if ($scope.continueConstantRefresh) {
						currentController.constantDataRefresh();
					}
				}, function(){
					//when something went wrong
				});
			}, 5000);
		}


		this.syncWithRemoteApi = function(mainSipAccount){
			return $http.post("/sipAccount/syncApi",{'mainSipAccount':mainSipAccount});
		}
		
		this.globalUpdate = function(){
			if ($scope.currentRefreshPromise) {
				$timeout.cancel($scope.currentRefreshPromise);
				$scope.continueConstantRefresh = false;
			}
			
			$scope.globalUpdateText = "Updating data...";
			alertify.success("<p>Updating data, </p>Please wait while we refresh the data.");
			defer  = $q.defer();
			updateStack  = [];
			angular.forEach($scope.sipAccounts, function(curData, index){
				curPromise = null;
				if (curData.status === "ACTIVE") {
					curPromise = $http.get("/subSipAccount/ajaxActivate?vicidial_identification="+curData.vici_user);
				}else{
					curPromise = $http.get("/subSipAccount/ajaxDeactivate?vicidial_identification="+curData.vici_user);
				}
				curPromise.then(function(){
 					defer.resolve();
				}, function(){});
				updateStack.push(curPromise);
			});

			 $q.all(updateStack).then(function(){
			 	alertify.success("Success : Accounts updated");
			 	alertify.success("Please wait while we refresh the data.");
			 	
			 	$scope.globalUpdateText = "Updating data...";
				currentController.synchronizeData().then(function(){
					
					$scope.continueConstantRefresh = true;
					currentController.constantDataRefresh();

					alertify.success("Success : All the data are now refreshed.");
				}, function(){
					alertify.error("Something went wrong while refreshing the data.");
				});
			 }, function(){
			 	alertify.success("Something went wrong while refreshing the data");
			 });
			
		}
		this.topUpCredits = function(value,freeVoipUsername,mainUsername , mainPassword , subUsername , subPassword, credits){
			value.topUpText = "Loading..";
			
			alertify.success("Updating credits..Please wait..");
			$scope.continueConstantRefresh = false;
			/*top up account main SIP account using freeVoipUsername*/
			currentController
			.topUpMainSip(freeVoipUsername,mainUsername,mainPassword,credits)
			.then(function(response){
				if (response.data.success) {
					/*top up sub sip account using main sip account*/
					currentController.topUpSubSip(mainUsername,mainPassword,subUsername,subPassword,credits)
					.then(function(response){

						if (response.data.success) {
							value.topUpText = "Syncing..";
							alertify.success("Please wait while we synchronize the data from the API");
							/*@TODO - sync using /sipData instead*/
							$scope.globalUpdateText = "Updating data...";
							currentController
								.synchronizeData()
								.then(function(){
									$scope.continueConstantRefresh = true;
									value.topUpText = "Done";
									alertify.success("SUCCESS : Main SIP account and sub SIP account are up-to-date")
								}, function(){
									alertify.success("We met some error while synchronizing the data to the database");
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
					if (currentRow.status === "ACTIVE") {
						currentRow.status = "blocked";
					}else{
						currentRow.status = "active";
					}
				}
			);
		}
		this.updateCurrentRowInfo = function(currentRow){
			/*check subsip account id*/
			$scope.continueConstantRefresh = false;
			activateUrlTarget = "/subSipAccount/ajaxActivate?vicidial_identification="+currentRow.vici_user;
			deActivateUrlTarget = "/subSipAccount/ajaxDeactivate?vicidial_identification="+currentRow.vici_user;
			/*check status*/
			if (currentRow.status === "ACTIVE") {
				return $http.get(activateUrlTarget).then(function(){
					$scope.continueConstantRefresh = true;
					$scope.globalUpdateText = "Updating data...";
					currentController.synchronizeData();
				}, function(){

				});
			}else{
				return $http.get(deActivateUrlTarget).then(function(){
					$scope.continueConstantRefresh = true;
					$scope.globalUpdateText = "Updating data...";
					currentController.synchronizeData();
				}, function(){

				});
			}

		}
		this.topUpMainSip = function topUpMainSip(freeVoipUsername,mainUsername,mainPassword,credits){
			return $http.post('/topUp/mainSip',  {
				'freeVoipUsername' : freeVoipUsername,
				'mainUsername' : mainUsername,
				'mainPassword' : mainPassword,
				'credits' : credits,
			});
		}
		this.topUpSubSip = function(mainUsername,mainPassword,subUsername,subPassword,credits){
			return $http.post('/topUp/subSip',  {
				'mainUsername' : mainUsername,
				'mainPassword' : mainPassword,
			 	'subUsername' : subUsername,
			 	'subPassword' : subPassword,
			 	'credits' : credits,
			})
		}
		/**
		 * Updates the data value
		 */
		this.synchronizeData = function(){
			
			defer  = $q.defer();
			updateStack  = [];
			
			promise1 =  $http.get("/freeVoipAccounts/getList")
			.then(function(response){
				$scope.freeVoipAccts = response.data;
			}, function(){
				alertify.error('We met some problems while retrieving the list of FreeVoip Accounts');
				$scope.globalUpdateText = "Global Update";
			});
			updateStack.push(promise1);

			promise2 = $http.get("/sipAccount/sipData").then(function(response){
				$scope.sipAccounts = response.data;
				$scope.globalUpdateText = "Global Update";
			}, function(response){
				alertify.error("We met some problems while retrieving the data");
				$scope.globalUpdateText = "Global Update";
			});
			updateStack.push(promise2);

			return $q.all(updateStack).then(function(){
				
			}, function(){
				alertify.error('We met some problems while setting the value of SIP Data');
				$scope.globalUpdateText = "Global Update";
			});
		}
		/*initialize data*/
		$scope.globalUpdateText = "Loading data...";
		this.synchronizeData();
		this.constantDataRefresh();
	}])
})();

