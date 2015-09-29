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
                'actions' => array('create', 'update', 'index', 'view','getBarChartReportData','test'),
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
        // /*retrieve all accounts model*/
        // $allModels = SipAccount::model()->findAll();
        // foreach ($allModels as $currentModel) {
        //     // $remoteChecker = new ApiRemoteStatusChecker($currentModel->id);
        //     // $remoteChecker->checkAllSubAccounts();
        //     foreach ($currentModel->subSipAccounts as $currentSubSipAccount) {
        //         //retrieve updated subsip
        //         $tempSubSip = SubSipAccount::model()->findByPk($currentSubSipAccount->id);
        //         if (doubleval($tempSubSip->exact_balance) <= 5) {
        //             $deactivatorObj = new DeactivateVicidialUser($currentModel);
        //             $deactivatorObj->run();
        //         }
        //     }
        // }

        $chartDataRetriever = new SipAccountChartData();
        $chartData = $chartDataRetriever->retrieve();

        $dataProvider = new CActiveDataProvider('SipAccount');
        $dataProvider->pagination = false;
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'chartData'=>$chartData
        ));
    }
    public function actionTest()
    {
        $allModels = SipAccount::model()->findAll();
        $chartDataRetriever = new SipAccountChartData();
        $chartData = $chartDataRetriever->retrieve();

        $dataProvider = new CActiveDataProvider('SipAccount');
        $dataProvider->pagination = false;
        $this->render('test', array(
            'dataProvider' => $dataProvider,
            'chartData'=>$chartData
        ));
        
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
