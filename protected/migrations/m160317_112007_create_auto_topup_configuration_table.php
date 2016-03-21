<?php

class m160317_112007_create_auto_topup_configuration_table extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->createTable("tbl_auto_topup_configuration", array(
            "id"=>"pk",
            "activated"=>"boolean",
            "topUpValue"=>"double",
            "budget"=>"double",
            "freeVoipAccount"=>"int",
            "remote_data_cache"=>"int",
            "date_created"=>"datetime",
            "date_updated"=>"datetime"
        ));
        /*find free voip account*/
        $freeVoipAccount = Yii::app()->db->createCommand("select * from tbl_freevoip_accounts where username = 'jawdroppingcalls' ")->queryRow();

        /*find all remote data cache and create each one a AutoTopUpConfiguration*/
        $allresult = Yii::app()->db->createCommand("select * from tbl_remote_data_cache")->queryAll();
        foreach ($allresult as $key => $value) {
            echo "creating autotopupconfiguration for ".$value['main_user'] . "\n";
            $this->insert("tbl_auto_topup_configuration",array(
                    "activated"=>false,
                    "topUpValue"=>0,
                    "budget"=>0,
                    "freeVoipAccount"=> $freeVoipAccount['id'],
                    "remote_data_cache"=>intval($value['id']),
                    "date_created"=>date("Y-m-d H:i:s"),
                    "date_updated"=>date("Y-m-d H:i:s")
            ));
            echo "created ".$value['main_user'] . "\n";
        }
	}

	public function safeDown()
	{
         $this->dropTable("tbl_auto_topup_configuration");
	}
}