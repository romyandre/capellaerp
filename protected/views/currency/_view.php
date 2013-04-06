<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->currencyid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->currencyid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Country</span>
    <span class="cell"><?php echo ($model->country!==null)?$model->country->countryname:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Currency</span>
    <span class="cell"><?php echo $model->currencyname;?></span>
</div>
<div class="rowdata">
	<span class="cell">Symbol</span>
    <span class="cell"><?php echo $model->symbol;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cell"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>