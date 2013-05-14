<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->identitytypeid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->identitytypeid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Identity Type</span>
    <span class="cellcontent"><?php echo $model->identitytypename;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cellcontent"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>