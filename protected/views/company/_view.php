<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->companyid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo CHtml::image('images/'.$model->leftlogofile);?></span>
<span class="cell"><?php echo CHtml::image('images/'.$model->rightlogofile);?></span>
</div>
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->companyid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Company</span>
    <span class="cell"><?php echo $model->companyname;?></span>
	<span class="cell">Address</span>
    <span class="cell"><?php echo $model->address;?></span>
</div>
<div class="rowdata">
	<span class="cell">City</span>
    <span class="cell"><?php echo $model->city;?></span>
	<span class="cell">Zip Code</span>
    <span class="cell"><?php echo $model->zipcode;?></span>
</div>
<div class="rowdata">
	<span class="cell">Fax No</span>
    <span class="cell"><?php echo $model->faxno;?></span>
	<span class="cell">Phone No</span>
    <span class="cell"><?php echo $model->phoneno;?></span>
</div>
<div class="rowdata">
	<span class="cell">Web Address</span>
    <span class="cell"><?php echo $model->webaddress;?></span>
	<span class="cell">Email</span>
    <span class="cell"><?php echo $model->email;?></span>
</div>
<div class="rowdata">
	<span class="cell">Tax No</span>
    <span class="cell"><?php echo $model->taxno;?></span>
	<span class="cell">Base Currency</span>
    <span class="cell"><?php echo ($model->currency!==null?$model->currency->currencyname:"");?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cell"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>