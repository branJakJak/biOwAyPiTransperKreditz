<?php


class ConfigController extends Controller
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
                'actions' => array('index','autoTopUp'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    public function actionIndex(){
        $this->render('index');
    }
    public function actionAutoTopUp()
    {
        if ( isset($_POST['AutoTopUpUpdateForm'])  ) {
            $formModel = new AutoTopUpUpdateForm();
            $formModel->scenario = "updateVal";
            $formModel->setAttributes($_POST['AutoTopUpUpdateForm']);
            if( $formModel->validate() && $formModel->updateRecord() ){
                $remoteDataCache = $formModel->getRemoteDataCacheObject();
                Yii::app()->user->setFlash("success","Success! Auto top-up configuration for $remoteDataCache->sub_user under $remoteDataCache->main_user was updated. ");
            }else{
                Yii::app()->user->setFlash("error",CHtml::errorSummary($formModel));
            }
        }
        $criteria = new CDbCriteria;
        $criteria->addCondition("main_user <> 'Prion1967'");
        $criteria->order = "vici_user ASC";
        $allRemoteDataCache = RemoteDataCache::model()->findAll($criteria);
        $this->render('autoTopUp',compact('allRemoteDataCache'));
    }
} 