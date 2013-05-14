<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->accountid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->accountid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Account Code</span>
    <span class="cellcontent"><?php echo $model->accountcode;?></span>
</div>
<div class="rowdata">
	<span class="cell">Account Name</span>
    <span class="cellcontent"><?php echo $model->accountname;?></span>
</div>
<div class="rowdata">
	<span class="cell">Parent Account Code</span>
    <span class="cellcontent"><?php echo ($model->parentaccount!==null)?$model->parentaccount->accountcode:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Parent Account Name</span>
    <span class="cellcontent"><?php echo ($model->parentaccount!==null)?$model->parentaccount->accountname:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Account Type</span>
    <span class="cellcontent"><?php echo ($model->accounttype!==null)?$model->accounttype->accounttypename:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cellcontent"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>