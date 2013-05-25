<?php
$this->breadcrumbs=array(
	'Bsdetails',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata1()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('bsheader/createdetail'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Bsdetail_bsdetailid').val('');
					$('#Bsdetail_productid').val('');
					$('#productname').val('');
					$('#Bsdetail_unitofmeasureid').val('');
					$('#uomcode').val('');
					$('#Bsdetail_quantity').val('');
					$('#Bsdetail_slocid').val('');
					$('#sloccode').val('');
					$('#Bsdetail_currencyid').val('');
					$('#currencyname').val('');
					$('#Bsdetail_ownershipid').val('');
					$('#Bsdetail_serialno').val('');
					$('#Bsdetail_buydate').val('');
					$('#Bsdetail_buyprice').val('');
					$('#Bsdetail_expiredate').val('');
					$('#ownershipname').val('');
					$('#Bsdetail_materialstatusid').val('');
					$('#Bsdetail_location').val('');
					$('#materialstatusname').val('');
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog1').dialog('open');
                }
                else
                {
                    document.getElementById('messages').innerHTML = data.div;
                }
            } ",
            ))?>;
    return false;
}
</script>
<script type="text/javascript">
function editdata1()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('bsheader/updatedetail'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("detaildatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Bsdetail_bsdetailid').val(data.bsdetailid);
					$('#Bsdetail_productid').val(data.productid);
					$('#productname').val(data.productname);
					$('#Bsdetail_unitofmeasureid').val(data.unitofmeasureid);
					$('#uomcode').val(data.uomcode);
					$('#Bsdetail_quantity').val(data.quantity);
					$('#Bsdetail_slocid').val(data.slocid);
					$('#sloccode').val(data.sloccode);
					$('#Bsdetail_itemnote').val(data.itemnote);
					$('#Bsdetail_buydate').val(data.buydate);
					$('#Bsdetail_buyprice').val(data.buyprice);
					$('#Bsdetail_pono').val(data.pono);
					$('#Bsdetail_currencyid').val(data.currencyid);
					$('#currencyname').val(data.currencyname);
					$('#Bsdetail_ownershipid').val(data.ownershipid);
					$('#ownershipname').val(data.ownershipname);
					$('#Bsdetail_serialno').val(data.serialno);
					$('#Bsdetail_buydate').val(data.buydate);
					$('#Bsdetail_buyprice').val(data.buyprice);
					$('#Bsdetail_expiredate').val(data.expiredate);
					$('#Bsdetail_materialstatusid').val(data.materialstatusid);
					$('#Bsdetail_location').val(data.location);
					$('#materialstatusname').val(data.materialstatusname);
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog1').dialog('open');
                }
                else
                {
                   document.getElementById('messages').innerHTML = data.div;
                }
            } ",
            ))?>;
    return false;
}
</script>
<script type="text/javascript">
function deletedata1()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('bsheader/deletedetail'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("detaildatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {

            } ",
            ))?>;
	$.fn.yiiGridView.update('detaildatagrid');
    return false;
}
</script>
<script type="text/javascript">
function refreshdata1()
{
    $.fn.yiiGridView.update('detaildatagrid');
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'createdialog1',
    'options'=>array(
        'title'=>'Form Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divcreate1"></div>
<?php echo $this->renderPartial('_formdetail', array('model'=>$bsdetail,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'currency'=>$currency,
					'ownership'=>$ownership,
					'materialstatus'=>$materialstatus,
				  'sloc'=>$sloc)); ?>
<?php $this->endWidget();?>
<?php
$img1create=CHtml::image(Yii::app()->request->baseUrl.'/images/create.png');
echo CHtml::link($img1create,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{adddata1()}",
));
$img1edit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
echo CHtml::link($img1edit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata1()}",
));
$img1delete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml::link($img1delete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata1()}",
));
$img1help=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($img1help,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(3)}",
));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'detaildatagrid',
	'dataProvider'=>$bsdetail->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'bsdetailid', 'visible'=>false,'header'=>'ID','value'=>'$data->bsdetailid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'bsheaderid', 'visible'=>false,'value'=>'$data->bsheaderid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'productid', 'value'=>'($data->product!==null)?$data->product->productname:""'),
	array('name'=>'unitofmeasureid', 'value'=>'($data->unitofmeasure!==null)?$data->unitofmeasure->uomcode:""'),
	array(
      'name'=>'quantity',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->quantity)',
     ),
	array('name'=>'slocid', 'value'=>'($data->sloc!==null)?$data->sloc->description:""'),
	'itemnote',
	'pono',
	        array(
      'name'=>'buyprice',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->buyprice)',
     ),
	array('name'=>'currencyid', 'value'=>'($data->currency!==null)?$data->currency->currencyname:""'),
	array(
      'name'=>'buydate',
      'type'=>'raw',
         'value'=>'($data->buydate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->buydate)):""'
     ),
	 array(
      'name'=>'expiredate',
      'type'=>'raw',
         'value'=>'($data->expiredate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->expiredate)):""'
     ),
	 'serialno',
	 	array('name'=>'ownershipid', 'value'=>'($data->ownership!==null)?$data->ownership->ownershipname:""'),
	array('name'=>'materialstatusid', 'value'=>'($data->materialstatus!==null)?$data->materialstatus->materialstatusname:""'),
  ),
));
?>
