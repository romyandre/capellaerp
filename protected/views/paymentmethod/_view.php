<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->paymentmethodid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->paymentmethodid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Payment Code</span>
    <span class="cell"><?php echo $model->paycode;?></span>
</div>
<div class="rowdata">
	<span class="cell">Pay Days</span>
    <span class="cell"><?php echo $model->paydays;?></span>
</div>
<div class="rowdata">
	<span class="cell">Payment Name</span>
    <span class="cell"><?php echo $model->paymentname;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cell"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>