<?php

class ActiveMonitorController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', 
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index','monitor','clear'),
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}
	public function actionIndex()
	{
		$form = new ActiveMonitorForm();
		$datasources = $this->loadDataSources();
		$allSipAccounts = array();
		$tempContainer = RemoteDataCache::model()->findAll();
        $chartInitialData = $datasources['iniChartData'];
        $sipAccountTempContainer = $datasources['sipAccountStr'];
		$seriesDataStr = json_encode($datasources['chartSeriesData']);
		$chartLabels = json_encode($sipAccountTempContainer);
        $sipAccountTempContainer = $datasources['sipAccountStr'];
        //append the current campaign 
        foreach ($sipAccountTempContainer as $key => $currentAccount) {
            $campaignInformationRetriever = Yii::app()->campaignInformationRetriever;
            $sipAccountTempContainer[$key] = ($key + 1) ." - ".$campaignInformationRetriever->getInformation($currentAccount) . " - ".$sipAccountTempContainer[$key];
        }
        $chartLabels = json_encode($sipAccountTempContainer);

        foreach ($tempContainer as $key => $currentRemoteDataCache) {
            $allSipAccounts[] = $currentRemoteDataCache->sub_user;
        }
		if (isset($_POST['ActiveMonitorForm'])) {
			$form->attributes = $_POST['ActiveMonitorForm'];
			if ($form->validate()) {
				Yii::app()->request->cookies['monitoredAccounts'] = new CHttpCookie("monitoredAccounts" , $form->accountsMonitor );
				$this->redirect(array('/activeMonitor/monitor'));
			}
		}
		$this->render('index',compact('form','allSipAccounts','seriesDataStr','chartLabels'));
	}
    public function loadDataSources()
    {
        $chartInitialData = array();
        $sipAccountNames = array();
        $chartSeriesData = array();
        $criteria = new CDbCriteria;
        $criteria->order = "vici_user ASC";

        $allRemoteModels = RemoteDataCache::model()->findAll($criteria);
        foreach ($allRemoteModels as $key => $currentRemoteData) {
            $tempColorContainer = "red";
            //collect sip accounts
            $sipAccountNames[$key] = $currentRemoteData->sub_user;
            //register chart data array
            $chartInitialData = array(
                "name"=>$currentRemoteData->sub_user,
                "data"=>$currentRemoteData->exact_balance,
            );
            if(doubleval($currentRemoteData->exact_balance)  >= 5){
                $tempColorContainer = "#7CB5EC";
            }else{
                if ($currentRemoteData->exact_balance > 3) {
                    $tempColorContainer = "orange";
                }
            }
            //register series data
            $chartSeriesData[$key] = array(
                "y"=>doubleval($currentRemoteData->exact_balance),
                "color"=>$tempColorContainer,
            );
        }
        return array(
                'iniChartData'=>$chartInitialData,
                'sipAccountStr'=>$sipAccountNames,
                'chartSeriesData'=>$chartSeriesData,
            );
    }

	public function actionMonitor()
	{
		//check if cookie is present , 
		if (isset(Yii::app()->request->cookies['monitoredAccounts'])) {
			$accountsToMonitorStr = Yii::app()->request->cookies['monitoredAccounts']->value;
			$accountsToMonitorArr = explode(",", $accountsToMonitorStr);
			$criteria = new CDbCriteria;
			$criteria->addInCondition('sub_user' , $accountsToMonitorArr);
			$accountsToMonitor = RemoteDataCache::model()->findAll($criteria);
			$this->render('monitor',compact('accountsToMonitor'));
		}else{
			$this->redirect(array('/activeMonitor/index'));
		}
	}
	
	public function actionClear()
	{
		unset(Yii::app()->request->cookies['monitoredAccounts']);
		$this->redirect(array('/activeMonitor/index'));
	}
}