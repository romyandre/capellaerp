<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->productaccountid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->productaccountid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Material / Service</span>
    <span class="cellcontent"><?php echo ($model->product!==null)?$model->product->productname:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Expense Account</span>
    <span class="cellcontent"><?php echo (($model->expenseaccount0!==null)?$model->expenseaccount0->accountcode.'-'.$model->expenseaccount0->accountname:'');?></span>
</div>
<div class="rowdata">
	<span class="cell">Sales Account</span>
    <span class="cellcontent"><?php echo (($model->salesaccount0!==null)?$model->salesaccount0->accountcode.'-'.$model->expenseaccount0->accountname:'');?></span>
</div>
<div class="rowdata">
	<span class="cell">Sales Return Account</span>
    <span class="cellcontent"><?php echo (($model->salesretaccount0!==null)?$model->salesretaccount0->accountcode.'-'.$model->expenseaccount0->accountname:'');?></span>
</div>
<div class="rowdata">
	<span class="cell">Sales Item Account</span>
    <span class="cellcontent"><?php echo (($model->salesitemaccount0!==null)?$model->salesitemaccount0->accountcode.'-'.$model->expenseaccount0->accountname:'');?></span>
</div>
<div class="rowdata">
	<span class="cell">Purchasing Return Account</span>
    <span class="cellcontent"><?php echo (($model->purcretaccount0!==null)?$model->purcretaccount0->accountcode.'-'.$model->expenseaccount0->accountname:'');?></span>
</div>
<div class="rowdata">
	<span class="cell">Unbilled Account</span>
    <span class="cellcontent"><?php echo (($model->unbilledaccount0!==null)?$model->unbilledaccount0->accountcode.'-'.$model->expenseaccount0->accountname:'');?></span>
</div>
<div class="rowdata">
	<span class="cell">Is Activa</span>
    <span class="cellcontent"><?php echo ($model->isactiva==1)?Catalogsys::model()->getcatalog("activa"):Catalogsys::model()->getcatalog("notactiva");?></span>
</div>
</div>