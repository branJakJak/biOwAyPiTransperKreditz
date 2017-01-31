<?php

class m170130_100851_credits_used_logs extends CDbMigration
{
	public function safeUp()
	{
		$tableOptions = null;
        $this->createTable("credits_used_logs",array(
            "id"=>"pk",
		    'credit_used' => 'double',		    
			'log_date' => 'datetime',
        ),'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

	}

	public function safeDown()
	{
		$this->dropTable("credits_used_logs");
	}

}