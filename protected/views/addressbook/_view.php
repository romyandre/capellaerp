<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->addressbookid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->addressbookid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Full Name</span>
    <span class="cellcontent"><?php echo $model->fullname;?></span>
</div>
<div class="rowdata">
		<span class="cell">Is Customer</span>
		<span class="cellcontent"><?php echo ($model->iscustomer=='1')?'V':''; ?></span>
	</div>

	<div class="rowdata">
		<span class="cell">Is Employee</span>
		<span class="cellcontent"><?php echo ($model->isemployee=='1')?'V':''; ?></span>
	</div>

	<div class="rowdata">
		<span class="cell">Is Applicant</span>
		<span class="cellcontent"><?php echo ($model->isapplicant=='1')?'V':''; ?></span>
	</div>

	<div class="rowdata">
		<span class="cell">Is Vendor</span>
		<span class="cellcontent"><?php echo ($model->isvendor=='1')?'V':''; ?></span>
	</div>

	<div class="rowdata">
		<span class="cell">Is Insurance</span>
		<span class="cellcontent"><?php echo($model->isinsurance=='1')?'V':''; ?></span>
	</div>

	<div class="rowdata">
		<span class="cell">Is Bank</span>
		<span class="cellcontent"><?php echo ($model->isbank=='1')?'V':''; ?></span>
	</div>

	<div class="rowdata">
		<span class="cell">Is Hospital</span>
		<span class="cellcontent"><?php echo ($model->ishospital=='1')?'V':''; ?></span>
	</div>

		<div class="rowdata">
		<span class="cell">Is Catering</span>
		<span class="cellcontent"><?php echo ($model->iscatering=='1')?'V':''; ?></span>
	</div>

    	<div class="rowdata">
		<span class="cell">Tax No</span>
		<span class="cellcontent"><?php echo $model->taxno; ?></span>
	</div>

<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cellcontent"><?php echo ($model->recordstatus==1)?Catalogsys::model()->getcatalog("active"):Catalogsys::model()->getcatalog("notactive");?></span>
</div>
</div>