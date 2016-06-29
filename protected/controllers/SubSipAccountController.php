<?php
class SubSipAccountController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('create', 'update', 'view', 'updateBalance', 'activate', 'deactivate', 'ajaxActivate', 'ajaxDeactivate','topUpSelected','activateGroup','deactivateGroup'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'index'),
                'roles' => array('administrator'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    public function getActivatedAccounts()
    {
        $criteria = new CDbCriteria;
        $criteria->compare("is_active","ACTIVE");
        $criteria->order = "vici_user ASC";
        return RemoteDataCache::model()->findAll($criteria);
    }
    public function actionDeactivateGroup(){
        $remoteDataCacheCollection = $this->getActivatedAccounts();
        $formModel = new DeactivationFormModel();
        if(isset($_POST['DeactivationFormModel'])){
            $formModel->attributes = $_POST['DeactivationFormModel'];
            $formModel->accounts = implode(",",$_POST['accounts']);
            if($formModel->validate()){
                $formModel->run();
                Yii::app()->user->setFlash("success", "Success! Selected accounts are now deactivated");
                $this->redirect("/subSipAccount/deactivateGroup");
            }
        }else{
            // Yii::app()->user->setFlash("error", CHtml::errorSummary($formModel));
        }
        $criteria = new CDbCriteria;
        $criteria->compare("action_type", ViciLogAction::VICILOG_ACTION_SUBSIP_DEACTIVIVATE);
        $criteria->order = "logDate DESC";
        $deactivateDataProvider = new CActiveDataProvider('ViciLogAction', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                    'pageSize'=>20
                ),
        ));
        $this->render('deactivateGroup',compact('formModel','remoteDataCacheCollection','deactivateDataProvider'));
    }

    public function getDeactivatedAccounts()
    {
        $criteria = new CDbCriteria;
        $criteria->compare("is_active","INACTIVE");
        $criteria->order = "vici_user ASC";
        return RemoteDataCache::model()->findAll($criteria);
    }
    public function actionActivateGroup(){
        $remoteDataCacheCollection = $this->getDeactivatedAccounts();
        $formModel = new ActivationFormModel();
        if(isset($_POST['ActivationFormModel'])){
            //$formModel->attributes = $_POST['ActivationFormModel'];
            $formModel->accounts = implode(",", $_POST['accounts']);
            if($formModel->validate()){
                $formModel->run();
                Yii::app()->user->setFlash("success", "Success! Selected accounts are now activated");
                $this->redirect("/subSipAccount/activateGroup");
            }
        }else{
            // Yii::app()->user->setFlash("error", CHtml::errorSummary($formModel));
        }

        $criteria = new CDbCriteria;
        $criteria->compare("action_type", ViciLogAction::VICILOG_ACTION_SUBSIP_ACTIVIVATE);
        $criteria->order = "logDate DESC";
        $activateDataProvider = new CActiveDataProvider('ViciLogAction', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                    'pageSize'=>20
                ),
        ));

        $this->render('activateGroup',compact('formModel','remoteDataCacheCollection','activateDataProvider'));
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
    public function actionTopUpSelected()
    {
        $formModel = new TopupForm;
        $numberOfAccounts = RemoteDataCache::model()->count();
        $topupLogsTotalToday = 0;
        $datasources = $this->loadDataSources();
        $chartInitialData = $datasources['iniChartData'];
        $sipAccountTempContainer = $datasources['sipAccountStr'];
        //append the current campaign 
        foreach ($sipAccountTempContainer as $key => $currentAccount) {
            $campaignInformationRetriever = Yii::app()->campaignInformationRetriever;
            $sipAccountTempContainer[$key] = ($key + 1) ." - ".$campaignInformationRetriever->getInformation($currentAccount) . " - ".$sipAccountTempContainer[$key];
        }
        $sipAccountsStr = json_encode($datasources['sipAccountStr']);
        $chartLabels = json_encode($sipAccountTempContainer);
        $seriesDataStr = json_encode($datasources['chartSeriesData']);

        $allSipAccounts = array();
        /*retrieve all accounts to be topped up*/
        /*get all subsip logs from Vicilogs*/
        $criteria = new CDbCriteria;
        $criteria->compare("date(logDate)",date("Y-m-d"));
        $criteria->compare("action_type",'SUB_ACCOUNT_TOPUP');
        $criteria->order = "logDate DESC";
        $logRecsTodayDataProvider = new CActiveDataProvider('ViciLogAction', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20,
            )
        ));
        if (isset($_POST['TopupForm'])) {
            $formModel->attributes = $_POST['TopupForm'];
            if ($formModel->validate()) {
                $numberOfAffectedAccounts = $formModel->topupAccounts();
                Yii::app()->user->setFlash("success","Success! All $numberOfAffectedAccounts account(s) are topped up.");
                $this->redirect(array('/subSipAccount/topUpSelected'));
            }
        }
        foreach ($logRecsTodayDataProvider->data as $key => $value) {
            $topupLogsTotalToday += $value->topUpValue;
        }
        $allSipAccounts = $this->getRemoteDataCacheAccounts();
        //append current campaign

        //List of force agent options
        $forceAgentModelAll = ForceAgentTable::model()->findAll();
        // $listForceAgentCollection = array("VBpi8"=>"Injury Campaign","PBAVB6"=>"PBA Campaign","LIFEbz"=>"LIFE","VBInjury"=>"Injury TEST","PBATEST"=>"PBA TEST" , "PiFORM"=>"Injury Form","PBAFORM"=>"PBA Form","DELAY8"=>"DELAY8");
        $listForceAgentCollection = CHtml::listData($forceAgentModelAll, 'force_agent_value', 'force_agent_lbl');
        $this->render('topUpSelected',compact('chartLabels','formModel','allSipAccounts','topupLogsTotalToday','logRecsTodayDataProvider','numberOfAccounts','sipAccountsStr','sipAccountsStr','seriesDataStr','listForceAgentCollection'));
    }
    /**
     * 
     * @return array Accouts to top up
     */
    public function getRemoteDataCacheAccounts()
    {
        $accountsCollection = [];
        $tempContainer = RemoteDataCache::model()->findAll();
        foreach ($tempContainer as $key => $currentRemoteDataCache) {
            $accountsCollection[] = $currentRemoteDataCache->sub_user;
        }
        return $accountsCollection;
    }
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new SubSipAccount;
        if (isset($_GET['SubSipAccount'])) {
            $model->attributes = $_GET['SubSipAccount'];
        }
        if (isset($_POST['SubSipAccount'])) {
            $model->attributes = $_POST['SubSipAccount'];
            $model->balance = 0;
            $model->exact_balance = 0;
            if ($model->save()) {
                Yii::app()->user->setFlash("success", "Sub SIP account registered.");
                $this->redirect(array('view', 'id' => $model->id));
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
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['SubSipAccount'])) {
            $model->attributes = $_POST['SubSipAccount'];
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
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        Yii::app()->user->setFlash('success', '<strong>Done !</strong> Sub SIP Account Deleted.');
        $this->redirect("/sipAccount/index");
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {

        $dataProvider = new CActiveDataProvider('SubSipAccount');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new SubSipAccount('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SubSipAccount']))
            $model->attributes = $_GET['SubSipAccount'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SubSipAccount the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = SubSipAccount::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SubSipAccount $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sub-sip-account-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionUpdateBalance($subAccount) {
        $updateSubSipAccount = new UpdateSubSipAccount();
        $updateSubSipAccount->subSipOwner = intval($subAccount);
        $subsipmodel = $updateSubSipAccount->getSubSipAccountModel();
        if (isset($_POST['UpdateSubSipAccount'])) {
            $updateSubSipAccount->attributes = $_POST['UpdateSubSipAccount'];
            $updateSubSipAccount->subSipOwner = intval($subAccount);
            if ($updateSubSipAccount->update()) {
                /* update the database too */
                $childCur = SubSipAccount::model()->findByPk($subAccount);

                // $remoteChecker = new ApiRemoteStatusChecker($childCur->parent_sip);
                // $remoteChecker->checkAllSubAccounts();

                Yii::app()->user->setFlash("success", "Success , Credits was successfully transfered . ");
            } else {
                Yii::app()->user->setFlash("error", "Update failed , We cant seem to update the balance today.");
            }
            $updateSubSipAccount->unsetAttributes();
        } else {
            Yii::app()->user->setFlash('info', 'You are about to update the balance of <strong>' . $subsipmodel->customer_name . '</strong>');
        }
        $this->render('updateBalance', compact('updateSubSipAccount', 'subsipmodel'));
    }

    public function actionActivate($subAccount) {
        /**
         * @var SubSipAccount $childCur
         */
        $childCur = SubSipAccount::model()->findByPk($subAccount);
        $activatorObj = new ActivateVicidialUser($childCur->parentSip);
        $activatorObj->run();
        Yii::app()->user->setFlash("info", "Account <strong>{$childCur->username}</strong> activated");
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionAjaxActivate($record_id) {
        header("Content-Type: application/json");
        $model = RemoteDataCache::model()->findByPk($record_id);
        if (!$model) {
            throw new CHttpException(404, "We cant find that record from database");
        }
        $sipAccount = new SipAccount();
        $sipAccount->vicidial_identification = $model->vici_user;
        $activatorObj = new ActivateVicidialUser($sipAccount);
        $reqREs = $activatorObj->run();
        /* find the RemoteDataCache and update it too */
        $model->is_active = "ACTIVE";
        $model->save();
        echo json_encode(array("success" => true, "message" => "Account activated", "result" => $reqREs));
    }

    public function actionDeactivate($subAccount) {
        $childCur = SubSipAccount::model()->findByPk($subAccount);
        $activatorObj = new DeactivateVicidialUser($childCur->parentSip);
        $activatorObj->run();


        Yii::app()->user->setFlash("info", "Account <strong>{$childCur->username}</strong> deactivated");
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionAjaxDeactivate($record_id) {
        header("Content-Type: application/json");
        $model = RemoteDataCache::model()->findByPk($record_id);
        if (!$model) {
            throw new CHttpException(404, "We cant find that record from database");
        }
        $sipAccount = new SipAccount();
        $sipAccount->vicidial_identification = $model->vici_user;
        $activatorObj = new DeactivateVicidialUser($sipAccount);
        $reqREs = $activatorObj->run();


        /* find the RemoteDataCache and update it too */
        $model->is_active = "INACTIVE";
        $model->save();

        echo json_encode(array("success" => true, "message" => "Account activated", "result" => $reqREs));
    }

}
