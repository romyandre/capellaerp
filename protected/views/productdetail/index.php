<?php
$this->breadcrumbs=array(
	'Products',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata() {
    jQuery.ajax({
        'url': '/smlive/index.php?r=productdetail/create',
        'data': $(this).serialize(),
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
				$('#Productdetail_productid').val('');
				$('#productname').val('');
				$('#Productdetail_slocid').val('');
				$('#slocdesc').val('');
				$('#Productdetail_qty').val('');
				$('#Productdetail_unitofmeasureid').val('');
				$('#uomcode').val('');
				$('#Productdetail_buyprice').val('');
				$('#Productdetail_buydate').val('');
				$('#Productdetail_expiredate').val('');
				$('#Productdetail_currencyid').val('');
				$('#currencyname').val('');
				$('#Productdetail_materialstatusid').val('');
				$('#materialstatusname').val('');
				$('#Productdetail_ownershipid').val('');
				$('#Productdetail_location').val('');
				$('#ownershipname').val('');
                $('#createdialog').dialog('open');
            } else {
                document.getElementById('messages').innerHTML = data.div;
            }
        },
        'cache': false
    });;
    return false;
}
</script>
<script type="text/javascript">
function editdata() {
    jQuery.ajax({
        'url': '/smlive/index.php?r=productdetail/update',
        'data': {
            'id': $.fn.yiiGridView.getSelection("datagrid")
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
                $('#Productdetail_productdetailid').val(data.productdetailid);
				$('#Productdetail_productid').val(data.productid);
				$('#productname').val(data.productname);
				$('#Productdetail_slocid').val(data.slocid);
				$('#slocdesc').val(data.slocdesc);
				$('#Productdetail_qty').val(data.qty);
				$('#Productdetail_unitofmeasureid').val(data.unitofmeasureid);
				$('#uomcode').val(data.uomcode);
				$('#Productdetail_buyprice').val(data.buyprice);
				$('#Productdetail_buydate').val(data.buydate);
				$('#Productdetail_currencyid').val(data.currencyid);
				$('#Productdetail_expiredate').val(data.expiredate);
				$('#Productdetail_serialno').val(data.serialno);
				$('#Productdetail_picproduct').val(data.picproduct);
				$('#currencyname').val(data.currencyname);
				$('#Productdetail_materialstatusid').val(data.materialstatusid);
				$('#materialstatusname').val(data.materialstatusname);
				$('#Productdetail_ownershipid').val(data.ownershipid);
				$('#Productdetail_location').val(data.location);
				$('#ownershipname').val(data.ownershipname);
                if (data.recordstatus == '1') {
                    document.forms[1].elements[22].checked = true;
                } else {
                    document.forms[1].elements[22].checked = false;
                }
                $('#createdialog').dialog('open');
            } else {
                document.getElementById('messages').innerHTML = data.div;
            }
        },
        'cache': false
    });;
    return false;
}
</script>
<script type="text/javascript">
function deletedata()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('productdetail/delete'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML=data.div;
            } ",
            ))?>;
	$.fn.yiiGridView.update('datagrid');
    return false;
}
</script>
<script type="text/javascript">
function refreshdata()
{
    $.fn.yiiGridView.update('datagrid');
    return false;
}
</script>
<script type="text/javascript">
function helpdata(value) {
	jQuery.ajax({
        'url': '/smlive/index.php?r=productdetail/help',
        'data': {
            'id': value
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            if (data.status == 'success') {
				document.getElementById('divhelp').innerHTML = data.div;
                $('#helpdialog').dialog('open');
            } else {
                document.getElementById('messages').innerHTML = data.div;
            }
        },
        'cache': false
    });;
    return false;
}
</script>
<script type="text/javascript">
function generatedata() {
	jQuery.ajax({
        'url': '/smlive/index.php?r=productdetail/generatedata',
        'data': {
            'id': $('#Productdetail_grdetailid').val()
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            if (data.status == 'success') {
				$('#grno').val(data.grno);
				$('#Productdetail_productid').val(data.productid);
				$('#productname').val(data.productname);
				$('#Productdetail_slocid').val(data.slocid);
				$('#slocdesc').val(data.slocdesc);
				$('#Productdetail_qty').val(data.qty);
				$('#Productdetail_unitofmeasureid').val(data.unitofmeasureid);
				$('#uomcode').val(data.uomcode);
				$('#Productdetail_buyprice').val(data.buyprice);
				$('#Productdetail_buydate').val(data.buydate);
				$('#Productdetail_currencyid').val(data.currencyid);
				$('#currencyname').val(data.currencyname);
            } else {
                document.getElementById('messages').innerHTML = data.div;
            }
        },
        'cache': false
    });;
    return false;
}
</script>
<script type="text/javascript">
function downloaddata() {
	window.open('/smlive/index.php?r=productdetail/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
}
</script>
<script type="text/javascript">
function approvedata()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('productdetail/approve'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
				if (data.status == 'failure')
                {
					document.getElementById('messages').innerHTML = data.div;
				}
				else
				{
					refreshdata();
				}
            } ",
            ))?>;
	$.fn.yiiGridView.update('datagrid');
    return false;
}
</script>
<script type="text/javascript">
function showdetail() {
    $.fn.yiiGridView.update('indatagrid', {
                    data: {
                        'Productdetailhist[productdetailid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'createdialog',
    'options'=>array(
        'title'=>'Form Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divcreate"></div>
<?php echo $this->renderPartial('_form', array('model'=>$model,
                    'product'=>$this->product,
                    'currency'=>$this->currency,
                    'unitofmeasure'=>$this->unitofmeasure,
                    'ownership'=>$this->ownership,
    'sloc'=>$this->sloc,
	'materialstatus'=>$this->materialstatus)); ?>
<?php $this->endWidget();?>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'helpdialog',
    'options'=>array(
        'title'=>'Help',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<div id="divhelp"></div>
<?php $this->endWidget();?>
<h1>Transaction: Material Detail</h1>
<div id="toolbar">
<ul>
<?php
$imgedit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgedit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata()}",
	'title'=>Yii::t('app','edit data')
));
echo CHtml :: closeTag('li');

$imgdelete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgdelete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata()}",
   'title'=>Yii::t('app','delete data')
));
echo CHtml :: closeTag('li');

$imgdown=CHtml::image(Yii::app()->request->baseUrl.'/images/down.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgdown,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
    'onclick'=>"{downloaddata()}",
   'title'=>Yii::t('app','download data')
));
echo CHtml :: closeTag('li');

$imgrefresh=CHtml::image(Yii::app()->request->baseUrl.'/images/refresh.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgrefresh,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{refreshdata()}",
   'title'=>Yii::t('app','refresh data')
));
echo CHtml :: closeTag('li');

$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml :: openTag('li');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(1)}",
   'title'=>Yii::t('app','help')
));
echo CHtml :: closeTag('li');
?>
<div class="recordpage">Record/page<?php echo CHtml::textField($pageSize,'',array('size'=>'5',
        // change 'user-grid' to the actual id of your grid!!
        'onchange'=>"$.fn.yiiGridView.update('datagrid',{ data:{pageSize: $(this).val() }})",
	  ));  ?></div></ul></div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'selectionChanged'=>'showdetail',
	'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'productdetailid','visible'=>false, 'header'=>'ID','value'=>'$data->productdetailid','htmlOptions'=>array('width'=>'1%')),
	 'materialcode',
	array('name'=>'productid','value'=>'($data->product!==null)?$data->product->productname:""'),
	array('name'=>'slocid','value'=>'($data->sloc!==null)?$data->sloc->description:""'),
    'serialno',
        array(
      'name'=>'expiredate',
      'type'=>'raw',
         'value'=>'($data->expiredate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->expiredate)):""'
     ),
   array(
      'name'=>'qty',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->qty)',
     ),
	array('name'=>'unitofmeasureid','value'=>'($data->unitofmeasure!==null)?$data->unitofmeasure->uomcode:""'),
        array(
      'name'=>'buydate',
      'type'=>'raw',
         'value'=>'($data->buydate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->buydate)):""'
     ),
        'location',
        array(
      'name'=>'locationdate',
      'type'=>'raw',
         'value'=>'($data->locationdate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->locationdate)):""'
     ),
	 array('name'=>'materialstatusid','value'=>'($data->materialstatus!==null)?$data->materialstatus->materialstatusname:""'),
	 array('name'=>'ownershipid','value'=>'($data->ownership!==null)?$data->ownership->ownershipname:""'),
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'recordstatus',
      'selectableRows'=>'0',
      'header'=>'Record Status',
      'checked'=>'$data->recordstatus',
    ),
  ),
));?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'indatagrid',
	'dataProvider'=>$productdetailhist->search(),
	'filter'=>$productdetailhist,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
	array('name'=>'productdetailid','visible'=>false, 'header'=>'ID','value'=>'$data->productdetailid','htmlOptions'=>array('width'=>'1%')),
	 'materialcode',
	array('name'=>'productid','value'=>'($data->product!==null)?$data->product->productname:""'),
	array('name'=>'slocid','value'=>'($data->sloc!==null)?$data->sloc->description:""'),
    'serialno',
        array(
      'name'=>'expiredate',
      'type'=>'raw',
         'value'=>'($data->expiredate !== null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->expiredate)):""'
     ),
   array(
      'name'=>'qty',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->qty)',
     ),
	array('name'=>'unitofmeasureid','value'=>'($data->unitofmeasure!==null)?$data->unitofmeasure->uomcode:""'),
        array(
      'name'=>'buydate',
      'type'=>'raw',
         'value'=>'($data->buydate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->buydate)):""'
     ),
        'location',
        array(
      'name'=>'locationdate',
      'type'=>'raw',
         'value'=>'($data->locationdate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->locationdate)):""'
     ),
	 array('name'=>'materialstatusid','value'=>'($data->materialstatus!==null)?$data->materialstatus->materialstatusname:""'),
	 array('name'=>'ownershipid','value'=>'($data->ownership!==null)?$data->ownership->ownershipname:""'),
    array(
      'class'=>'CCheckBoxColumn',
      'name'=>'recordstatus',
      'selectableRows'=>'0',
      'header'=>'Record Status',
      'checked'=>'$data->recordstatus',
    ),
  ),
));?>
