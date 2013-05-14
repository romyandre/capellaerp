<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->parameterid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->parameterid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Parameter Name</span>
    <span class="cellcontent"><?php echo $model->paramname;?></span>
</div>
<div class="rowdata">
	<span class="cell">Parameter Value</span>
    <span class="cellcontent"><?php echo $model->paramvalue;?></span>
</div>
</div>