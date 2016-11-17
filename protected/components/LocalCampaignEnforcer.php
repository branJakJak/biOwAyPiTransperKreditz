<?php


class LocalCampaignEnforcer extends CampaignForcer{
    /**
     * @inheritdoc
     */
    public function update($campaignName, $subUser)
    {
        $dataFound = false;
        /**
         * @var $sipAccount RemoteDataCache
         */
        $sipAccount = RemoteDataCache::model()->findByAttributes(['sub_user' => $subUser]);
        /*find account and update directly its campaign*/

        if($sipAccount){
            $sipAccount->campaign = $campaignName;
            $sipAccount->save(false);
            $dataFound = true;
        }
        return $dataFound;
    }

}