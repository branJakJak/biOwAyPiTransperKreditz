<?php 

/**
* VicidialDbActivator
*/
class VicidialDbActivator extends CApplicationComponent  implements UpdateRemoteVicidialAccount
{
    public $vicidialUser;

    /**
     *
     */
    public function run()
    {
        /**
         * @var CDbConnection $asteriskDb
         */
        $judgement = false;
        $asteriskDb = Yii::app()->asterisk_db;
        $updateCommand = $asteriskDb->createCommand("UPDATE vicidial_remote_agents SET status='ACTIVE' where user_start = :vicidial_user");
        $updateCommand->bindParam(":vicidial_user", $this->getVicidialUser(), PDO::PARAM_INT);
        $updateCommand->execute();//execute update
        $updatedStatus = VicidialDbHelper::getStatus($this->getVicidialUser());
        //check status if INACTIVE
        if($updatedStatus == 'ACTIVE'){
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