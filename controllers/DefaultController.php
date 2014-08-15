<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2012
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2012, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

class DefaultController extends BaseEventTypeController {
	static protected $action_types = array(
		'deleteScan' => self::ACTION_TYPE_FORM,
		'scans' => self::ACTION_TYPE_FORM,
	);

	public function accessRules()
	{
		return array_merge(array(
				array('allow',
					'actions' => array('deleteScan'),
				)
			),
			parent::accessRules()
		);
	}

	public function actionCreate()
	{
		if (!empty($_FILES['upload_field']['tmp_name'])) {
			return $this->handleFileUpload();
		}

		parent::actionCreate();
	}

	public function actionUpdate($id)
	{
		if (!empty($_FILES['upload_field']['tmp_name'])) {
			return $this->handleFileUpload();
		}

		parent::actionUpdate($id);
	}

	public function handleFileUpload()
	{
		if ($_FILES['upload_field']['error'] == 0) {
			if (!in_array($_FILES['upload_field']['type'],Yii::app()->params['OphMiScan_allowed_filetypes'])) {
				echo json_encode(array(
					'status' => 'error',
					'message' => 'This file type is not supported.',
				));
				return;
			}

			$scan = ProtectedFile::createFromFile($_FILES['upload_field']['tmp_name'], $_FILES['upload_field']['name']);

			if (!$scan->save()) {
				echo json_encode(array(
					'status' => 'error',
					'message' => 'Unable to save uploaded file: '.print_r($scan->getErrors(),true),
				));
				return;
			}

			$scannedFile = new OphMiScan_Document_Scan;
			$scannedFile->protected_file_id = $scan->id;

			if (!$scannedFile->save()) {
				echo json_encode(array(
					'status' => 'error',
					'message' => 'Unable to save uploaded file: '.print_r($scannedFile->getErrors(),true),
				));
			} else {

				// Generate thumbnail and preview images
				$scan->getThumbnail("600x800");
				$scan->getThumbnail("200_160x160");

				echo json_encode(array(
					'status' => 'success',
					'id' => $scan->id,
				));
			}
		} else {
			$error = 'Unknown error';

			switch ($_FILES['upload_field']['error']) {
				case UPLOAD_ERR_OK:
					break;
				case UPLOAD_ERR_NO_FILE:
					$error = 'No file sent';
					break;
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					$error = 'Filesize limit exceeded';
					break;
			}

			echo json_encode(array(
				'status' => 'error',
				'message' => $error,
			));
		}

		return;
	}

	public function actionDeleteScan()
	{
		if ($scan = OphMiScan_Document_Scan::model()->findByPk($_POST['scan_id'])) {
			if (!$scan->delete()) {
				echo "0";
				return;
			}

			echo "1";
		}
	}

	public function actionScans()
	{
		if (!empty($_POST['event_id']) ) {
			$element = Element_OphMiScan_Document::model()->find('event_id=?',array($_POST['event_id']));
			if(is_null($element)){
				$element = Element_OphMiScan_Document::model();
			}
		} else {
			$element = new Element_OphMiScan_Document;
		}

		$element->upload_count = $_POST['upload_count'];

		$this->renderPartial('_filepicker',array(
			'mode' => 'edit',
			'identifier' => 'scans',
			'element' => $element,
			'dragsort' => true,
			'filetypes' => array(
				'application/pdf',
			),
		));
	}
}
