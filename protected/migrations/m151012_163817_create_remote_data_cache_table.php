<?php

class m151012_163817_create_remote_data_cache_table extends CDbMigration
{

	public function safeUp()
	{
		$this->createTable("tbl_remote_data_cache",array(
				"id"=>"pk",
				"main_user"=>"string",
				"main_pass"=>"string",
				"sub_user"=>"string",
				"sub_pass"=>"string",
				"vici_user"=>"integer",
				"is_active"=>"string",
				"last_balance"=>"double",
				"balance"=>"double",
				"exact_balance"=>"double",
				"ip_address"=>"string",
				"num_lines"=>"integer",
			));
	}

	public function safeDown()
	{
		$this->dropTable("tbl_remote_data_cache");
	}

}