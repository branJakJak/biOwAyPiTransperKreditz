<?php

class m150910_104447_create_transaction_log extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable("tbl_transaction_log",array(
				"id"=>"pk",
				"freevoip_account"=>"integer",
				"to_username"=>"string not null",
				"amount"=>"string not null",
				"pincode"=>"string not null",
				"date_created"=>"datetime",
				"date_updated"=>"datetime",
			),'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
	}

	public function safeDown()
	{
		$this->dropTable("tbl_transaction_log");
	}
}