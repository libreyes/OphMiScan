<?php /**
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

/**
 * This is the model class for table "et_ophmiscan_document".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property string $title
 * @property string $description
 *
 * The followings are the available model relations:
 *
 * @property ElementType $element_type
 * @property EventType $eventType
 * @property Event $event
 * @property User $user
 * @property User $usermodified
 */

class Element_OphMiScan_Document extends BaseEventTypeElement
{
	public $service;

	/**
	 * Returns the static model of the specified AR class.
	 * @return the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'et_ophmiscan_document';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, title, description', 'safe'),
			array('title, description', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, event_id, title, description', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array(
			'files' => array(self::HAS_MANY, 'OphMiScan_Document_Scan', 'element_id', 'order' => 'display_order asc'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'event_id' => 'Event',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('event_id', $this->event_id, true);
		
		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}

	public function getIssueText()
	{
		return $this->title;
	}

	protected function afterValidate()
	{
		if (empty($_POST['ProtectedFile'])) {
			$this->addError('ProtectedFile','Please select at least one document to associate with this event');
		}

		return parent::afterValidate();
	}

	public function afterSave()
	{
		foreach ($_POST['ToDelete'] as $scan_id) {
			if ($scan = OphMiScan_Document_Scan::model()->findByPk($scan_id)) {
				if (!$scan->delete()) {
					throw new Exception("Unable to delete document scan: ".print_r($scan->getErrors(),true));
				}
			}
		}

		foreach ($_POST['ProtectedFile'] as $i => $scan_id) {
			if ($scan = OphMiScan_Document_Scan::model()->findByPk($scan_id)) {
				$scan->element_id = $this->id;
				$scan->category_id = $_POST['category_id'][$i];
				$scan->display_order = $i+1;

				if (!$scan->save()) {
					throw new Exception("Unable to save document scan: ".print_r($scan->getErrors(),true));
				}
			}
		}

		$criteria = new CDbCriteria;
		$criteria->addCondition('element_id = :element_id');
		$criteria->params[':element_id'] = $this->id;
		$criteria->addNotInCondition('id',$_POST['ProtectedFile']);

		foreach (OphMiScan_Document_Scan::model()->findAll($criteria) as $scan) {
			$scan->element_id = null;

			if (!$scan->save()) {
				throw new Exception("Unable to save scan: ".print_r($scan->getErrors(),true));
			}
		}

		return parent::afterSave();
	}

	public function getScans() {
		$criteria = new CDbCriteria;
		$criteria->addCondition('element_id is null or element_id = :element_id');
		$criteria->params[':element_id'] = $this->id;
		$criteria->order = 'element_id desc, created_date desc';

		return OphMiScan_Document_Scan::model()->findAll($criteria);
	}

	public function getScansCount() {
		$criteria = new CDbCriteria;
		$criteria->addCondition('element_id is null or element_id = :element_id');
		$criteria->params[':element_id'] = $this->id;

		return OphMiScan_Document_Scan::model()->count($criteria);
	}

	public function isSelected($id) {
		if (!empty($_POST['ProtectedFile'])) {
			return in_array($id,$_POST['ProtectedFile']);
		}

		if ($this->id) {
			return OphMiScan_Document_Scan::model()->find('element_id=? and id=?',array($this->id,$id));
		}
	}
}
?>
