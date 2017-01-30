<?php

class m170130_100851_credits_used_logs extends CDbMigration
{
	public function safeUp()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
		    // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
		    $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		
		}
		$this->createTable('credits_used_logs', [
		    'id' => $this->primaryKey(),
		    'id' => 'double',		    
			'log_date' => 'datetime',
		], $tableOptions);
	}

	public function safeDown()
	{
		$this->dropTable("credits_used_logs");
	}

}