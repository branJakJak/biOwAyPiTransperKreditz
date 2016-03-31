<?php

/**
 * 
 */
class ControlController extends CController
{
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', 
		);
	}
    public function actionIndex()
    {
    	$controlDatasourceRetriever = Yii::app()->controlDataSourceRetirever;
    	$datasource = $controlDatasourceRetriever->fetchdata();
        $this->render('index',compact('datasource'));
    }
}