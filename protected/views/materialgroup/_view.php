<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->materialgroupid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->materialgroupid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Material Group Code</span>
    <span class="cell"><?php echo $model->materialgroupcode;?></span>
	<span class="cell">Description</span>
    <span class="cell"><?php echo $model->description;?></span>
</div>
<div class="rowdata">
	<span class="cell">Material Type Code</span>
    <span class="cell"><?php echo ($model->materialtype!==null)?$model->materialtype->materialtypecode:'';?></span>
	<span class="cell">Material Type Description</span>
    <span class="cell"><?php ($model->materialtype!==null)?$model->materialtype->description:''?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cell"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>