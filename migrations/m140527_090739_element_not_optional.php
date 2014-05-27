<?php

class m140527_090739_element_not_optional extends CDbMigration
{
	public function up()
	{
		$this->update('element_type',array('required'=>1),"class_name = 'Element_OphMiScan_Document'");
	}

	public function down()
	{
		$this->update('element_type',array('required'=>null),"class_name = 'Element_OphMiScan_Document'");
	}
}
