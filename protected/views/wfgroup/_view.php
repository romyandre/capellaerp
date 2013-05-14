<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->wfgroupid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->wfgroupid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Workflow</span>
    <span class="cellcontent"><?php echo ($model->workflow!==null)?$model->workflow->wfname:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Group Access</span>
    <span class="cellcontent"><?php echo ($model->groupaccess!==null)?$model->groupaccess->groupname:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Before Status</span>
    <span class="cellcontent"><?php echo $model->wfbefstat;?></span>
</div>
<div class="rowdata">
	<span class="cell">After Status</span>
    <span class="cellcontent"><?php echo $model->wfrecstat;?></span>
</div>
</div>