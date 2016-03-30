<?php

/**
 * AsteriskCarriers
 */
class AsteriskCarriers {

    public static function getData() {
        $command = Yii::app()->asterisk_db->createCommand("select * from user_carrier");
        return $command->queryAll();
    }

}
