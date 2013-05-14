<?php
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata1()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('deliveryadvice/createdetail'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Deliveryadvicedetail_deliveryadvicedetailid').val('');
					$('#Deliveryadvicedetail_productid').val('');
					$('#productname').val('');
					$('#Deliveryadvicedetail_qty').val('');
					$('#Deliveryadvicedetail_unitofmeasureid').val('');
					$('#uomcode').val('');
					$('#Deliveryadvicedetail_requestedbyid').val('');
					$('#reqbyname').val('');
					$('#Deliveryadvicedetail_reqdate').val('');
					$('#Deliveryadvicedetail_itemtext').val('');
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog1').dialog('open');
                }
                else
                {
                    toastr.error(data.div);
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
			'url'=>array('deliveryadvice/updatedetail'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("detaildatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Deliveryadvicedetail_deliveryadvicedetailid').val(data.deliveryadvicedetailid);
					$('#Deliveryadvicedetail_productid').val(data.productid);
					$('#productname').val(data.productname);
					$('#Deliveryadvicedetail_qty').val(data.qty);
					$('#Deliveryadvicedetail_unitofmeasureid').val(data.unitofmeasureid);
					$('#uomcode').val(data.uomcode);
					$('#Deliveryadvicedetail_requestedbyid').val(data.requestedbyid);
					$('#reqbyname').val(data.requestedbycode);
					$('#Deliveryadvicedetail_reqdate').val(data.reqdate);
					$('#Deliveryadvicedetail_itemtext').val(data.itemtext);
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog1').dialog('open');
                }
                else
                {
                    toastr.error(data.div);
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
			'url'=>array('deliveryadvice/deletedetail'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("detaildatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
if (data.status == 'success')
                {
					toastr.info(data.div);
                    js:$.fn.yiiGridView.update('detaildatagrid');
                }
                else
                {
                    toastr.error(data.div);
                }
            } ",
            ))?>;
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
<?php echo $this->renderPartial('_formdetail', array('model'=>$deliveryadvicedetail,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'requestedby'=>$requestedby)); ?>
<?php $this->endWidget();?>
		<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'toolbardetail','isCreate'=>true,'UrlCreate'=>'adddata1()',
'isDelete'=>true,'UrlDelete'=>'deletedata1()',
	'isRefresh'=>true,'isEdit'=>true,'UrlEdit'=>'editdata1()',
	'isRecordPage'=>true,'PageSize'=>$pageSize,'OnChange'=>"$.fn.yiiGridView.update('detaildatagrid',{data:{pageSize: $(this).val() }})"));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'detaildatagrid',
	'dataProvider'=>$deliveryadvicedetail->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'deliveryadvicedetailid', 'visible'=>false,'header'=>'ID','value'=>'$data->deliveryadvicedetailid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'productid', 'value'=>'($data->product!==null)?$data->product->productname:""'),
'qty',
        array('name'=>'unitofmeasureid', 'value'=>'($data->unitofmeasure!==null)?$data->unitofmeasure->uomcode:""'),
	array('name'=>'requestedbyid', 'value'=>'($data->requestedby!==null)?$data->requestedby->description:""'),
       'reqdate',
            'itemtext'
  ),
));
?>
