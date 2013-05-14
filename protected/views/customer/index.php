<?php
$this->breadcrumbs=array(
	'Customers',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata()
{
   <?php echo CHtml::ajax(array(
			'url'=>array('customer/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
$('#Customer_addressbookid').val(data.addressbookid);$('#Customer_fullname').val('');
  $('#Customer_taxno').val('');$('#Customer_acchutangid').val('');$('#acchutangname').val('');
document.forms[1].elements[1].value = data.addressbookid;
$.fn.yiiGridView.update('addressdatagrid', {
                    data: {
                        'Customeraddress[addressbookid]': data.addressbookid
                    }});
                                        document.forms[2].elements[1].value = data.addressbookid;
$.fn.yiiGridView.update('contactdatagrid', {
                    data: {
                        'Customercontact[addressbookid]': data.addressbookid
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
return false;}
</script>
<script type="text/javascript">
function editdata(value)
{
<?php echo CHtml::ajax(array(
			'url'=>array('customer/update'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
$('#Customer_addressbookid').val(data.addressbookid);
$('#Customer_acchutangid').val(data.accountid);$('#acchutangname').val(data.accountno);
$('#Customer_taxno').val(data.taxno);$('#Customer_fullname').val(data.fullname);if(data.recordstatus=='1')
{document.forms[0].elements[7].checked=true;}
else
{document.forms[0].elements[7].checked=false;}
document.forms[1].elements[1].value = data.addressbookid;
$.fn.yiiGridView.update('addressdatagrid', {
                    data: {
                        'Customeraddress[addressbookid]': data.addressbookid
                    }});
                    document.forms[2].elements[1].value = data.addressbookid;
$.fn.yiiGridView.update('contactdatagrid', {
                    data: {
                        'Customercontact[addressbookid]': data.addressbookid
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
return false;}
</script>
<script type="text/javascript">
function deletedata(value)
{
 <?php echo CHtml::ajax(array(
			'url'=>array('customer/delete'),
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
return false;
}
</script>
<script type="text/javascript">
function searchdata()
{
	$('#searchdialog').dialog('open');
    return false;
}
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
	window.open('index.php?r=customer/download&id='+value);
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
'customeraddress'=>$customeraddress,
'customercontact'=>$customercontact,
        'acchutang'=>$acchutang)); ?>
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
<h1><?php echo Catalogsys::model()->GetCatalog('customer') ?></h1>
		<?php
$this->widget('ToolbarButton',array('isCreate'=>true,
	'isSearch'=>true,
	'isDownload'=>true,'isRefresh'=>true,
	'isHelp'=>true,'OnClick'=>"{helpdata(1)}",
	'isRecordPage'=>true,'PageSize'=>$pageSize,'OnChange'=>"$.fn.yiiGridView.update('datagrid',{data:{pageSize: $(this).val() }})"));
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->search(),
'selectableRows'=>1,
	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
		array(            
            'name'=>'addressbookid',
            'type'=>'raw', 
            'value'=>array($this,'gridData'), 
        ),		
	), 
)); 
?>