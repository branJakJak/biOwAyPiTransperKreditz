<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2/12/2016
 * Time: 2:35 AM
 */

class VicidialDbDeactivator  extends CApplicationComponent  implements UpdateRemoteVicidialAccount{

    public $vicidialUser;
    public function run()
    {
        /**
         * @var CDbConnection $asteriskDb
         */
        $judgement = false;
        $asteriskDb = Yii::app()->asterisk_db;
        $updateCommand = $asteriskDb->createCommand("UPDATE vicidial_remote_agents SET status='INACTIVE',campaign_id='TRIGGER' where user_start = :vicidial_user");
        $updateCommand->bindParam(":vicidial_user", $this->vicidialUser, PDO::PARAM_INT);
        $updateCommand->execute();//execute update
        $updatedStatus = VicidialDbHelper::getStatus($this->getVicidialUser());
        //check status if INACTIVE
        if($updatedStatus == 'INACTIVE'){
            $judgement = true;
        }
        return $judgement;
    }

    /**
     * @return mixed
     */
    public function getVicidialUser()
    {
        return $this->vicidialUser;
    }

    /**
     * @param mixed $vicidialUser
     */
    public function setVicidialUser($vicidialUser)
    {
        $this->vicidialUser = $vicidialUser;
    }

}