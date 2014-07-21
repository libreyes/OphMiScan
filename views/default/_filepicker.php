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
<div class="scan-preview"></div>
<div class="to-delete"></div>
<div class="scans panel">
	<?php if (empty($element->scans)) {?>
		<div>
			There are no scanned documents available in the scan directory.
		</div>
	<?php } else {
		echo $this->renderPartial('../default/_pagination',array(
			'pages' => ceil(count($element->scans) / Yii::app()->params['OphMiScan_thumbnails_per_page']),
			'class' => 'edit top',
		));
		for ($i=0; $i<ceil(count($element->scans)/Yii::app()->params['OphMiScan_thumbnails_per_page']); $i++) {
			$this->renderPartial('../default/_scans_page',array(
				'element' => $element,
				'page' => $i,
			));
		}
		echo $this->renderPartial('../default/_pagination',array(
			'pages' => ceil(count($element->scans) / Yii::app()->params['OphMiScan_thumbnails_per_page']),
			'class' => 'edit bottom',
		))?>
	<?php }?>
</div>
<div id="confirm-delete-scan" title="Confirm delete scan" style="display: none;">
	<div class="row field-row">
		<div class="large-12 column">
			<div class="alertBox" style="margin-top: 10px; margin-bottom: 15px;">
				<strong>WARNING: This will permanently delete the scanned document.</strong>
			</div>
			<p>
				<strong>Are you sure you want to proceed?</strong>
			</p>
			<button type="submit" class="secondary small">Delete scan</button>
			<button type="submit" class="small warning">Cancel</button>
			<img class="loader" src="<?php echo Yii::app()->createUrl('img/ajax-loader.gif')?>" alt="loading..." style="display: none;" />
			<input type="hidden" id="delete_scan_id" name="delete_scan_id" value="" />
		</div>
	</div>
</div>
