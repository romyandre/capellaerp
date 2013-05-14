<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->subdistrictid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->subdistrictid;?></span>
</div>
<div class="rowdata">
	<span class="cell">City</span>
    <span class="cellcontent"><?php echo ($model->city!==null)?$model->city->cityname:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Subdistrict</span>
    <span class="cellcontent"><?php echo $model->subdistrictname;?></span>

</div>
<div class="rowdata">
	<span class="cell">Zip Code</span>
    <span class="cellcontent"><?php echo $model->zipcode;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cellcontent"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>