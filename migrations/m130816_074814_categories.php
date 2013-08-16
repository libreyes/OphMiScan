<?php

class m130816_074814_categories extends CDbMigration
{
	public function up()
	{
		$this->insert('ophmiscan_document_category',array('name'=>'Humphreys'));
		$this->insert('ophmiscan_document_category',array('name'=>'Letter'));
		$this->insert('ophmiscan_document_category',array('name'=>'Fundus'));
		$this->insert('ophmiscan_document_category',array('name'=>'Consent form'));
	}

	public function down()
	{
		$this->delete('ophmiscan_document_category');
	}
}
