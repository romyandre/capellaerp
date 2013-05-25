<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->snroid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->snroid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Description</span>
    <span class="cellcontent"><?php echo $model->description;?></span>
</div>
<div class="rowdata">
	<span class="cell">Format Doc</span>
    <span class="cellcontent"><?php echo $model->formatdoc;?></span>
</div>
<div class="rowdata">
	<span class="cell">Format No</span>
    <span class="cellcontent"><?php echo $model->formatno;?></span>
</div>
<div class="rowdata">
	<span class="cell">Repeat By</span>
    <span class="cellcontent"><?php echo $model->repeatby;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cellcontent"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>