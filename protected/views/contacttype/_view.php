<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->contacttypeid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->contacttypeid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Contact Type Name</span>
    <span class="cellcontent"><?php echo $model->contacttypename;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cellcontent"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>