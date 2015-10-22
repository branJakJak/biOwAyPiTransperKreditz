<?php

class SipAccountController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + notifyAccount,updateCampaignName', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
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
                'actions' => array('create', 'update', 'index', 'view','getBarChartReportData','sipData','remoteAsteriskInfo','syncApi','notifyAccount','updateCampaignName'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
                'roles'=>array('administrator'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionUpdateCampaignName()
    {
        header("Content-Type: application/json");
        $jsonMessage = array(
                "success"=>false,
                "message"=>"Incomplete data/parameter",
            );
        $postedData = json_decode(file_get_contents("php://input"),true);
        if ( isset($postedData['vici_user']) && isset($postedData['main_user']) && isset($postedData['main_pass']) && isset($postedData['campaign'])) {
            $campaignUpdaterObj = new CampaignNameUpdater();
            $affectedRows = $campaignUpdaterObj->update(
                    $postedData['vici_user'],
                    $postedData['main_user'],
                    $postedData['main_pass'],
                    $postedData['campaign']
            );
            if ($affectedRows > 0) {
                $jsonMessage = array(
                    "success"=>true,
                    "message"=>"Success : Campaign name updated.",
                );
            }else{
                $jsonMessage = array(
                    "success"=>false,
                    "message"=>"We met some problem while updating the record. Please try again later.",
                );
            }
        }
        echo json_encode($jsonMessage);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new SipAccount;
        if (isset($_POST['SipAccount'])) {
            $model->attributes = $_POST['SipAccount'];
            if ($model->save()){
                Yii::app()->user->setFlash("success","Main SIP Account Registered.<br><strong>Please continue </strong> filling up the rest of the form.");
                $this->redirect(array('subSipAccount/create', 'SubSipAccount[parent_sip]' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['SipAccount'])) {
            $model->attributes = $_POST['SipAccount'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();


        Yii::app()->user->setFlash('success', '<strong>SIP Account Deleted!</strong> SIP Account Deleted.');
        $this->redirect("/sipAccount/index");
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->layout = "column2";

        $this->render('index');

    }
    public function actionSipData()
    {
        header("Content-Type: application/json");
        $allremoteData = RemoteDataCache::model()->findAll();
        $updatedData = array();
        /*format some data*/
        foreach ($allremoteData as $curObj) {
            $curObj->date_updated = $this->simpleAgoHelper(  strtotime($curObj->date_updated)  );
            $updatedData[] = $curObj;
        }
        echo CJSON::encode($updatedData);
    }
    private function simpleAgoHelper($time){
       $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
       $lengths = array("60","60","24","7","4.35","12","10");
       $now = time();
       $difference     = $now - $time;
       $tense         = "ago";

       for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
           $difference /= $lengths[$j];
       }

       $difference = round($difference);

       if($difference != 1) {
           $periods[$j].= "s";
       }
       return "$difference $periods[$j] 'ago' ";
    }
    public function actionRemoteAsteriskInfo()
    {
        header("Content-Type: application/json");
        echo json_encode(AsteriskCarriers::getData());
    }

    /**
     * Retrieves bar chart report data as json data
     */
    public function actionGetBarChartReportData()
    {
        header("Content-Type: application/json");
        $allremoteData = RemoteDataCache::model()->findAll();
        $seriesData = array();

        foreach ($allremoteData as $currentRemoteData) {
            /**
             * @var $currentRemoteData RemoteDataCache
             */
            $curDataContainer = array();

            if ($currentRemoteData->balance >= 10 ) {
                $curDataContainer = array("y"=>doubleval($currentRemoteData->balance),"color"=>"#7CB5EC");
            }else{
                if ($currentRemoteData->balance >= 3) {
                    $curDataContainer = array("y"=>doubleval($currentRemoteData->balance),"color"=>"orange");
                }else{
                    $curDataContainer = array("y"=>doubleval($currentRemoteData->balance),"color"=>"red");
                }
            }
            $seriesData[] = $curDataContainer;
        }
        echo CJSON::encode($seriesData);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new SipAccount('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['SipAccount']))
            $model->attributes = $_GET['SipAccount'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }
    public function actionSyncApi()
    {
        header("Content-Type: application/json");
        $jsonMessage = array("success"=>false,"message"=>"Incomplete parameter");
        $postedJson = file_get_contents("php://input");
        $postedJson = json_decode($postedJson,true);
        if (isset($postedJson['mainSipAccount'])) {
            $postedJson['mainSipAccount'] = doubleval($postedJson['mainSipAccount']);
            $currentModel = SipAccount::model()->findByPk($postedJson['mainSipAccount']);
            if (!is_null($currentModel)) {

                $remoteChecker = new ApiRemoteStatusChecker($currentModel->id);
                $remoteChecker->checkAllSubAccounts();
                foreach ($currentModel->subSipAccounts as $currentSubSipAccount) {
                    //retrieve updated subsip
                    $jsonMessage['reports'][] = "Checking $currentSubSipAccount->username under $currentModel->username. |".date("Y-m-d H:i:s").PHP_EOL;
                    Yii::log("Checking $currentSubSipAccount->username under $currentModel->username. | ".date("Y-m-d H:i:s"), CLogger::LEVEL_INFO,'info');
                    $tempSubSip = SubSipAccount::model()->findByPk($currentSubSipAccount->id);
                    if (doubleval($tempSubSip->exact_balance) <= 3) {
                        $deactivatorObj = new DeactivateVicidialUser($currentModel);
                        $deactivatorObj->run();
                        mail("hellsing357@gmail.com", 'Account Deactivated', "$currentModel->username deactivated");
                    }
                }
                $jsonMessage = array("success"=>true,"message"=>"SIP model updated");
            }else{
                $jsonMessage = array("success"=>false,"message"=>"Cant find SIP Model");
            }
        }
        // /*retrieve all accounts model*/
        // $allModels = SipAccount::model()->findAll();
        // foreach ($allModels as $currentModel) {
        //     $remoteChecker = new ApiRemoteStatusChecker($currentModel->id);
        //     $remoteChecker->checkAllSubAccounts();
        //     foreach ($currentModel->subSipAccounts as $currentSubSipAccount) {
        //         //retrieve updated subsip
        //         $jsonMessage['reports'][] = "Checking $currentSubSipAccount->username under $currentModel->username. |".date("Y-m-d H:i:s").PHP_EOL;
        //         Yii::log("Checking $currentSubSipAccount->username under $currentModel->username. | ".date("Y-m-d H:i:s"), CLogger::LEVEL_INFO,'info');
        //         $tempSubSip = SubSipAccount::model()->findByPk($currentSubSipAccount->id);
        //         if (doubleval($tempSubSip->exact_balance) <= 3) {
        //             $deactivatorObj = new DeactivateVicidialUser($currentModel);
        //             $deactivatorObj->run();
        //             mail("hellsing357@gmail.com", 'Account Deactivated', "$currentModel->username deactivated");
        //         }
        //     }
        // }
        echo json_encode($jsonMessage);
    }
    public function actionNotifyAccount()
    {
        /*@TODO , notify user about the less 10 credits*/
        header("Content-Type: application/json");
        $jsonMessage = array("succes"=>false,"message"=>"Incomplete parameter/data");
        $notifier = new SipAccountNotifier();
        $notifier->quickRing();
        mail("hellsing357@gmail.com", "Credits Low < 3", file_get_contents("php://input"));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SipAccount the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = SipAccount::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SipAccount $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sip-account-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
