<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'UrlEdit'=>'editdata2','id'=>$model->addresscontactid,
	'isDelete'=>true,'UrlDelete'=>'deletedata2'));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->addresscontactid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Address Contact</span>
    <span class="cell"><?php echo $model->addresscontactname;?></span>
</div>
<div class="rowdata">
	<span class="cell">Contact Type</span>
    <span class="cell"><?php echo ($model->contacttype!==null)?$model->contacttype->contacttypename:''?></span>
</div>
<div class="rowdata">
	<span class="cell">Phone No</span>
    <span class="cell"><?php echo $model->phoneno?></span>
</div>
<div class="rowdata">
	<span class="cell">Mobile Phone</span>
    <span class="cell"><?php echo $model->mobilephone?></span>
</div>
<div class="rowdata">
	<span class="cell">Email Address</span>
    <span class="cell"><?php echo $model->emailaddress?></span>
</div>
</div>

