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
		$allSipAccounts = array();
		$tempContainer = RemoteDataCache::model()->findAll();
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
		$this->render('index',compact('form','allSipAccounts'));
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