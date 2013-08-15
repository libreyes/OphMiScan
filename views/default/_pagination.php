<?php
$pages = ceil(OphMiScan_Scanned_File::model()->count('used=?',array(0)) / 18);
?>
<div class="pagination">
	<span class="prev">&laquo; back</span>
	&nbsp;&nbsp;
	<span class="page">1</span>
	&nbsp;&nbsp;
	<?php for ($i=2; $i<=$pages; $i++) {?>
		<a href="#" class="page" data-attr-page="<?php echo $i?>"><?php echo $i?></a>
		&nbsp;&nbsp;
	<?php }?>
	<a href="#" class="next">next &raquo;</a>
</div>
