<?php

class m160215_141955_create_vici_action_logger extends CDbMigration
{

	public function safeUp()
	{
		$this->createTable("tbl_vici_log_action",array(
				'id'=>"pk",
				'action_type'=>"string not null",
				'message'=>"string",
				'topUpValue'=>"double",
				'batch'=>"string",
				'logDate'=>"datetime"
			),'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
	}

	public function safeDown()
	{
		$this->dropTable("tbl_vici_log_action");
	}

}