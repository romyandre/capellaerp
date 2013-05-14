<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->deliveryadviceid,
'isApprove'=>true,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cellcontent"><?php echo $model->deliveryadviceid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Request No</span>
    <span class="cellcontent"><?php echo $model->dano;?></span>
</div>
<div class="rowdata">
	<span class="cell">Request Date</span>
    <span class="cellcontent"><?php echo $model->dadate;?></span>
</div>
<div class="rowdata">
	<span class="cell">Storage</span>
    <span class="cellcontent"><?php echo ($model->sloc!==null)?$model->sloc->sloccode:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Creator</span>
    <span class="cellcontent"><?php echo ($model->useraccess!==null)?$model->useraccess->username:'';?></span>
</div>
<div class="rowdata">
	<span class="cell">Header Note</span>
    <span class="cellcontent"><?php echo $model->headernote;?></span>
</div>
<div class="rowdata">
	<span class="cell">Status</span>
    <span class="cellcontent"><?php echo Wfstatus::model()->findstatusname("appda",$model->recordstatus);?></span>
</div>
<div class="rowdata">
<span class="cell">Detail</span>
<span class="cellcontent">
<div id='tabledetail'>
<?php $customeraddress = Deliveryadvicedetail::model()->findallbyattributes(array('deliveryadviceid'=>$model->deliveryadviceid)); 
echo "<div class='rowheader'>";
 echo "<span class='celldetail'>Material Master / Service</span>";
 echo "<span class='celldetail'>Qty</span>";
 echo "<span class='celldetail'>Requested By</span>";
 echo "<span class='celldetail'>Requested Date</span>";
 echo "<span class='celldetail'>PR Qty</span>";
 echo "<span class='celldetail'>GI Qty</span>";
 echo "<span class='celldetail'>Item Text</span>";
 echo "</div>";

foreach ($customeraddress as $sa)
{
 echo "<div class='rowdetail'>";
 echo "<span class='celldetail'>".$sa->product->productname."</span>";
 echo "<span class='celldetailnumeric'>".$sa->qty.$sa->unitofmeasure->uomcode."</span>";
 echo "<span class='celldetailnumeric'>".$sa->requestedby->description."</span>";
 echo "<span class='celldetailnumeric'>".$sa->reqdate."</span>";
 echo "<span class='celldetailnumeric'>".$sa->prqty."</span>";
 echo "<span class='celldetailnumeric'>".$sa->giqty."</span>";
 echo "<span class='celldetail'>".$sa->itemtext."</span>";
 echo "</div>";
}
?>
</div>
</span>
</div>
</div>

