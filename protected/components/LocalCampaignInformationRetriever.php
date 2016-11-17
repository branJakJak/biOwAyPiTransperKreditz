<?php

class LocalCampaignInformationRetriever extends CampaignInformationRetriever{
    public function getInformation($accountName)
    {
        $campaignName = "N/A";
        /**
         * @var $remoteDataObj RemoteDataCache
         */
        $remoteDataObj = RemoteDataCache::model()->find(['sub_user' => $accountName]);
        if($remoteDataObj){
            $campaignName = $remoteDataObj->campaign;
        }
        return $campaignName;
    }


} 