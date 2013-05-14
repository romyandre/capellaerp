<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->wfstatusid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->wfstatusid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Workflow Name</span>
    <span class="cellcontent"><?php echo ($model->workflow!==null)?$model->workflow->wfname:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Workflow Description</span>
    <span class="cellcontent"><?php echo ($model->workflow!==null)?$model->workflow->wfdesc:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Workflow Status Value</span>
    <span class="cellcontent"><?php echo $model->wfstat;?></span>
</div>
<div class="rowdata">
	<span class="cell">Workflow Status Text</span>
    <span class="cellcontent"><?php echo $model->wfstatusname;?></span>
</div>
</div>