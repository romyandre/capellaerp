<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->messagesid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->messagesid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Message</span>
    <span class="cellcontent"><?php echo $model->messagename;?></span>
</div>
<div class="rowdata">
	<span class="cell">Description</span>
    <span class="cellcontent"><?php echo $model->description;?></span>
</div>
</div>