<?php

class RemoteDataCacheController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	
	// public $layout = Yii::getPathOfAlias("abound_theme.views.layouts.manage");
	public $layout = "//../../../themes/abound/views/layouts/manage";

	public $sideMenu = array();


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
				'actions'=>array('admin','delete','create','update','index','view','hide','hidden','unhide'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * Displays all hidden accounts
	 */
	public function actionHidden()
	{
		$this->layout = 'main';
		$model=new RemoteDataCache('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RemoteDataCache'])){
			$model->attributes=$_GET['RemoteDataCache'];
		}
		$model->is_hidden = true;
		$data = $model->search();
		$this->render('hidden',array(
			'model'=>$model,
			'data'=>$data
		));
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
		$model=new RemoteDataCache;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RemoteDataCache']))
		{
			$model->attributes=$_POST['RemoteDataCache'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		} else {
			$model->last_balance = 0;
			$model->balance = 0;
			$model->exact_balance = 0;
			$model->last_balance_since_topup = 0;
			$model->last_credit_update = 0;
			$model->ip_address = '1.2.3.4';
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	public function actionHide($account)
	{
		$dbCriteria = new CDbCriteria();
		$dbCriteria->compare("id",$account);
		$message = [
			'status'=>'error',
			'message'=>'Can\'t proceed with the request'
		];
		if (RemoteDataCache::model()->exists($dbCriteria)) {
			$model = RemoteDataCache::model()->findByPk($account);
			$model->is_hidden = true;
			if ($model->save()) {
				$message = [
					'status'=>'success',
					'message'=>'Account updated'
				];			
			} else {
				$message = [
					'status'=>'error',
					'message'=>'An error occured',
					'errors'=>$model->getErrors()
				];
			}
		}
		echo CJSON::encode($message);
	}
	public function actionUnhide($account)
	{
		$dbCriteria = new CDbCriteria();
		$dbCriteria->compare("id",$account);
		$message = [
			'status'=>'error',
			'message'=>'Can\'t proceed with the request'
		];
		if (RemoteDataCache::model()->exists($dbCriteria)) {
			$model = RemoteDataCache::model()->findByPk($account);
			$model->is_hidden = false;
			if ($model->save()) {
				$message = [
					'status'=>'success',
					'message'=>'Account updated'
				];			
			} else {
				$message = [
					'status'=>'error',
					'message'=>'An error occured',
					'errors'=>$model->getErrors()
				];
			}
			Yii::app()->user->setFlash("success","Account $model->sub_user is now visible");
		} else {
			Yii::app()->user->setFlash("error","Can't find account");
		}
		$this->redirect(array('/remoteDataCache/hidden'));
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

		if(isset($_POST['RemoteDataCache']))
		{
			$model->attributes=$_POST['RemoteDataCache'];
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

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('RemoteDataCache');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new RemoteDataCache('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RemoteDataCache'])){
			$model->attributes=$_GET['RemoteDataCache'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return RemoteDataCache the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=RemoteDataCache::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param RemoteDataCache $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='remote-data-cache-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
