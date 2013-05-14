<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->purchinforecid,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->purchinforecid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Supplier</span>
    <span class="cell"><?php echo ($model->addressbook!==null)?$model->addressbook->fullname:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Material Master / Service</span>
    <span class="cell"><?php echo ($model->product!==null)?$model->product->productname:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Bid / Buy Date</span>
    <span class="cell"><?php echo $model->biddate;?></span>
</div>
<div class="rowdata">
	<span class="cell">Price</span>
    <span class="cell"><?php echo (($model->currency!==null)?$model->currency->symbol:'').$model->price;?></span>
</div>
<div class="rowdata">
	<span class="cell">Delivery Tolerance</span>
    <span class="cell"><?php echo $model->underdelvtol.'-'.$model->overdelvtol;?></span>
</div>
</div>