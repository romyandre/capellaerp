<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->romawiid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->romawiid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Month Calendar</span>
    <span class="cell"><?php echo $model->monthcal;?></span>
</div>
<div class="rowdata">
	<span class="cell">Month Rome</span>
    <span class="cell"><?php echo $model->monthrm;?></span>
</div>
</div>