<?php 

/**
* ChartController
*/
class ChartController extends Controller
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
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$initialSeriesData = array();
        $sipAccountNames = array();
        $chartInitialData = array();
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
            $initialSeriesData[$key] = array(
                "y"=>doubleval($currentRemoteData->exact_balance),
                "color"=>$tempColorContainer,
            );
        }
        $this->render('index', array(
            'chartData'=>$chartInitialData,
            'seriesDataStr'=>json_encode($initialSeriesData),
            'sipAccountsStr'=>json_encode($sipAccountNames),
        ));
	}

}