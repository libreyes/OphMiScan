<?php 
class m130108_114151_event_type_OphMiScan extends CDbMigration
{
	public function up() {
		if (!$this->dbConnection->createCommand()->select('id')->from('event_type')->where('class_name=:class_name', array(':class_name'=>'OphMiScan'))->queryRow()) {
			$group = $this->dbConnection->createCommand()->select('id')->from('event_group')->where('name=:name',array(':name'=>'Miscellaneous'))->queryRow();
			$this->insert('event_type', array('class_name' => 'OphMiScan', 'name' => 'Scan','event_group_id' => $group['id']));
		}

		$event_type = $this->dbConnection->createCommand()->select('id')->from('event_type')->where('class_name=:class_name', array(':class_name'=>'OphMiScan'))->queryRow();

		if (!$this->dbConnection->createCommand()->select('id')->from('element_type')->where('name=:name and event_type_id=:eventTypeId', array(':name'=>'Document',':eventTypeId'=>$event_type['id']))->queryRow()) {
			$this->insert('element_type', array('name' => 'Document','class_name' => 'Element_OphMiScan_Document', 'event_type_id' => $event_type['id'], 'display_order' => 1));
		}

		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('event_type_id=:eventTypeId and name=:name', array(':eventTypeId'=>$event_type['id'],':name'=>'Document'))->queryRow();

		$this->createTable('ophmiscan_document_category', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophmiscan_document_category_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophmiscan_document_category_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophmiscan_document_category_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophmiscan_document_category_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->createTable('et_ophmiscan_document', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'title' => 'varchar(255) DEFAULT NULL',
				'description' => 'varchar(1024) DEFAULT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophmiscan_document_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophmiscan_document_cui_fk` (`created_user_id`)',
				'KEY `et_ophmiscan_document_ev_fk` (`event_id`)',
				'CONSTRAINT `et_ophmiscan_document_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophmiscan_document_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophmiscan_document_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->createTable('ophmiscan_document_scan', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'element_id' => 'int(10) unsigned NOT NULL',
				'protected_file_id' => 'int(10) unsigned NOT NULL',
				'category_id' => 'int(10) unsigned NOT NULL',
				'title' => 'varchar(255) DEFAULT NULL',
				'description' => 'varchar(1024) DEFAULT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophmiscan_document_scan_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophmiscan_document_scan_cui_fk` (`created_user_id`)',
				'KEY `ophmiscan_document_scan_el_fk` (`element_id`)',
				'KEY `ophmiscan_document_scan_pf_fk` (`protected_file_id`)',
				'CONSTRAINT `ophmiscan_document_scan_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophmiscan_document_scan_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophmiscan_document_scan_el_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophmiscan_document` (`id`)',
				'CONSTRAINT `ophmiscan_document_scan_pf_fk` FOREIGN KEY (`protected_file_id`) REFERENCES `protected_file` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
	}

	public function down() {
		$this->dropTable('ophmiscan_document_scan');
		$this->dropTable('et_ophmiscan_document');
		$this->dropTable('ophmiscan_document_category');

		$event_type = $this->dbConnection->createCommand()->select('id')->from('event_type')->where('class_name=:class_name', array(':class_name'=>'OphMiScan'))->queryRow();

		foreach ($this->dbConnection->createCommand()->select('id')->from('event')->where('event_type_id=:event_type_id', array(':event_type_id'=>$event_type['id']))->queryAll() as $row) {
			$this->delete('audit', 'event_id='.$row['id']);
			$this->delete('event', 'id='.$row['id']);
		}

		$this->delete('element_type', 'event_type_id='.$event_type['id']);
		$this->delete('event_type', 'id='.$event_type['id']);
	}
}
?>
