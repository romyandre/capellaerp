<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->productid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->productid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Product</span>
    <span class="cellcontent"><?php echo $model->productname;?></span>
</div>
<div class="rowdata">
	<span class="cell">Is Stock</span>
    <span class="cellcontent"><?php echo ($model->isstock==1)?Catalogsys::model()->getcatalog("stock"):Catalogsys::model()->getcatalog("notstock");?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cellcontent"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>