<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->cityid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->cityid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Province</span>
    <span class="cell"><?php echo ($model->province!==null)?$model->province->provincename:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">City</span>
    <span class="cell"><?php echo $model->cityname;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cell"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>