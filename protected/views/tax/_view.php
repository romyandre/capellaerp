<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->taxid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->taxid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Tax Code</span>
    <span class="cell"><?php echo $model->taxcode;?></span>
</div>
<div class="rowdata">
	<span class="cell">Tax Value</span>
    <span class="cell"><?php echo $model->taxvalue;?></span>
</div>
<div class="rowdata">
	<span class="cell">Description</span>
    <span class="cell"><?php echo $model->description;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cell"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>