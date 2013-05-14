<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->slocid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->slocid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Plant</span>
    <span class="cellcontent"><?php echo ($model->plant!==null)?$model->plant->plantcode:'';?> - <?php echo ($model->plant!==null)?$model->plant->description:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Sloc Code</span>
    <span class="cellcontent"><?php echo $model->sloccode;?></span>
</div>
<div class="rowdata">
	<span class="cell">Description</span>
    <span class="cellcontent"><?php echo $model->description;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cellcontent"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>