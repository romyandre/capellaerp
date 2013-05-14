<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','id'=>$model->poheaderid,
	'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->poheaderid;?></span>
</div>
<div class="rowdata">
	<span class="cell">PO No</span>
    <span class="cell"><?php echo $model->pono;?></span>
</div>
<div class="rowdata">
	<span class="cell">PO Date</span>
    <span class="cell"><?php echo $model->docdate;?></span>
</div>
<div class="rowdata">
	<span class="cell">Supplier</span>
    <span class="cell"><?php echo ($model->supplier!==null)?$model->supplier->fullname:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Payment Method</span>
    <span class="cell"><?php echo ($model->paymentmethod!==null)?$model->paymentmethod->paycode:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Header Note</span>
    <span class="cell"><?php echo $model->headernote;?></span>
</div>
<div class="rowdata">
	<span class="cell">Print</span>
    <span class="cell"><?php echo $model->printke;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cellcontent"><?php echo Wfstatus::model()->findstatusname("appda",$model->recordstatus);?></span>
</div>
<div class="rowdata">
<span class="cell">Detail</span>
<span class="cellcontent">
<div id='tabledetail'>
<?php $customeraddress = Podetail::model()->findallbyattributes(array('poheaderid'=>$model->poheaderid)); 
echo "<div class='rowheader'>";
 echo "<span class='celldetail'>Material Master / Service</span>";
 echo "<span class='celldetail'>Qty</span>";
 echo "<span class='celldetail'>Price</span>";
 echo "<span class='celldetail'>Rate</span>";
 echo "<span class='celldetail'>Tax</span>";
 echo "<span class='celldetail'>Total</span>";
 echo "<span class='celldetail'>Qty Res</span>";
 echo "<span class='celldetail'>Item Text</span>";
 echo "</div>";

foreach ($customeraddress as $sa)
{
 echo "<div class='rowdetail'>";
 echo "<span class='celldetail'>".$sa->product->productname."</span>";
 echo "<span class='celldetailnumeric'>".$sa->poqty.$sa->unitofmeasure->uomcode."</span>";
 echo "<span class='celldetailnumeric'>".Company::model()->getsymbol().$sa->netprice."</span>";
 echo "<span class='celldetailnumeric'>".$sa->currency->symbol.$sa->ratevalue."</span>";
 echo "<span class='celldetailnumeric'>".$sa->currency->symbol.$sa->taxvalue."</span>";
 echo "<span class='celldetailnumeric'>".Company::model()->getsymbol().$sa->subtotal."</span>";
 echo "<span class='celldetailnumeric'>".$sa->qtyres.$sa->unitofmeasure->uomcode."</span>";
 echo "<span class='celldetail'>".$sa->itemtext."</span>";
 echo "</div>";
}
echo "<div class='rowdetail'>";
 echo "<span class='celldetail'>Total</span>";
 echo "<span class='celldetailnumeric'></span>";
 echo "<span class='celldetailnumeric'></span>";
 echo "<span class='celldetailnumeric'></span>";
 echo "<span class='celldetailnumeric'></span>";
 echo "<span class='celldetailnumeric'>".Company::model()->getsymbol().$sa->getTotals()."</span>";
 echo "<span class='celldetailnumeric'></span>";
 echo "<span class='celldetail'></span>";
 echo "</div>";
?>
</div>
</span>
</div>
</div>