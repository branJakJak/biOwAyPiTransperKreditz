<?php

class m160809_102157_account_charge_log extends CDbMigration
{
	public function safeUp()
	{
        $this->createTable("tbl_account_charge_log", array(
            "id"=>'pk',
            "account_id"=>'INT(11)',//the id of RemoteDataCache
            "charge"=>'double',
            "date_created"=>'datetime',
            "date_updated"=>'datetime',
        ));
	}

	public function safeDown()
	{
        $this->dropTable("tbl_account_charge_log");
	}
}