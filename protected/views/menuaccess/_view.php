<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->menuaccessid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->menuaccessid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Menu Code</span>
    <span class="cell"><?php echo $model->menucode;?></span>
</div>
<div class="rowdata">
	<span class="cell">Menu Name</span>
    <span class="cell"><?php echo $model->menuname;?></span>
</div>
<div class="rowdata">
	<span class="cell">Menu Url</span>
    <span class="cell"><?php echo $model->menuurl;?></span>
</div>
<div class="rowdata">
	<span class="cell">Icon</span>
    <span class="cell"><img style="width:24px;height:24px" src="<?php echo Yii::app()->request->baseUrl.'/images/'.$model->menuicon;?>"></span>
</div>
<div class="rowdata">
	<span class="cell">Description</span>
    <span class="cell"><?php echo $model->description;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cell"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>