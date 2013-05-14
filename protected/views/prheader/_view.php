<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->prheaderid,
'isApprove'=>true,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->prheaderid;?></span>
</div>
<div class="rowdata">
	<span class="cell">PR No</span>
    <span class="cell"><?php echo $model->prno;?></span>
</div>
<div class="rowdata">
	<span class="cell">Form Request No</span>
    <span class="cell"><?php echo ($model->deliveryadvice!==null)?$model->deliveryadvice->dano:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">PR Date</span>
    <span class="cell"><?php echo $model->prdate;?></span>
</div>
<div class="rowdata">
	<span class="cell">Header Note</span>
    <span class="cell"><?php echo $model->headernote;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cell"><?php echo Wfstatus::model()->findstatusname("apppr",$model->recordstatus);?></span>
</div>
<div class="rowdata">
<span class="cell">PR Detail</span>
<span class="cellcontent">
<div id='tabledetail'>
<?php $customeraddress = Prmaterial::model()->findallbyattributes(array('prheaderid'=>$model->prheaderid)); 
echo "<div class='rowheader'>";
 echo "<span class='celldetail'>Material Master / Service</span>";
 echo "<span class='celldetail'>Qty</span>";
 echo "<span class='celldetail'>Requested By</span>";
 echo "<span class='celldetail'>Requested Date</span>";
 echo "<span class='celldetail'>PO Qty</span>";
 echo "<span class='celldetail'>Item Text</span>";
 echo "</div>";


foreach ($customeraddress as $sa)
{
 echo "<div class='rowdetail'>";
 echo "<span class='celldetail'>".$sa->product->productname."</span>";
 echo "<span class='celldetailnumeric'>".$sa->qty.$sa->unitofmeasure->uomcode."</span>";
 echo "<span class='celldetailnumeric'>".$sa->requestedby->description."</span>";
 echo "<span class='celldetailnumeric'>".$sa->reqdate."</span>";
 echo "<span class='celldetailnumeric'>".$sa->poqty."</span>";
 echo "<span class='celldetail'>".$sa->itemtext."</span>";
 echo "</div>";
}
?>
</div>
</span>
</div>
</div>

