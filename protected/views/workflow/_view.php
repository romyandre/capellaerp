<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->workflowid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->workflowid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Description</span>
    <span class="cell"><?php echo $model->wfdesc;?></span>
	<span class="cell">Workflow</span>
    <span class="cell"><?php echo $model->wfname;?></span>
</div>
<div class="rowdata">
	<span class="cell">Min Status</span>
    <span class="cell"><?php echo $model->wfminstat;?></span>
	<span class="cell">Max Status</span>
    <span class="cell"><?php echo $model->wfmaxstat;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cell"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>