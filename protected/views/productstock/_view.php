<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'buttongrid','isEdit'=>true,'id'=>$model->productstockid,
'isApprove'=>true,
	'isDelete'=>true,'isDownload'=>true));
?>
<div id="tabledata">
<div class="rowdata">
	<span class="cell">ID</span>
    <span class="cell"><?php echo $model->productstockid;?></span>
</div>
<div class="rowdata">
	<span class="cell">Material</span>
    <span class="cell"><?php echo ($model->product!==null?$model->product->productname:'');?></span>
</div>
<div class="rowdata">
	<span class="cell">Storage Location</span>
    <span class="cell"><?php echo ($model->sloc!==null?$model->sloc->description:'');?></span>
</div>
<div class="rowdata">
	<span class="cell">Unit of Measure</span>
    <span class="cell"><?php echo ($model->unitofmeasure!==null?$model->unitofmeasure->description:'');?></span>
</div>
<div class="rowdata">
<span class="cell">Detail</span>
<span class="cellcontent">
<div id='tabledetail'>
<?php $customeraddress = Productstockdet::model()->findallbyattributes(array('productstockid'=>$model->productstockid)); 
echo "<div class='rowheader'>";
 echo "<span class='celldetail'>Reference No</span>";
 echo "<span class='celldetail'>Product</span>";
 echo "<span class='celldetail'>Storage Location</span>";
 echo "<span class='celldetail'>Qty</span>";
 echo "<span class='celldetail'>UOM</span>";
 echo "</div>";

foreach ($customeraddress as $sa)
{
 echo "<div class='rowdetail'>";
 echo "<span class='celldetail'>".$sa->referenceno."</span>";
 echo "<span class='celldetail'>".$sa->product->productname."</span>";
 echo "<span class='celldetail'>".$sa->sloc->description."</span>";
 echo "<span class='celldetailnumeric'>".$sa->qty."</span>";
 echo "<span class='celldetail'>".$sa->unitofmeasure->description."</span>";
 echo "</div>";
}
?>
</div>
</span>
</div>
</div>

