<?php

class m160428_114224_create_force_agent_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable("tbl_force_agent_table",array(
				'id'=>'pk',
				'force_agent_lbl'=>'string not null',
				'force_agent_value'=>'string not null',
				'date_created'=>'datetime',
				'date_updated'=>'datetime',
			));
		$this->insert("tbl_force_agent_table",array(
				'force_agent_lbl'=>"VBpi8",
				'force_agent_value'=>"Injury Campaign",
				'date_created'=>date("Y-m-d H:i:s"),
				'date_updated'=>date("Y-m-d H:i:s"),
			));

		$this->insert("tbl_force_agent_table",array(
			'force_agent_lbl'=>"PBAVB6",
			'force_agent_value'=>"PBA Campaign",
			'date_created'=>date("Y-m-d H:i:s"),
			'date_updated'=>date("Y-m-d H:i:s"),
			));

		$this->insert("tbl_force_agent_table",array(
			'force_agent_lbl'=>"LIFEbz",
			'force_agent_value'=>"LIFE",
			'date_created'=>date("Y-m-d H:i:s"),
			'date_updated'=>date("Y-m-d H:i:s"),
			));
		$this->insert("tbl_force_agent_table",array(
			'force_agent_lbl'=>"VBInjury",
			'force_agent_value'=>"Injury TEST",
			'date_created'=>date("Y-m-d H:i:s"),
			'date_updated'=>date("Y-m-d H:i:s"),
			));
		$this->insert("tbl_force_agent_table",array(
			'force_agent_lbl'=>"PBATEST",
			'force_agent_value'=>"PBA TEST" ,
			'date_created'=>date("Y-m-d H:i:s"),
			'date_updated'=>date("Y-m-d H:i:s"),
			));
		$this->insert("tbl_force_agent_table",array(
			'force_agent_lbl'=>"PiFORM",
			'force_agent_value'=>"Injury Form",
			'date_created'=>date("Y-m-d H:i:s"),
			'date_updated'=>date("Y-m-d H:i:s"),
			));
		$this->insert("tbl_force_agent_table",array(
			'force_agent_lbl'=>"PBAFORM",
			'force_agent_value'=>"PBA Form",
			'date_created'=>date("Y-m-d H:i:s"),
			'date_updated'=>date("Y-m-d H:i:s"),
			));
		$this->insert("tbl_force_agent_table",array(
			'force_agent_lbl'=>"DELAY8",
			'force_agent_value'=>"DELAY8",
			'date_created'=>date("Y-m-d H:i:s"),
			'date_updated'=>date("Y-m-d H:i:s"),
			));
	}

	public function safeDown()
	{
		$this->dropTable("tbl_force_agent_table");
	}
}