<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'UrlEdit'=>'editdata1','id'=>$model->addressid,
	'isDelete'=>true,'UrlDelete'=>'deletedata1'));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->addressid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Address Name</span>
    <span class="cell"><?php echo $model->addressname;?></span>
</div>
<div class="rowdata">
	<span class="cell">Address Type</span>
    <span class="cell"><?php echo ($model->addresstype!==null)?$model->addresstype->addresstypename:''?></span>
</div>

</div>

