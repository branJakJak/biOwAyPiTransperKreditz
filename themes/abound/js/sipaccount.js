/**
* sipAccountModule Module
*
* The Sip account module for table organization
*/
(function(){
	sipAccountModule = angular.module('sipAccountModule', ['ngCookies']);
	sipAccountModule.controller('IndexCtrl', ['$scope','$http','$q','$timeout','$cookies', function ($scope,$http,$q,$timeout,$cookies) {
		var currentController = this;
		$scope.sipAccounts = [];
		$scope.freeVoipAccts = [];
		
		$scope.activateAllAccounts = false;
		$scope.globalUpdateText = 'Global Update';
		$scope.continueConstantRefresh = true;
		$scope.tempCounterDataUpdateReport = 1;
		$scope.currentRefreshPromise = null;
		$scope.topUpCompletedCount = 0;

		$scope.updateDataReport = "";
		
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
		this.deactivateCurrentAccount = function(currAccount){
			return $http.get("/subSipAccount/ajaxDeactivate?vicidial_identification="+currAccount.vici_user);
			// .then(function(){
			// 	$scope.continueConstantRefresh = true;
			// 	$scope.globalUpdateText = "Updating data...";
			// 	currentController.synchronizeData();
			// }, function(){
			// });
		}
		this.activateCurrentAccount = function(currAccount){
			return $http.get("/subSipAccount/ajaxActivate?vicidial_identification="+currAccount.vici_user)
			// .then(function(){
			// 	$scope.continueConstantRefresh = true;
			// 	$scope.globalUpdateText = "Updating data...";
			// 	currentController.synchronizeData();
			// }, function(){
			// });
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
		this.updateCampaignName = function(currentRow){
			currentRow.showEditCampaign = false;
			currentRow.showEditCampaignLoadingImg = true;
			return $http.post(
				"/sipAccount/updateCampaignName",
				currentRow
			)
			.then(function(response){
				if (response.data.success) {
					alertify.success(response.data.message + "<strong>"+currentRow.sub_user+"</strong>");
				}else{
					alertify.error(response.data.message);
				}
				currentRow.showEditCampaignLoadingImg = false;
			}, function(){
				alertify.error("Something went wrong while updating campaign name of " + currentRow.sub_user);
				currentRow.showEditCampaignLoadingImg = false;
			})
		}
		this.topUpAll = function(freeVoipUser,creditsToTopUp){
			defer  = $q.defer();
			topUpAllStack  = [];

			freeVoipUser = freeVoipUser.username;
			angular.forEach($scope.sipAccounts, function(curData, index){
				updateCreditPromise = currentController
					.topUpMainSip(freeVoipUser,curData.main_pass,curData.main_user,creditsToTopUp)
					.then(function(){
						currentController
							.topUpSubSip(curData.main_user,curData.main_user,curData.sub_user,curData.sub_pass,creditsToTopUp)
							.then(function(){
								$scope.topUpCompletedCount += 1;
								console.log(curData.main_user + "Topped up .");
								defer.resolve();
							}, function(){
								alertify.error("We met some problems while retrieving the topping up the sub-SIP account");
							})
					}, function(){
						alertify.error("We met some problems while retrieving the topping up the main SIP account");
					})
					.then(function(){
						alertify.success("<strong>Success : </strong>Top-up complete. "+curData.sub_user);
					});
				topUpAllStack.push(updateCreditPromise);
			});
			$q.all(topUpAllStack)
			.then(function(){
				$scope.topUpCompletedCount = 0;
				alertify.success("<strong>Success : </strong>All Accounts are credited.Please wait while we refresh the data.");
			}, function(){
			});



		}
		this.constantDataRefresh = function(){
			$scope.currentRefreshPromise = $timeout(function(){
				/*get fresh balance data*/
				$http.get("/sipAccount/sipData").then(function(response){
					if ($scope.continueConstantRefresh) {
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
					}
				}, function(response){
					if ($scope.continueConstantRefresh) {
						alertify.error("We met some problems while retrieving the data");
						$scope.globalUpdateText = "Global Update";
					}

				})
				.then(function(){
					if ($scope.continueConstantRefresh) {
						currentController.constantDataRefresh();
					}
				}, function(){
					//when something went wrong
				})
				.then(function(){

					$http.get("/sipAccount/getBarChartReportData")
					.then(function(response){
						console.log('chart data updating');
						defer.resolve();
						window.updateChartData(response.data);//update chart data
					}, function(){
					});
				}, function(){
				})
				.then(function(){

					currentController.checkCreditStatus();

				}, function(){

				});
			}, 5000);
		}

		this.checkCreditStatus = function(){
			willRing = false;
			/*Check if credits is below 3 , if below 3 , deactivate */
			angular.forEach($scope.sipAccounts, function(value, key) {
				if (value.balance < 3) {
					value.status = "INACTIVE";
					currentController.deactivateCurrentAccount(value);
					console.log('notifying user');
				}
				if (value.balance < 10) {
					currentBalance = value.balance;
					lastBalance = null;
					if ($cookies.get(value.sub_user)) {
						lastBalance = parseFloat($cookies.get(value.sub_user));
					}
					
					console.log('current balance is '+currentBalance+' last balance is '+lastBalance);
					if (  currentBalance < 10 && (lastBalance == null)  ) {

						// currentController.notifyAccount(value);
						willRing = true;
						console.log('notifying user');

					}else if (
							lastBalance != null &&
							currentBalance != lastBalance &&
							( lastBalance > 10 &&  currentBalance < 10)
						) {
						// currentController.notifyAccount(value);
						willRing = true;
						console.log('notifying user');
					}
					/*write the last balance checked - to cookie*/
				}


				if (willRing) {
					currentController.notifyAccount(value);
				}

				$cookies.put(value.sub_user, value.balance);
			});/*end of foreach*/

			
		}

		this.alertUserStatusChange = function(){
			alertify.alert("Update Status","<strong>Please click the \"Global Update\" for the changes to take effect.</strong>")
		}

		this.syncWithRemoteApi = function(mainSipAccount){
			return $http.post("/sipAccount/syncApi",{'mainSipAccount':mainSipAccount});
		}
		
		this.globalUpdate = function(){
			$timeout.cancel($scope.currentRefreshPromise);
			
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
 					$scope.updateDataReport = "( "+$scope.tempCounterDataUpdateReport+"/"+$scope.sipAccounts.length+" )"
 					$scope.tempCounterDataUpdateReport += 1;
				}, function(){});
				updateStack.push(curPromise);
			});

			 $q.all(updateStack).then(function(){
			 	alertify.success("Success : Accounts updated");
			 	alertify.success("Please wait while we refresh the data.");
			 	$scope.updateDataReport = "Finalizing";
			 	$scope.globalUpdateText = "Global Update";
				currentController.synchronizeData().then(function(){

					$scope.updateDataReport = "";
					$scope.tempCounterDataUpdateReport = 1;
					
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
			defer  = $q.defer();
			alertify.success("Updating credits..Please wait..");
			$scope.continueConstantRefresh = false;

			updateStack  = [];

			
			/*top up account main SIP account using freeVoipUsername*/
			topUpMainAccountPromise = currentController.topUpMainSip(freeVoipUsername,mainUsername,mainPassword,credits)
			.then(function(response){
				defer.resolve();
				console.log('main SIP Account updated');
			}, function(){
				alertify.error("Failed : We met some problems while toping up the main SIP account.Try again later.");
			});
			updateStack.push(topUpMainAccountPromise);

			/*top up sub sip account using main sip account*/
			topUpSubAccountPromise = currentController.topUpSubSip(mainUsername,mainPassword,subUsername,subPassword,credits)
			.then(function(response){
				defer.resolve();
				value.topUpText = "Syncing..";
				alertify.success("Please wait while we synchronize the data from the API");
				/*@TODO - sync using /sipData instead*/
				$scope.globalUpdateText = "Updating data...";
				currentController
					.synchronizeData()
					.then(function(){
						$scope.continueConstantRefresh = true;
						value.topUpText = "Done";
						alertify.success("SUCCESS : The records are updated")
					}, function(){
						alertify.success("We met some error while synchronizing the data to the database");
				});
			}, function(){
				alertify.error("Failed : We met some problems while toping up the sub-SIP account.Try again later.");
			});

			updateStack.push(topUpSubAccountPromise);

			return $q.all(updateStack);

		}
		this.updateSingleRow = function(currentRow){
			currentController.updateCurrentRowInfo(currentRow);
		}
		this.notifyAccount = function(value){
			return $http.post("/sipAccount/notifyAccount");
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
		this.topUpMainSip = function(freeVoipUsername,mainUsername,mainPassword,credits){
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
				defer.resolve();
				$scope.freeVoipAccts = response.data;
			}, function(){
				alertify.error('We met some problems while retrieving the list of FreeVoip Accounts');
				$scope.globalUpdateText = "Global Update";
			});
			updateStack.push(promise1);

			promise2 = $http.get("/sipAccount/sipData")
			.then(function(response){
				defer.resolve();
				$scope.sipAccounts = response.data;
				$scope.globalUpdateText = "Global Update";
			}, function(response){
				alertify.error("We met some problems while retrieving the data");
				$scope.globalUpdateText = "Global Update";
			})
			.then(function(response){
				defer.resolve();

				currentController.checkCreditStatus();
		
			}, function(){

			});

			updateStack.push(promise2);


			updateChartPromise = $http.get("/sipAccount/getBarChartReportData")
			.then(function(response){
				console.log('chart data updating');
				defer.resolve();
				window.updateChartData(response.data);//update chart data
			}, function(){
			});

			updateStack.push(updateChartPromise);

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

