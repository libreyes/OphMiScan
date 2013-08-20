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
<div class="firstPage">
	<?php foreach ($element->files as $scan) {?>
		<img src="<?php echo Yii::app()->createUrl('/file/view/'.$scan->file->id.'/600x800/'.$scan->file->name)?>" />
		<?php break?>
	<?php }?>
</div>
<div class="scan-preview"></div>
<div class="scan-thumbnails view" id="scan-thumbnails-0">
	<?php foreach ($element->files as $i => $scan) {?>
		<?php if ($i >0 && ($i % 6) == 0) {?>
			</div><div class="scan-thumbnails" id="scan-thumbnails-<?php echo $i?>">
		<?php }?>
		<div class="scan-thumbnail">
			<div class="scan-thumbnail-image" style="background-image:url('<?php echo Yii::app()->createUrl('/file/view/'.$scan->file->id.'/200_60x60/'.$scan->file->name)?>');" data-id="<?php echo $scan->id?>" data-attr-preview-link="<?php echo Yii::app()->createUrl('/file/view/'.$scan->file->id.'/600x800/'.$scan->file->name)?>"></div>
			<div class="scan-thumbnail-date">
				<?php echo date('j M Y H:i',strtotime($scan->created_date))?>
			</div>
			<div>
				<?php echo $scan->category ? $scan->category->name : 'No category'?>
			</div>
			<div>
				<?php echo CHtml::link('Download',$scan->file->getDownloadURL())?>
			</div>
		</div>
	<?php }?>
</div>
<script type="text/javascript">
	$('div.scan-thumbnail-image').click(function(e) {
		e.preventDefault();

		var url = $(this).attr('data-attr-preview-link');

		new OpenEyes.Dialog({
			content: '<img src="'+url+'" />',
			width: 600,
			position: 'top',
			dialogClass: 'dialog pdf-preview',
		}).open();
	});
</script>
