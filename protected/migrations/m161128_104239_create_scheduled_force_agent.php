<?php

class m161128_104239_create_scheduled_force_agent extends CDbMigration
{
	public function up()
	{
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		$this->createTable('scheduled_force_agent', [
		    'id' => 'pk',
		    'scheduled_date'=>'datetime',
		    'account_id'=>'int',
		    'topup_amount'=>'double',
		    'activate'=>'boolean',
			'created_at' => 'datetime',
		    'updated_at' => 'datetime',
		], $tableOptions);
		$this->addForeignKey("scheduled_force_agent_fk",'scheduled_force_agent','account_id','tbl_remote_data_cache','id','CASCADE','CASCADE');
	}

	public function down()
	{
        $this->dropForeignKey("scheduled_force_agent_fk", 'scheduled_force_agent');
        $this->dropTable('scheduled_force_agent');
	}

}