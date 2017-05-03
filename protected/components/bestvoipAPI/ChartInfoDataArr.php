<?php


class ChartInfoDataArr {
    public function getData(){
        /**
         * Get all information and return
         */
        $finalArr = array();
        $asteriskData = AsteriskCarriers::getData();
        $voipInfoRetriever = new BestVOIPInformationRetriever();
        foreach ($asteriskData as $key => $currentAsteriskData) {
            try {
                $remoteVoipResult = $voipInfoRetriever->getInfo(
                    $currentAsteriskData['main_user'],
                    $currentAsteriskData['main_pass'],
                    $currentAsteriskData['sub_user'],
                    $currentAsteriskData['sub_pass']
                );
                $currentAsteriskData['id'] = $key;
                $currentAsteriskData['balance'] = doubleval($remoteVoipResult->getBalance());
                $currentAsteriskData['exact_balance'] = doubleval($remoteVoipResult->getSpecificBalance());
                $finalArr[] = $currentAsteriskData;
            } catch (Exception $e) {
                Yii::log("Error occured : ".$e->getMessage(), CLogger::LEVEL_INFO, 'sync_log');
            }
        }
        return $finalArr;
    }
}