<?php
$this->breadcrumbs=array(
	'Prheaders',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata1()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('prheader/createdetail'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Prmaterial_prmaterialid').val('');
					$('#Prmaterial_productid').val('');
					$('#productname').val('');
					$('#Prmaterial_qty').val('');
					$('#Prmaterial_unitofmeasureid').val('');
					$('#uomcode').val('');
					$('#Prmaterial_requestedbyid').val('');
					$('#reqbyname').val('');
					$('#Prmaterial_reqdate').val('');
					$('#Prmaterial_itemtext').val('');
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
			'url'=>array('prheader/updatedetail'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("detaildatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
                    $('#createdialog1 div.divcreate1').html(data.div);
					$('#Prmaterial_prmaterialid').val(data.prmaterialid);
					$('#Prmaterial_productid').val(data.productid);
					$('#productname').val(data.productname);
					$('#Prmaterial_qty').val(data.qty);
					$('#Prmaterial_unitofmeasureid').val(data.unitofmeasureid);
					$('#uomcode').val(data.uomcode);
					$('#Prmaterial_requestedbyid').val(data.requestedbyid);
					$('#reqbyname').val(data.requestedbycode);
					$('#Prmaterial_reqdate').val(data.reqdate);
					$('#Prmaterial_itemtext').val(data.itemtext);
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
			'url'=>array('prheader/deletedetail'),
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
<?php echo $this->renderPartial('_formdetail', array('model'=>$prmaterial,
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
	'dataProvider'=>$prmaterial->search(),
  'selectableRows'=>1,
  	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'prmaterialid', 'visible'=>false,'header'=>'ID','value'=>'$data->prmaterialid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'productid', 'value'=>'($data->product!==null)?$data->product->productname:""'),
array(
      'name'=>'qty',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->qty)',
     ),
        array('name'=>'unitofmeasureid', 'value'=>'($data->unitofmeasure!==null)?$data->unitofmeasure->uomcode:""'),
	array('name'=>'requestedbyid', 'value'=>'($data->requestedby!==null)?$data->requestedby->description:""'),
                array(
      'name'=>'reqdate',
      'type'=>'raw',
         'value'=>'date(Yii::app()->params["dateviewfromdb"], strtotime($data->reqdate))'
     ),         
            'itemtext'
  ),
));
?>
