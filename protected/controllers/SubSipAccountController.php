<?php

class SubSipAccountController extends Controller
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
                'actions'=>array('create','update','index','view','admin','delete','updateBalance','activate','deactivate'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );

	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new SubSipAccount;
		if (isset($_GET['SubSipAccount'])) {
			$model->attributes=$_GET['SubSipAccount'];
		}
		if(isset($_POST['SubSipAccount']))
		{
			$model->attributes=$_POST['SubSipAccount'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SubSipAccount']))
		{
			$model->attributes=$_POST['SubSipAccount'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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

		Yii::app()->user->setFlash('success', '<strong>Done !</strong> Sub SIP Account Deleted.');
		$this->redirect("/sipAccount/index");
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

		$dataProvider=new CActiveDataProvider('SubSipAccount');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SubSipAccount('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SubSipAccount']))
			$model->attributes=$_GET['SubSipAccount'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return SubSipAccount the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=SubSipAccount::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param SubSipAccount $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sub-sip-account-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionUpdateBalance($subAccount)
	{
		$updateSubSipAccount = new UpdateSubSipAccount();
		$updateSubSipAccount->subSipOwner = intval($subAccount);
		$subsipmodel = $updateSubSipAccount->getSubSipAccountModel();
		if (isset($_POST['UpdateSubSipAccount'])) {
			$updateSubSipAccount->attributes = $_POST['UpdateSubSipAccount'];
			$updateSubSipAccount->subSipOwner = intval($subAccount);
			if ($updateSubSipAccount->update()) {
				/* update the database too */
				$childCur = SubSipAccount::model()->findByPk($subAccount);
				$voipAccountBlocker = new BlockVoipAccount();

				$remoteChecker = new ApiRemoteStatusChecker($childCur->parent_sip);
				$remoteChecker->checkAllSubAccounts();

                if (doubleval($childCur->exact_balance) <= 5) {
                    $voipAccountBlocker->block($childCur->parentSip, $childCur);
                }
                // else {
                //     $voipAccountBlocker->unblock($childCur->parentSip, $childCur);
                // }
				Yii::app()->user->setFlash("success","Success , Credits was successfully transfered . ");
			}else{
				Yii::app()->user->setFlash("error","Update failed , We cant seem to update the balance today.");
			}
			$updateSubSipAccount->unsetAttributes();
		}else{
			Yii::app()->user->setFlash('info', 'You are about to update the balance of <strong>'.$subsipmodel->customer_name.'</strong>');
		}
		$this->render('updateBalance',compact('updateSubSipAccount','subsipmodel'));
	}
	public function actionActivate($subAccount)
	{
        /**
         * @var SubSipAccount $childCur
         */
		$childCur = SubSipAccount::model()->findByPk($subAccount);
        $activatorObj = new ActivateVicidialUser($childCur->parentSip);
        $activatorObj->run();
		Yii::app()->user->setFlash("info","Account <strong>{$childCur->username}</strong> activated");
		$this->redirect(Yii::app()->request->urlReferrer);
	}
	public function actionDeactivate($subAccount)
	{
        $childCur = SubSipAccount::model()->findByPk($subAccount);
        $activatorObj = new DeactivateVicidialUser($childCur->parentSip);
        $activatorObj->run();

		Yii::app()->user->setFlash("info","Account <strong>{$childCur->username}</strong> deactivated");
		$this->redirect(Yii::app()->request->urlReferrer);
	}
}
