<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->productplantid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->productplantid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Material / Service</span>
    <span class="cellcontent"><?php echo ($model->product!==null)?$model->product->productname:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Storage Location</span>
    <span class="cellcontent"><?php echo (($model->sloc!==null)?$model->sloc->sloccode:'').'-'.(($model->sloc!==null)?$model->sloc->description:'');?></span>
</div>
<div class="rowdata">
	<span class="cell">SNRO</span>
    <span class="cellcontent"><?php echo (($model->snro!==null)?$model->snro->description:'');?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cellcontent"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>