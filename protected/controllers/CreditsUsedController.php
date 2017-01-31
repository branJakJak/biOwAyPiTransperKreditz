<?php

class CreditsUsedController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

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
                'actions'=>array('index','reset','resetAll'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
    public function actionReset($account)
    {
        /**
         * @var $model RemoteDataCache
         */
        $dbCriteria = new CDbCriteria();
        $dbCriteria->compare("id", $account);
        $model = RemoteDataCache::model()->find($dbCriteria);
        if ($model) {
            $model->last_balance_since_topup = $model->exact_balance;
            $model->accumulating_credits_used = 0;
            if (!$model->save()) {
                Yii::app()->user->setFlash("error",CHtml::errorSummary($model));
            } else {
                Yii::app()->user->setFlash("success", 'Sucessfully resetted credits used ');
            }
            /*trigger logging here */
            $this->logCreditUsed($model);
        }
        $this->redirect("/creditsUsed/index");
    }
    public function actionResetAll()
    {
        $models = RemoteDataCache::model()->findAll();
        foreach ($models as $currentModel) {
            $currentModel->last_balance_since_topup = $model->exact_balance;
            $currentModel->accumulating_credits_used = 0;
            if (!$currentModel->save()) {
                Yii::app()->user->setFlash("error",CHtml::errorSummary($currentModel));
            }else{
                Yii::app()->user->setFlash("success", 'Sucessfully resetted credits used ');
            }
        }
        /*trigger logging here */
        $this->logAllCreditUsed();
        $this->redirect("/creditsUsed/index");
    }
    protected function logCreditUsed(RemoteDataCache $remoteDataCache)
    {
        $currentCreditsUsed = ($remoteDataCache->last_balance_since_topup  - $remoteDataCache->exact_balance) + $remoteDataCache->accumulating_credits_used;
        $newLog = new CreditsUsedLogs();
        $newLog->credit_used = floatval($currentCreditsUsed);
        $newLog->remote_data_cache_accout_id = $remoteDataCache->id;
        // create log with timestamp
        $newLog->log_date = date("Y-m-d H:i:s");
        if (!$newLog->save()) {
            echo "Can't an error occured while creating new log";
        }else{
            $messageLog = sprintf('Log created | %s | log identification : %s', $newLog->log_date , $newLog->id);
            Yii::log($messageLog, CLogger::LEVEL_INFO,'log_credits');
            echo $messageLog. PHP_EOL;
        }
    }
    protected function logAllCreditUsed()
    {
        $allModels = RemoteDataCache::model()->findAll();
        foreach ($allModels as $key => $currentModel) {
            $this->logCreditUsed($currentModel);
        }
    }
	public function actionIndex()
	{
		$this->render('index');
	}

}