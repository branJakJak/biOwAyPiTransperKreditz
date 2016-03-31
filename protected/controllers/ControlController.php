<?php

/**
 * 
 */
class ControlController extends CController
{
	public $layout = "dashboard_template";
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index','updateChannel'),
				'users'=>array('*'),
			),
			array('deny',
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
    	Yii::app()->theme = "metro";
    	$totalNumberOfAgents = 0;
    	$controlDatasourceRetriever = Yii::app()->controlDataSourceRetirever;
    	$datasource = $controlDatasourceRetriever->fetchdata();
    	foreach ($datasource->data as $key => $value) {
    		$totalNumberOfAgents += intval($value['agents']);
    	}
        $this->render('index',compact('datasource','totalNumberOfAgents'));
    }
    public function actionUpdateChannel($campaign_id , $agents , $channels,$throttleValue,$slider)
    {
    	$channelUpdater = Yii::createComponent("application.components.NumberOfLinesUpdater");
		$channelUpdater->campaign_id = $campaign_id;
		$channelUpdater->agents = $agents;
		$channelUpdater->channels = $channels;
		$channelUpdater->throttleValue = $throttleValue;
		$channelUpdater->slider    	 = $slider;
    	if ($channelUpdater->update()) {
    		echo "Succes! $campaign_id updated";
    	}else{
    		echo "Failed! There was a problem while updating $campaign_id";
    	}
    }
}