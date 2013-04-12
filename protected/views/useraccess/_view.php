<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->useraccessid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->useraccessid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Real Name</span>
    <span class="cell"><?php echo $model->realname;?></span>
</div>
<div class="rowdata">
	<span class="cell">User Name</span>
    <span class="cell"><?php echo $model->username;?></span>
</div>
<div class="rowdata">
	<span class="cell">Language</span>
    <span class="cell"><?php echo ($model->language!==null)?$model->language->languagename:"";?></span>
</div>
<div class="rowdata">
	<span class="cell">Theme</span>
    <span class="cell"><?php echo $model->theme?></span>
</div>
<div class="rowdata">
	<span class="cell">Background</span>
    <span class="cell"><?php echo $model->background?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cell"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>