<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->addresstypeid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->addresstypeid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Address Type</span>
    <span class="cellcontent"><?php echo $model->addresstypename;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cellcontent"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>