<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->provinceid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->provinceid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Country</span>
    <span class="cell"><?php echo ($model->country!==null)?$model->country->countryname:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Province</span>
    <span class="cell"><?php echo $model->provincename;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cell"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>