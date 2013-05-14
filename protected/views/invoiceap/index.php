<?php
$this->breadcrumbs=array(
	'Invoiceaps',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata() {
<?php echo CHtml::ajax(array(
			'url'=>array('invoiceap/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Invoice_invoiceid').val(data.invoiceid);
                $('#Invoice_invoicedate').val('');
                $('#Invoice_poheaderid').val('');
                $('#pono').val('');
                $('#Invoice_invoiceno').val('');
                $('#Invoice_amount').val('');
                $('#Invoice_currencyid').val(data.currencyid);
                $('#currencyname').val(data.currencyname);
                $('#Invoice_rate').val('1');
                $('#Invoice_headernote').val('');
                $('#Invoice_taxid').val('');
                $('#taxcode').val('');
                $('#Invoice_paymentmethodid').val('');
                $('#paycode').val('');
                $('#Invoice_fpno').val('');
                $('#Invoice_fpdate').val('');
                document.forms[1].elements[1].value = data.invoiceid;
                document.forms[2].elements[1].value = data.invoiceid;
                $.fn.yiiGridView.update('detail1datagrid', {
                    data: {
                        'Invoicedet[invoiceid]': data.invoiceid
                    }
                });
                $.fn.yiiGridView.update('detail2datagrid', {
                    data: {
                        'Invoiceacc[invoiceid]': data.invoiceid
                    }
                });
                     $('#createdialog').dialog('open');
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
function editdata(value) {
<?php
	echo CHtml::ajax(array(
			'url'=>array('invoiceap/update'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Invoice_invoiceid').val(data.invoiceid);
                $('#Invoice_invoicedate').val(data.invoicedate);
                $('#Invoice_invoiceno').val(data.invoiceno);
                $('#Invoice_poheaderid').val(data.poheaderid);
                $('#pono').val(data.pono);
                $('#Invoice_amount').val(data.amount);
                $('#Invoice_currencyid').val(data.currencyid);
                $('#currencyname').val(data.currencyname);
                $('#Invoice_rate').val(data.rate);
                $('#Invoice_headernote').val(data.headernote);
                $('#Invoice_taxid').val(data.taxid);
                $('#taxcode').val(data.taxcode);
                $('#Invoice_paymentmethodid').val(data.paymentmethodid);
                $('#paycode').val(data.paycode);
                $('#Invoice_fpno').val(data.fpno);
                $('#Invoice_fpdate').val(data.fpdate);
                 document.forms[1].elements[1].value = data.invoiceid;
                 document.forms[2].elements[1].value = data.invoiceid;
               $.fn.yiiGridView.update('detail1datagrid', {
                    data: {
                        'Invoicedet[invoiceid]': data.invoiceid
                    }
                });
               $.fn.yiiGridView.update('detail2datagrid', {
                    data: {
                        'Invoiceacc[invoiceid]': data.invoiceid
                    }
                });
                     $('#createdialog').dialog('open');
                }
                else
                {
                    toastr.error(data.div);
                }
            } ",
            ))?>;

    jQuery.ajax({
        'url': '/smlive/index.php?r=invoiceap/update',
        'data': {
            'id': $.fn.yiiGridView.getSelection("datagrid")
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
                $('#Invoice_invoiceid').val(data.invoiceid);
                $('#Invoice_invoicedate').val(data.invoicedate);
                $('#Invoice_invoiceno').val(data.invoiceno);
                $('#Invoice_poheaderid').val(data.poheaderid);
                $('#pono').val(data.pono);
                $('#Invoice_amount').val(data.amount);
                $('#Invoice_currencyid').val(data.currencyid);
                $('#currencyname').val(data.currencyname);
                $('#Invoice_rate').val(data.rate);
                $('#Invoice_headernote').val(data.headernote);
                $('#Invoice_taxid').val(data.taxid);
                $('#taxcode').val(data.taxcode);
                $('#Invoice_paymentmethodid').val(data.paymentmethodid);
                $('#paycode').val(data.paycode);
                $('#Invoice_fpno').val(data.fpno);
                $('#Invoice_fpdate').val(data.fpdate);
                 document.forms[2].elements[1].value = data.invoiceid;
                 document.forms[3].elements[1].value = data.invoiceid;
               $.fn.yiiGridView.update('detail1datagrid', {
                    data: {
                        'Invoicedet[invoiceid]': data.invoiceid
                    }
                });
               $.fn.yiiGridView.update('detail2datagrid', {
                    data: {
                        'Invoiceacc[invoiceid]': data.invoiceid
                    }
                });
                $('#createdialog').dialog('open');
            }
            else {
                document.getElementById('messages').innerHTML = data.div;
            }
        },
        'cache': false
    });;
    return false;
}
</script>
<script type="text/javascript">
function deletedata(value)
{
 <?php echo CHtml::ajax(array(
			'url'=>array('invoiceap/delete'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					toastr.info(data.div);
                    js:$.fn.yiiGridView.update('datagrid');
                }
                else
                {
                    toastr.error(data.div);
                }
            } ",
            ))?>;
return false;}
</script>
<script type="text/javascript">
function approvedata()
{
<?php
	echo CHtml::ajax(array(
			'url'=>array('invoiceap/approve'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
if (data.status == 'success')
                {
					toastr.info(data.div);
                    js:$.fn.yiiGridView.update('datagrid');
                }
                else
                {
                    toastr.error(data.div);
                } }",
            ))?>;
			return false;}
</script>
<script type="text/javascript">
function refreshdata()
{$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function helpdata(value) {
$('#helpdialog').dialog('open');
return false;
}
</script>
<script type="text/javascript">
function downloaddata(value) {
	window.open('index.php?r=invoiceap/download&id='+value);
}
</script>
<script type="text/javascript">
function generatedata() {
<?php
	echo CHtml::ajax(array(
			'url'=>array('invoiceap/generatedetail'),
            'data'=> array('id'=> 'js:$("#Invoice_poheaderid").val()',
				'hid'=> 'js:$("#Invoice_invoiceid").val()'
			),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Invoice_addressbookid').val(data.addressbookid);
              $('#fullname').val(data.fullname);
              $('#Invoice_paymentmethodid').val(data.paymentmethodid);
              $('#paycode').val(data.paycode);
              $('#Invoice_headernote').val(data.headernote);
			  $.fn.yiiGridView.update('detail1datagrid');
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
<?php echo $this->renderPartial('_form', array('model'=>$model,
'invoiceacc'=>$invoiceacc,
'invoicedet'=>$invoicedet
)); ?>
<?php $this->endWidget();?>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'searchdialog',
    'options'=>array(
        'title'=>'Search Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<?php echo $this->renderPartial('_search'); ?>
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
<?php echo $this->renderPartial('_help'); ?>
<?php $this->endWidget();?>
<h1><?php echo Catalogsys::model()->GetCatalog('invoiceap') ?></h1>
		<?php
$this->widget('ToolbarButton',array('isCreate'=>true,
	'isSearch'=>true,
	'isDownload'=>true,'isRefresh'=>true,
	'isHelp'=>true,'OnClick'=>"{helpdata(1)}",
	'isRecordPage'=>true,'PageSize'=>$pageSize,'OnChange'=>"$.fn.yiiGridView.update('datagrid',{data:{pageSize: $(this).val() }})"));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->Searchwfapstatus(),
	'filter'=>$model,
    'selectableRows'=>1,
	'selectionChanged'=>'showdetail',
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(            
            'name'=>'invoiceid',
            'type'=>'raw', 
            'value'=>array($this,'gridData'), 
        ),	
  ),
));
?>