<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->productbasicid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->productbasicid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Material / Service</span>
    <span class="cellcontent"><?php echo ($model->product!==null)?$model->product->productname:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Base UOM</span>
    <span class="cellcontent"><?php echo ($model->baseuom0!==null)?$model->baseuom0->description:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Material Group</span>
    <span class="cellcontent"><?php echo ($model->materialgroup!==null)?$model->materialgroup->description:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Weight Unit</span>
    <span class="cellcontent"><?php echo ($model->baseuom1!==null)?$model->baseuom1->description:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cellcontent"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>