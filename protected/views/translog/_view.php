<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','id'=>$model->translogid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->translogid;?></span>
</div>
<div class="rowdata">
	<span class="cell">User Name</span>
    <span class="cell"><?php echo $model->username;?></span>
	<span class="cell">Created Date</span>
    <span class="cell"><?php echo $model->createddate;?></span>
</div>
<div class="rowdata">
	<span class="cell">Old Data</span>
    <span class="cell"><?php echo $model->olddata;?></span>
	<span class="cell">New Data</span>
    <span class="cell"><?php echo $model->newdata;?></span>
</div>
</div>