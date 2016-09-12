<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RemoteUnusedAccountsCommand
 *
 * @author 
 */
class RemoveUnusedAccountsCommand extends CConsoleCommand {

    public function actionIndex() {

        /*get all ids*/
        $remoteDataCacheIds = array();
        // retrieve all records from database 
        $remoteDataCacheModels = RemoteDataCache::model()->findAll();
        //retrieve all records from remote
        $allAsteriskModels = AsteriskCarriers::getData();

        //collect the id 
        foreach ($remoteDataCacheModels as $key => $value) {
            $remoteDataCacheIds[] = $value->id;
        }
        $remoteDataCacheModels = null;
        foreach ($remoteDataCacheIds as $currentRemoteDataCacheId) {
            $curRemoteDataCacheModel = RemoteDataCache::model()->findByPk($currentRemoteDataCacheId);
            $currentRemoteDataCacheExists = false;
            Yii::log("Checking :  {$curRemoteDataCacheModel->sub_user} | {$curRemoteDataCacheModel->sub_pass}", CLogger::LEVEL_INFO,'sync_remove');
            /**
             * @var RemoteDataCache $currentRemoteDataCache
             */
            foreach ($allAsteriskModels as $currentAsteriskModel) {
                //check if matched
                if (
                        $currentAsteriskModel['main_user'] === $curRemoteDataCacheModel->main_user &&
                        $currentAsteriskModel['main_pass'] === $curRemoteDataCacheModel->main_pass &&
                        $currentAsteriskModel['sub_user'] === $curRemoteDataCacheModel->sub_user &&
                        $currentAsteriskModel['sub_pass'] === $curRemoteDataCacheModel->sub_pass
                ) {
                    Yii::log("RemoteDataCache exists! {$curRemoteDataCacheModel->sub_user} | {$curRemoteDataCacheModel->sub_pass}", CLogger::LEVEL_INFO,'sync_remove');
                    $currentRemoteDataCacheExists = true;
                    continue;
                }
            }//end of loop allasteriskmodels
            if (!$currentRemoteDataCacheExists) {
                $logMessage = sprintf("Deleting record : %s | %s | %s | %s" ,
                        $curRemoteDataCacheModel->main_user,
                        $curRemoteDataCacheModel->main_pass,
                        $curRemoteDataCacheModel->sub_user,
                        $curRemoteDataCacheModel->sub_pass
                        );
                Yii::log($logMessage , CLogger::LEVEL_INFO,"sync_remove");
                $curRemoteDataCacheModel->delete();
            }
        }//end of remotedatacache loop
    }

}
