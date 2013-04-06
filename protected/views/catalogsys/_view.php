<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->catalogsysid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->catalogsysid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Language</span>
    <span class="cell"><?php echo ($model->language!==null)?$model->language->languagename:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Messages</span>
    <span class="cell"><?php echo ($model->messages!==null)?$model->messages->messagename:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Catalog Value</span>
    <span class="cell"><?php echo $model->catalogval;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cell"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>