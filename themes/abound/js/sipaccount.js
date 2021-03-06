/**
* sipAccountModule Module
*
* The Sip account module for table organization
*/
(function(){
	sipAccountModule = angular.module('sipAccountModule', ['ngCookies','angularMoment','720kb.tooltips','timer']);
	sipAccountModule.controller('IndexCtrl', ['$scope','$http','$q','$timeout','$cookies','$interval', function ($scope,$http,$q,$timeout,$cookies,$interval) {
		var currentController = this;
		$scope.sipAccounts = [];
		$scope.freeVoipAccts = [];
		/*application settings/variables*/
		$scope.APPLICATION_FIRST_RUN = true;
		
		$scope.endTimeTillNextUpdate = new Date();

		$scope.endTimeTillNextUpdate.setSeconds($scope.endTimeTillNextUpdate.getSeconds()+10);
		
		$scope.activateAllAccounts = false;
		$scope.globalUpdateText = 'Global Update';
		$scope.continueConstantRefresh = false;
		$scope.tempCounterDataUpdateReport = 1;
		$scope.currentRefreshPromise = null;
		$scope.topUpCompletedCount = 0;
		$scope.topUpSelectContainerShow = false;

		$scope.updateDataReport = "";
		$scope.topUpMessageLabel = "Top-up All";

		$scope.$watch('activateAllAccounts',function(newVal, oldVal){
		  	if (newVal) {
		  		currentController.activateAllAccountsFunc();
		  	}
		});

		$scope.customFilter = function(currentRemoteDataCache){
			isValid = false;
			var filterUser = ['krustyclown*lj2016888','Euzae6eeQu*Famenig44','Zola24','tesvonrae*raevontes'];
			//found
			if (filterUser.indexOf(currentRemoteDataCache.sub_user) !== -1 ) {
				isValid = true;
				if (currentRemoteDataCache.is_hidden == 1) {
					isValid = false;
				} else {
					isValid = true;
				}
			}
			return isValid;
		}
		$scope.mainRemoteDataCacheFilter = function(currentRemoteDataCache){
			isValid = false;

			var filterUser = ['krustyclown*lj2016888','Euzae6eeQu*Famenig44','Zola24','tesvonrae*raevontes'];
			// not found
			if (filterUser.indexOf(currentRemoteDataCache.sub_user) === -1 ) {
				isValid = true;
				if (currentRemoteDataCache.is_hidden == 1) {
					isValid = false;
				} else {
					isValid = true;
				}
			}
			return isValid;
		}

		$scope.$watch('deactivateAllAccounts',function(newVal, oldVal){
		  	if (newVal) {
		  		/* get all sip accounts */
		  		currentController.deactivateAllAccountsFunc();
		  	}
		});

        currentController.getCreditUsed = function(remoteDataCacheModel){
        	var creditUsed = 0;
        	remoteDataCacheModel.last_balance_since_topup = parseFloat(remoteDataCacheModel.last_balance_since_topup);
        	remoteDataCacheModel.exact_balance = parseFloat(remoteDataCacheModel.exact_balance);
        	remoteDataCacheModel.accumulating_credits_used = parseFloat(remoteDataCacheModel.accumulating_credits_used);

        	if ( remoteDataCacheModel.last_balance_since_topup > 0 && remoteDataCacheModel.last_balance_since_topup != null) {
        		creditUsed = ( remoteDataCacheModel.last_balance_since_topup - remoteDataCacheModel.exact_balance)  + remoteDataCacheModel.accumulating_credits_used; 
        		if ( isNaN(creditUsed) ) {
        			console.log(remoteDataCacheModel)
        		}
        	}
        	return creditUsed;
        }
        currentController.hideAccount = function(remoteDataCacheModel){
        	/*send ajax get that contains the id to hide*/
			$http({
			  method: 'GET',
			  url: '/remoteDataCache/hide?account='+remoteDataCacheModel.id
			}).then(function successCallback(response) {
				currentController.synchronizeData();
			});
        	/*refresh the accounts in the list*/
        	/*done*/
        }

		// this.activateAllAccountsFunc = function(){
		// 	angular.forEach($scope.sipAccounts, function(curData, index){
		// 		curData.is_active = "ACTIVE";
		// 	});
		// }

		// this.deactivateAllAccountsFunc = function(){
		// 	angular.forEach($scope.sipAccounts, function(curData, index){
		// 		curData.is_active = "INACTIVE";
		// 	});
		// }

		// this.deactivateCurrentAccount = function(currAccount){
		// 	return $http.get("/subSipAccount/ajaxDeactivate?vicidial_identification="+currAccount.vici_user);
		// }

		// this.activateCurrentAccount = function(currAccount){
		// 	return $http.get("/subSipAccount/ajaxActivate?vicidial_identification="+currAccount.vici_user)
		// }
		this.getTotalCreditsUsed = function(){
			tempTotalContainer = 0;
			angular.forEach($scope.sipAccounts, function(curData, index){
				if ( $.inArray(curData.main_user, ['lj2016888' , 'Famenig44' ]) == -1 ) {
					tempTotalContainer += parseFloat(currentController.getCreditUsed(curData));
				}
			});
			return tempTotalContainer;
		}
		this.getTotalBalance = function(){
			var total = 0;
			angular.forEach($scope.sipAccounts,function(currentElement,index){
				total += parseFloat(currentElement.exact_balance);
			});
			return total;
		}
		/**
		 * Gets appropriate clas
		 * @return string            The class name
		 */
		this.getRowClass = function(currentRow){
			classNameContainer = "activateAccount";
			if (currentRow.is_active === "INACTIVE") {
				classNameContainer = "blockedAccount";
			}
			if (currentRow.main_user === 'Piper.Denesik') {
				classNameContainer = "issueAccount";
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
			$scope.topUpAllStack  = [];
			$scope.topUpMessageLabel = "Loading...";
			freeVoipUser = freeVoipUser.username;
			angular.forEach($scope.sipAccounts, function(curData, index){
				if (curData.isIncluded) {
					/*topup main acct promise*/
					topUpMainPromise = currentController.topUpMainSip(freeVoipUser,curData.main_user,curData.main_pass,creditsToTopUp);
					topUpMainPromise.then(function(){}, function(){
						alertify.error("We met some problems while retrieving the topping up the main SIP account");
					});

					$scope.topUpAllStack.push(topUpMainPromise);

					/*topup sub acct promise*/
					topUpSubPromise = currentController.topUpSubSip(curData.main_user, curData.main_pass, curData.sub_user, curData.sub_pass, creditsToTopUp)
					topUpSubPromise.then(function(){
						$scope.topUpCompletedCount += 1;
						console.log(curData.main_user + "Topped up .");
						alertify.success("<strong>Success : </strong>Top-up complete. " + curData.sub_user);
					}, function(){
						alertify.error("We met some problems while retrieving the topping up the sub-SIP account : "+curData.sub_user);
						$scope.topUpCompletedCount += 1;
					});
					$scope.topUpAllStack.push(topUpSubPromise);
				}
			});

			return $q.all($scope.topUpAllStack)
			.then(function(){
			    $scope.topUpSelectContainerShow = false;
			    $scope.topUpCompletedCount = 0;
			    alertify.success("<strong>Success : </strong>All Accounts are credited.Please wait while we refresh the data.");
			    $scope.topUpMessageLabel = "Update";
			    console.log("All ajax completed");
			}, function(){
			});

		}
		this.currentshowExclusionPanel = function(){
			$scope.topUpSelectContainerShow = true;
		}
		/**
		 * Constantly refresh balance , exact balance
		 */
		this.constantDataRefresh = function(){
			$scope.currentRefreshPromise = $timeout(function(){
				/*get fresh balance data*/
				$http.get("/sipAccount/sipData").then(function(response){
					if ($scope.continueConstantRefresh) {
						/* iterate through data and set teh fresh data to sipAccounts*/
						angular.forEach(response.data, function(freshData, index){
							angular.forEach($scope.sipAccounts, function(oldData, index){
								if (  freshData.vici_user === oldData.vici_user  ) {
									oldData.balance = freshData.balance;
									oldData.exact_balance = freshData.exact_balance;
									// oldData.is_active = freshData.is_active;
									oldData.ip_address = freshData.ip_address;
									oldData.num_lines = freshData.num_lines;
									oldData.campaign = freshData.campaign;
									oldData.date_updated = freshData.date_updated;
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
					//currentController.constantDataRefresh();
				}, function(){
					//error 
				})
				.then(function(){
					currentController.checkCreditStatus();
				}, function(){

				});
			}, 20 * 1000);
		}

		this.checkCreditStatus = function(){
			willRing = false;
			/*Check if credits is below 3 , if below 3 , deactivate */
			angular.forEach($scope.sipAccounts, function(value, key) {
				if (value.balance < 3) {
					value.is_active = "INACTIVE";

					currentController.deactivateCurrentAccount(value);
					console.log('deactivating user : '+value.sub_user);
				}
				if (value.balance < 5) {
					currentBalance = value.balance;
					lastBalance = null;
					if ($cookies.get(value.sub_user)) {
						lastBalance = parseFloat($cookies.get(value.sub_user));
					}
					
					//console.log('current balance is '+currentBalance+' last balance is '+lastBalance);
					if (  currentBalance < 5 && (lastBalance == null)  ) {

						// currentController.notifyAccount(value);
						willRing = true;
						console.log('notifying user : '+value.sub_user);

					}else if (
							lastBalance != null &&
							currentBalance != lastBalance &&
							( lastBalance > 5 &&  currentBalance < 5)
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
			// $timeout.cancel($scope.currentRefreshPromise);
			$scope.globalUpdateText = "Updating data...";
			alertify.success("<p>Updating data, </p>Please wait while we refresh the data.");
			updateStack  = [];
			angular.forEach($scope.sipAccounts, function(curData, index){
				curPromise = null;
				//console.log(curData.vici_user+" "+curData.is_active);
				if (curData.is_active === "ACTIVE") {
					curPromise = $http.get("/subSipAccount/ajaxActivate?record_id="+curData.id);
				}else{
					curPromise = $http.get("/subSipAccount/ajaxDeactivate?record_id="+curData.id);
				}
				curPromise.then(function(){
 					$scope.updateDataReport = "( "+$scope.tempCounterDataUpdateReport+"/"+$scope.sipAccounts.length+" )"
 					$scope.tempCounterDataUpdateReport += 1;
				}, function(){});
				console.log("we are now at promise "+ index + " with data "+curData.vici_user)
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
					//currentController.constantDataRefresh();

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

			updateStack  = [];
			
			/*top up account main SIP account using freeVoipUsername*/
			topUpMainAccountPromise = currentController.topUpMainSip(freeVoipUsername,mainUsername,mainPassword,credits)
			.then(function(response){
				console.log('main SIP Account updated');
			}, function(){
				alertify.error("Failed : We met some problems while toping up the main SIP account.Try again later.");
			});
			updateStack.push(topUpMainAccountPromise);

			/*top up sub sip account using main sip account*/
			topUpSubAccountPromise = currentController.topUpSubSip(mainUsername,mainPassword,subUsername,subPassword,credits)
			.then(function(response){
				value.topUpText = "Syncing..";
				alertify.success("Please wait while we synchronize the data from the API");
				$scope.globalUpdateText = "Updating data...";
			}, function(){
				alertify.error("Failed : We met some problems while toping up the sub-SIP account.Try again later.");
			}).then(function(){
				value.topUpText = "Top-up";
			}, function(){
				value.topUpText = "Top-up";
			});

			updateStack.push(topUpSubAccountPromise);

			return $q.all(updateStack)
				.then(function(){
					$scope.continueConstantRefresh = false;
					alertify.success("SUCCESS : The records are updated")
					currentController.synchronizeData();
				}, function(){
					alertify.success("We met some error while synchronizing the data to the database");
				});


		}
		this.quickUpdateBalance = function(model){
			var promiseCollection = [];
			var passedModel = model;

			//syn to apI
			syncPromise  = $http.post("/sync/single",{
			        'mainUsername' : model.main_user,
			        'mainPassword' : model.main_pass,
			        'subUsername' : model.sub_user,
			        'subPassword' : model.sub_pass
			});
			promiseCollection.push(syncPromise);
			//sync to local db
			retrievePromise =  $http.post("/sipAccount/retrieveSingleData",model)
					.then(function(response){
						currentController.synchronizeData();
			        });
			promiseCollection.push(retrievePromise);
			$q.all(promiseCollection);
			
		}

		this.updateSingleRow = function(currentRow){
			currentController.updateCurrentRowInfo(currentRow);
		}
		this.updateCurrentRowInfo = function(currentRow){
			/*check subsip account id*/
			$scope.continueConstantRefresh = false;
			activateUrlTarget = "/subSipAccount/ajaxActivate?vicidial_identification="+currentRow.vici_user;
			deActivateUrlTarget = "/subSipAccount/ajaxDeactivate?vicidial_identification="+currentRow.vici_user;
			/*check status*/
			if (currentRow.is_active === "ACTIVE") {
				return $http.get(activateUrlTarget).then(function(){
					$scope.continueConstantRefresh = false;
					$scope.globalUpdateText = "Updating data...";
					currentController.synchronizeData();
				}, function(){
				});
			}else{
				return $http.get(deActivateUrlTarget).then(function(){
					$scope.continueConstantRefresh = false;
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

			topupSubSipPromise = $http.post('/topUp/subSip',  {
				'mainUsername' : mainUsername,
				'mainPassword' : mainPassword,
			 	'subUsername' : subUsername,
			 	'subPassword' : subPassword,
			 	'credits' : credits,
			})
			.then(function(){
				$http.post("/sync/single",{
					'mainUsername' : mainUsername,
					'mainPassword' : mainPassword,
			 		'subUsername' : subUsername,
			 		'subPassword' : subPassword
				});

			}, function(){
				alertify.error("We cant sync "+subUsername);
			})

			 return topupSubSipPromise;
		}


		this.notifyAccount = function(value){
			return $http.post("/sipAccount/notifyAccount");
		}
		
		this.awayFromNow = function(dateStr){
			return moment(dateStr).fromNow();
		}


		/**
		 * Updates the data value
		 */
		this.synchronizeData = function(){
			updateStack  = [];
			promise1 =  $http.get("/freeVoipAccounts/getList")
			.then(function(response){
				$scope.freeVoipAccts = response.data;
			}, function(){
				alertify.error('We met some problems while retrieving the list of FreeVoip Accounts');
				$scope.globalUpdateText = "Global Update";
			});
			updateStack.push(promise1);
			var sipDataUrl = "/sipAccount/sipData";

			promise2 = $http.get(sipDataUrl)
			.then(function(response){

				if ($scope.APPLICATION_FIRST_RUN) {
					$scope.sipAccounts = response.data;//
					$scope.APPLICATION_FIRST_RUN = false;
				}else{
					angular.forEach(response.data, function(freshData, indexFreshData){
						angular.forEach($scope.sipAccounts, function(oldData, indexOldData){
							if (freshData.id === oldData.id) {
								$scope.sipAccounts[indexOldData] = freshData;
							}
						});
					});
				}
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

		/**
		 * initialize sip data and freevoip accounts
		 */
		this.synchronizeData();


	}]);//end of IndexController

})();


