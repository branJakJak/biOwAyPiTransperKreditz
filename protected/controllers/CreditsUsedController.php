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
        $model = RemoteDataCache::model()->find();
        if ($model) {
            $model->last_balance_since_topup = 0;
            $model->accumulating_credit_used = 0;
            $model->update();
        }
        Yii::app()->user->setFlash("success", 'Sucessfully resetted credits used ');
        $this->redirect("/creditsUsed/index");
    }
    public function actionResetAll()
    {
        $models = RemoteDataCache::model()->findAll();
        foreach ($models as $currentModel) {
            $currentModel->last_balance_since_topup = 0;
            $currentModel->accumulating_credit_used = 0;
            $currentModel->update();
        }
        Yii::app()->user->setFlash("success", 'Sucessfully resetted credits used ');
        $this->redirect("/creditsUsed/index");
    }
	public function actionIndex()
	{
		$this->render('index');
	}

}