<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->accounttypeid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->accounttypeid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Account Type</span>
    <span class="cellcontent"><?php echo $model->accounttypename;?></span>
</div>
<div class="rowdata">
	<span class="cell">Parent Account Type</span>
    <span class="cellcontent"><?php echo ($model->parentaccounttype!==null)?$model->parentaccounttype->accounttypename:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cellcontent"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>