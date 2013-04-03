<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->wfgroupid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->wfgroupid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Workflow</span>
    <span class="cell"><?php echo ($model->workflow!==null)?$model->workflow->wfname:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Group Access</span>
    <span class="cell"><?php echo ($model->groupaccess!==null)?$model->groupaccess->groupname:'';?></span>
</div>
</div>