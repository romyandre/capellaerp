<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->kelurahanid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->kelurahanid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Sub Subdistrict</span>
    <span class="cell"><?php echo $model->kelurahanname;?></span>
</div>
<div class="rowdata">
	<span class="cell">Subdistrict</span>
    <span class="cell"><?php echo ($model->subdistrict!==null)?$model->subdistrict->subdistrictname:'';?></span>
</div>

<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cell"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>