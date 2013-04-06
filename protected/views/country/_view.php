<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->countryid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->countryid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Country Code</span>
    <span class="cell"><?php echo $model->countrycode;?></span>
</div>
<div class="rowdata">
	<span class="cell">Country Name</span>
    <span class="cell"><?php echo $model->countryname;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cell"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>