<?php

class m161128_104239_create_scheduled_force_agent extends CDbMigration
{
	public function up()
	{
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		$this->createTable('scheduled_force_agent', [
		    'id' => 'pk',
		    'scheduled_date'=>'datetime',
		    'account_id'=>'integer',
		    'topup_amount'=>'double',
		    'activate'=>'boolean',
			'created_at' => 'datetime',
		    'updated_at' => 'datetime',
		], $tableOptions);
	}

	public function down()
	{
        $this->dropTable('scheduled_force_agent');
	}

}