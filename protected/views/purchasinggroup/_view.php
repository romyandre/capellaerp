<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->purchasinggroupid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->purchasinggroupid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Purchasing Group Code</span>
    <span class="cellcontent"><?php echo $model->purchasinggroupcode;?></span>
</div>
<div class="rowdata">
	<span class="cell">Description</span>
    <span class="cellcontent"><?php echo $model->description;?></span>
</div>
<div class="rowdata">
	<span class="cell">Purchasing Organization (code)</span>
    <span class="cellcontent"><?php echo ($model->purchasingorg!==null)?$model->purchasingorg->purchasingorgcode:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Purchasing Organization (description)</span>
    <span class="cellcontent"><?php echo ($model->purchasingorg!==null)?$model->purchasingorg->description:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cellcontent"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>