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
                'actions' => array('create', 'update', 'index', 'view','getBarChartReportData','sipData','remoteAsteriskInfo'),
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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new SipAccount;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['SipAccount'])) {
            $model->attributes = $_POST['SipAccount'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
        $seriesData = SipAccount::getSeriesDataAsArr();
        foreach ($seriesData as $key => $currentSeriesData) {
            $curDataContainer = array();
            if($currentSeriesData >= 10){
                $curDataContainer = array("y"=>$currentSeriesData,"color"=>"#7CB5EC");
            }else{
                $curDataContainer = array("y"=>$currentSeriesData,"color"=>"red");
            }
            
            $seriesData[$key] = $curDataContainer;
        }
        $seriesDataStr = json_encode($seriesData);

        $sipAccounts = SipAccount::getSipAccountsAsArr();
        $sipAccountsStr = json_encode($sipAccounts);


        $chartDataRetriever = new SipAccountChartData();
        $chartData = $chartDataRetriever->retrieve();

        $dataProvider = new CActiveDataProvider('SipAccount');
        $dataProvider->pagination = false;
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'chartData'=>$chartData,
            'seriesDataStr'=>$seriesDataStr,
            'sipAccountsStr'=>$sipAccountsStr,
        ));
    }
    public function actionSipData()
    {
        $finalArr = array();
        $allModels = SipAccount::model()->with("subSipAccounts")->findAll();
        $asteriskData = AsteriskCarriers::getData();
        foreach ($allModels as $currentModel) {
            $curTempContainer = array(
                    "parent_sip_id"=>$currentModel->id,
                    "username"=>$currentModel->username,
                    "vicidial_identification"=>$currentModel->vicidial_identification,
                    "account_status"=>$currentModel->account_status
            );
            foreach ($asteriskData as $currentAsteriskData) {
                if ($currentAsteriskData['main_user'] === $currentModel->username) {
                    $curTempContainer['vici_ip_address'] = $currentAsteriskData['server_ip'];
                }
            }
            foreach($currentModel->subSipAccounts as $currentSubSipAccount) {
                $curTempContainer['subSipAccounts'][] = array(
                        "sub_sip_id"=>$currentSubSipAccount->id,
                        "username"=>$currentSubSipAccount->username,
                        "account_status"=>$currentSubSipAccount->account_status,
                        "customer_name"=>$currentSubSipAccount->customer_name,
                        "balance"=>$currentSubSipAccount->balance,
                        "exact_balance"=>$currentSubSipAccount->exact_balance,
                );
            }
            $finalArr[] = $curTempContainer;
        }
        echo CJSON::encode($finalArr);
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
        // $chartDataRetriever = new SipAccountChartData();
        // $chartData = $chartDataRetriever->retrieve();
        $seriesData = SipAccount::getSeriesDataAsArr();
        foreach ($seriesData as $key => $value) {
            $curDataContainer = array();
            //$value += rand(0,20);
            $curDataContainer = array("y"=>$value,"color"=>"#7CB5EC");
            $seriesData[$key] = $curDataContainer;

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
