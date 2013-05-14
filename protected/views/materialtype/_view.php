<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->materialtypeid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->materialtypeid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Material Type Code</span>
    <span class="cellcontent"><?php echo $model->materialtypecode;?></span>
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