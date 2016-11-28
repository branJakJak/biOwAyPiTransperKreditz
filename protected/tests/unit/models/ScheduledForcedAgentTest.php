<?php


class ScheduledForcedAgentTest extends CTestCase {
    public function test_scheduled_force_agent(){
        ScheduledForceAgent::model()->deleteAll();

        //simulate top up
        /**
         * @var $remoteDataCacheSingle RemoteDataCache
         */
        $remoteDataCacheSingle = RemoteDataCache::model()->find();
        $topUpForm = new TopupForm();
        $topUpForm->accounts = $remoteDataCacheSingle->sub_user;
        $topUpForm->topupvalue = 0;
        $topUpForm->andActivate = false;
        $topUpForm->forceAgent = true;
        $topUpForm->scheduleForceAgent = true;
        $topUpForm->scheduleTime = date("Y-m-d H:i:s");//set time of schedule current time
        $topUpForm->topupAccounts();
        //run the schedule command
        //get current time

        $currentTime = date("Y-m-d H:i");
        $dbCriteria = new CDbCriteria();
        $dbCriteria->compare("DATE_FORMAT(`scheduled_date`, '%Y-%m-%d %H:%i')",$currentTime );
        $foundModels = ScheduledForceAgent::model()->findAll($dbCriteria);
        $this->assertEquals(1, count($foundModels), 'Should get the inserted test data');
        /*
         * @var $currentModel ScheduledForceAgent
         * @var $remoteDataModel RemoteDataCache
         * */
        foreach ($foundModels as $currentModel) {
            $remoteDataModel = RemoteDataCache::model()->findByPk($currentModel->account_id);
            $this->assertNotNull($remoteDataModel, "there is a remotedatacache");
            if ($remoteDataModel) {
                $topupform = new TopupForm();
                $topupform->accounts = $remoteDataModel->sub_user;
                $topupform->topupvalue = $currentModel->topup_amount;
                $topupform->andActivate = $currentModel->activate;
                $topupform->forceAgent = true;
                $topupform->topupAccounts();
                $logMessage = "Scheduled force agent on account : $remoteDataModel->sub_user with value $currentModel->topup_amount last $currentModel->scheduled_date";
                echo $logMessage . PHP_EOL;
                Yii::log($logMessage , CLogger::LEVEL_INFO);
            }
        }
    }

} 