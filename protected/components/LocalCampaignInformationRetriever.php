<?php

class LocalCampaignInformationRetriever extends CampaignInformationRetriever{
    public function getInformation($accountName)
    {
        $campaignName = "N/A";
        /**
         * @var $remoteDataObj RemoteDataCache
         */
        $criteria=new CDbCriteria;
        $criteria->compare('sub_user',$accountName);
        $remoteDataObj = RemoteDataCache::model()->find($criteria);
        if($remoteDataObj){
            $campaignName = $remoteDataObj->campaign;
        }
        return $campaignName;
    }
}