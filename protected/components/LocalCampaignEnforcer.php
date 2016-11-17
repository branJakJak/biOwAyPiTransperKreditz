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
        $criteria=new CDbCriteria;
        $criteria->compare('sub_user',$subUser);
        $sipAccount = RemoteDataCache::model()->find($criteria);
        /*find account and update directly its campaign*/
        if($sipAccount){
            $sipAccount->campaign = $campaignName;
            $sipAccount->save(false);
            $dataFound = true;
        }
        return $dataFound;
    }

}