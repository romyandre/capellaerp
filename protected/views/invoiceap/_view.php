<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->invoiceid,
'isApprove'=>true,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->invoiceid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Invoice No</span>
    <span class="cell"><?php echo $model->invoiceno;?></span>
</div>
<div class="rowdata">
	<span class="cell">Purchase Order No</span>
    <span class="cell"><?php echo ($model->poheader!==null)?$model->poheader->pono:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Amount</span>
    <span class="cell"><?php echo ($model->currency!==null)?$model->currency->symbol:''.$model->amount;?></span>
</div>
<div class="rowdata">
	<span class="cell">Invoice Date</span>
    <span class="cell"><?php echo $model->invoicedate;?></span>
</div>
<div class="rowdata">
	<span class="cell">Header Note</span>
    <span class="cell"><?php echo $model->headernote;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cell"><?php echo Wfstatus::model()->findstatusname("appinvap",$model->recordstatus);?></span>
</div>
<div class="rowdata">
<span class="cell">Invoice Detail</span>
<span class="cellcontent">
<div id='tabledetail'>
<?php $customeraddress = Invoicedet::model()->findallbyattributes(array('invoiceid'=>$model->invoiceid)); 
echo "<div class='rowheader'>";
 echo "<span class='celldetail'>Material / Service</span>";
 echo "<span class='celldetail'>Qty</span>";
 echo "<span class='celldetail'>Price</span>";
 echo "<span class='celldetail'>Rate</span>";
 echo "<span class='celldetail'>Tax</span>";
 echo "<span class='celldetail'>Detail Note</span>";
 echo "</div>";

foreach ($customeraddress as $sa)
{
 echo "<div class='rowdetail'>";
 echo "<span class='celldetailcenter'>".$sa->product->productname."</span>";
 echo "<span class='celldetailnumeric'>".$sa->qty.$sa->unitofmeasure->uomcode."</span>";
 echo "<span class='celldetailnumeric'>".$sa->currency->symbol.$sa->price."</span>";
 echo "<span class='celldetailnumeric'>".$sa->ratevalue."</span>";
  echo "<span class='celldetailnumeric'>".$sa->tax->taxcode."</span>";
 echo "<span class='celldetail'>".$sa->detailnote."</span>";
 echo "</div>";
}
?>
</div>
</span>
</div>
</div>

