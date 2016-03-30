<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2/12/2016
 * Time: 2:45 AM
 */

class VicidialDbHelper {
    public static function getStatus($remoteVicidialUser){
        /**
         * @var CDbConnection $asteriskDb
         */
        $status = "";
        $asteriskDb = Yii::app()->asterisk_db;
        $selectCommand = $asteriskDb->createCommand("SELECT STATUS FROM vicidial_remote_agents WHERE user_start =:vicidial_user");
        $selectCommand->params = array(
            "vicidial_user"=> $remoteVicidialUser
        );
        $res = $selectCommand->queryRow();
        if(!empty($res)){
            $status = $res['STATUS'];
        }
        return $status;
    }

} 