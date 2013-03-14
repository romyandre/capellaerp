<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->snrodetid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->snrodetid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Description</span>
    <span class="cell"><?php echo $model->description;?></span>
	<span class="cell">Current Day</span>
    <span class="cell"><?php echo $model->curdd;?></span>
</div>
<div class="rowdata">
	<span class="cell">Current Month</span>
    <span class="cell"><?php echo $model->curmm;?></span>
	<span class="cell">Current Year</span>
    <span class="cell"><?php echo $model->curyy;?></span>
</div>
<div class="rowdata">
	<span class="cell">Current Value</span>
    <span class="cell"><?php echo $model->curvalue;?></span>
</div>
</div>