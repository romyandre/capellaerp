<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->groupmenuid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->groupmenuid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Group Access</span>
    <span class="cell"><?php echo ($model->groupaccess!==null)?$model->groupaccess->groupname:"";?></span>
</div>
<div class="rowdata">
	<span class="cell">Menu Access</span>
    <span class="cell"><?php echo ($model->menuaccess!==null)?$model->menuaccess->menuname:"";?></span>
</div>
<div class="rowdata">
	<span class="cell">Menu Description</span>
    <span class="cell"><?php echo ($model->menuaccess!==null)?$model->menuaccess->description:"";?></span>
</div>
<div class="rowdata">
	<span class="cell">Is Read</span>
    <span class="cell"><?php echo ($model->isread==1)?"V":"X" ?></span>
	<span class="cell">Is Write</span>
    <span class="cell"><?php echo ($model->iswrite==1)?"V":"X" ?></span>
</div>
<div class="rowdata">
	<span class="cell">Is Post</span>
    <span class="cell"><?php echo ($model->ispost==1)?"V":"X" ?></span>
	<span class="cell">Is Reject</span>
    <span class="cell"><?php echo ($model->isreject==1)?"V":"X" ?></span>
</div>
<div class="rowdata">
	<span class="cell">Is Download</span>
    <span class="cell"><?php echo ($model->isdownload==1)?"V":"X" ?></span>
	<span class="cell">Is Upload</span>
    <span class="cell"><?php echo ($model->isupload==1)?"V":"X" ?></span>
</div>
</div>