<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->translockid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->translockid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Locked By</span>
    <span class="cell"><?php echo $model->lockedby;?></span>
	<span class="cell">Locked Date</span>
    <span class="cell"><?php echo $model->lockeddate;?></span>
</div>
<div class="rowdata">
	<span class="cell">Menu ID</span>
    <span class="cell"><?php echo $model->tableid;?></span>
	<span class="cell">Menu Name</span>
    <span class="cell"><?php echo $model->menuname;?></span>
</div>
</div>