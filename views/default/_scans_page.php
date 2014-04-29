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
?>
	<div class="page" data-page="<?php echo $page?>"<?php if ($page >0) {?> style="display: none"<?php }?>>
		<?php foreach ($element->scans as $i => $scan) {
			if ($i >= ($page * Yii::app()->params['OphMiScan_thumbnails_per_page']) && $i < (($page + 1) * Yii::app()->params['OphMiScan_thumbnails_per_page'])) {
				if ($i >0 && $i/6 == $page * Yii::app()->params['OphMiScan_thumbnails_per_page']) {?>
					</div>
					<div class="row field-row">
				<?php }else if ($i == $page * Yii::app()->params['OphMiScan_thumbnails_per_page']) {?>
					<div class="row field-row">
				<?php }?>
					<div class="large-2 column<?php if (($i+1)/6 == 0 || ($i+1 >= count($element->scans))) {?> end<?php }?>" data-attr-preview-link="<?php echo Yii::app()->createUrl('/file/view/'.$scan->file->id.'/600x800/'.$scan->file->name)?>">
						<div class="thumbnail">
							<div class="thumbnail-image<?php if ($element->isSelected($scan->id)) {?> selected<?php }?>">
								<img class="thumbnail-loader" src="<?php echo Yii::app()->assetManager->createUrl('img/ajax-loader.gif')?>" />
								<img class="thumbnail" src="<?php echo Yii::app()->createUrl('/file/view/'.$scan->file->id.'/200_160x160/'.$scan->file->name)?>" data-attr-preview-link="<?php echo Yii::app()->createUrl('/file/view/'.$scan->file->id.'/600x800/'.$scan->file->name)?>" style="display: none" />
								<input type="hidden" name="scans[]" value="<?php echo $scan->id?>"<?php if (!$element->isSelected($scan->id)) {?> disabled="disabled"<?php }?> />
							</div>
						</div>
						<?php echo CHtml::dropDownList('category_id[]',(!empty($_POST) ? @$_POST['category_id'][$i] : $scan->category_id),CHtml::listData(OphMiScan_Document_Category::model()->findAll(array('order'=>'name')),'id','name'),array('empty'=>'- No category -','disabled'=>!$element->isSelected($scan->id),'class' => 'category'))?>
						<button type="submit" class="small btn-view">View</button>
						<button type="submit" class="warning small btn-delete">Delete</button>
					</div>
				<?php }
			}?>
		</div>
	</div>
