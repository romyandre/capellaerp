<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->usergroupid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->usergroupid;?></span>
</div>
<div class="rowdata">
	<span class="cell">User Name</span>
    <span class="cellcontent"><?php echo ($model->useraccess!==null)?$model->useraccess->username:"";?></span>
</div>
<div class="rowdata">
	<span class="cell">Group Name</span>
    <span class="cellcontent"><?php echo ($model->groupaccess!==null)?$model->groupaccess->groupname:"";?></span>
</div>
</div>