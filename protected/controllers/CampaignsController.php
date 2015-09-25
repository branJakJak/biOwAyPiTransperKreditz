<?php


class CampaignsController extends Controller
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
                'actions' => array('index','activate','deactivate'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    public function actionIndex()
    {
        $campaignRetriever = new VicidialCampaignRetriever();
        $listCampaignsArr = $campaignRetriever->retrieve();
        print_r($listCampaignsArr);
        var_dump($listCampaignsArr);
        die();
        $gridDataProvider = new CArrayDataProvider($listCampaignsArr);
        $this->render('index',compact('gridDataProvider'));
    }
    public function actionActivate($campaign)
    {
        $campaign = trim($campaign);
        $campaign = ltrim($campaign);
        $campaign = rtrim($campaign);
        $activateObj = new ActivateCampaign($campaign);
        $activateObj->activate();

        Yii::app()->user->setFlash('success', "<strong>$campaign Activated!</strong> Campaign $campaign is now activated.");
        $this->redirect(Yii::app()->request->urlReferrer);
    }
    public function actionDeactivate($campaign)
    {
        $campaign = trim($campaign);
        $campaign = ltrim($campaign);
        $campaign = rtrim($campaign);
        
        $activateObj = new DeactivateCampaign($campaign);
        $activateObj->deactivate();

        Yii::app()->user->setFlash('success', "<strong>$campaign Deactivated!</strong> Campaign $campaign is now deactivated.");
        $this->redirect(Yii::app()->request->urlReferrer);
    }

}