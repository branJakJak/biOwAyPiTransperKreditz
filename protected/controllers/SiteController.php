<?php

class SiteController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('error','login','logout','test'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','generate'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * This is the default 'index' action that is invOked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        $transactionLogMdl = new TransactionLog();
        if (isset($_POST['TransactionLog'])) {
            $transactionLogMdl->attributes = $_POST['TransactionLog'];
            if ($transactionLogMdl->save()) {
            	/*send to remote*/
            	$rmt = new RemoteTransferFund();
            	$remoteResult = $rmt->commitTransaction(
            		$transactionLogMdl->freevoipAccount->username,
            		$transactionLogMdl->freevoipAccount->password,
            		$transactionLogMdl->to_username, 
            		$transactionLogMdl->amount,
            		$transactionLogMdl->pincode
        		);
        		$newTransactionlink = CHtml::link('Transaction Log', array('transactionLog/view','id'=>$transactionLogMdl->id)); 
        		$transactionLogMdl->result_string = $remoteResult->resultstring;
        		$transactionLogMdl->result_description = $remoteResult->description;
        		$transactionLogMdl->save();
        		if ($remoteResult->resultstring == 'success') {
        			Yii::app()->user->setFlash('success', '<strong>Success!</strong> Credit transfered . '.$newTransactionlink);
        		}else if ($remoteResult->resultstring == 'failure') {
        			$reasonOfFailure = "unknown";
        			if (isset($remoteResult->description)) {
        				$reasonOfFailure = $remoteResult->description;
        			}
        			Yii::app()->user->setFlash('error', '<strong>Transaction Failed!</strong> We met some error while transferring the amount . <br>But here is your transaction log '.$newTransactionlink . ' , you can resend it later. <br>Reason of failure : '.$reasonOfFailure);
        		}
            	$this->redirect("/site/index");
            }
        }
		$voipAccountsCount = FreeVoipAccounts::model()->count();
		$transactionCount = TransactionLog::model()->count();
		$sipAccountCount = SipAccount::model()->count();
		$this->render('dashboard',compact('voipAccountsCount','transactionCount','transactionLogMdl','sipAccountCount'));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$this->redirect("/user/login");
		// $model=new LoginForm;

		// // if it is ajax validation request
		// if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		// {
		// 	echo CActiveForm::validate($model);
		// 	Yii::app()->end();
		// }

		// // collect user input data
		// if(isset($_POST['LoginForm']))
		// {
		// 	$model->attributes=$_POST['LoginForm'];
		// 	// validate user input and redirect to the previous page if valid
		// 	if($model->validate() && $model->login())
		// 		$this->redirect(Yii::app()->user->returnUrl);
		// }
		// // display the login form
		// $this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	public function actionGenerate()
	{
		$allModels = RemoteDataCache::model()->findAll();
		foreach ($allmodel as $key => $currentModel) {
			$urlStr = sprintf("https://apivoip.ml/disable/account?mainusername=%s&mainpassword=%s", $currentModel->main_user,$currentModel->main_pass);
			echo $urlStr."<br>";
		}
		die();
	}
}