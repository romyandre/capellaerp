<?php
$this->breadcrumbs=array(
	'Poheaders',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata()
{
<?php echo CHtml::ajax(array(
			'url'=>array('poheader/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
$('#Poheader_poheaderid').val(data.poheaderid);
					$('#Podetail_poheaderid').val(data.poheaderid);
					$('#Poheader_pono').val('');
					$('#Poheader_headernote').val('');
					$('#Poheader_postdate').val('');
					$('#Poheader_docdate').val('');
					$('#Poheader_purchasingorgid').val('');
					$('#purchasingorgcode').val('');
					$('#Poheader_purchasinggroupid').val('');
					$('#purchasinggroupcode').val('');
					$('#Poheader_addressbookid').val('');
					$('#fullname').val('');
					$('#Poheader_paymentmethodid').val('');
					$('#paycode').val('');
					document.forms[1].elements[1].value=data.poheaderid;
$.fn.yiiGridView.update('detaildatagrid',{data:{'Podetail[poheaderid]':data.poheaderid}});
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
			'url'=>array('poheader/update'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
$('#Poheader_poheaderid').val(data.poheaderid);
					$('#Poheader_pono').val(data.pono);
					$('#Poheader_headernote').val(data.headernote);
					$('#Poheader_postdate').val(data.postdate);
					$('#Poheader_docdate').val(data.docdate);
					$('#Poheader_purchasingorgid').val(data.purchasingorgid);
					$('#purchasingorgcode').val(data.purchasingorgcode);
					$('#Poheader_purchasinggroupid').val(data.purchasinggroupid);
					$('#purchasinggroupcode').val(data.purchasinggroupcode);
					$('#Poheader_addressbookid').val(data.addressbookid);
					$('#fullname').val(data.fullname);
					$('#Poheader_paymentmethodid').val(data.paymentmethodid);
					$('#paycode').val(data.paycode);
					if (data.recordstatus == '1')
					{
					  document.forms[0].elements[12].checked=true;
					}
					else
					{
					  document.forms[0].elements[12].checked=false;
					}
					document.forms[1].elements[1].value=data.poheaderid;
	$.fn.yiiGridView.update('detaildatagrid',{data:{'Podetail[poheaderid]':data.poheaderid}});
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
			'url'=>array('poheader/delete'),
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
function approvedata(value)
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('poheader/approve'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("datagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
if (data.status == 'failure')
                {
                document.getElementById('messages').innerHTML = data.div;
            }
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
function searchdata()
{
	$('#searchdialog').dialog('open');
    return false;
}
</script>
<script type="text/javascript">
function helpdata(value) {
$('#helpdialog').dialog('open');
return false;
}
</script>
<script type="text/javascript">
function showdetail() {
    $.fn.yiiGridView.update('indatagrid', {
                    data: {
                        'Podetail[poheaderid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
    return false;
}
</script>
<script type="text/javascript">
function downloaddata() {
	window.open('index.php?r=poheader/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
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
				  'purchasingorg'=>$purchasingorg,
				  'purchasinggroup'=>$purchasinggroup,
    'paymentmethod'=>$paymentmethod,
				  'supplier'=>$supplier,
				  'podetail'=>$podetail,
				  'prheader'=>$prheader,
				  'product'=>$product,
				  'unitofmeasure'=>$unitofmeasure,
				  'currency'=>$currency,
				  'sloc'=>$sloc,
				  'tax'=>$tax)); ?>
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
<h1><?php echo Catalogsys::model()->GetCatalog('poheader') ?></h1>
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
	'dataProvider'=>$model->searchwfstatus(),
	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
'rowCssClassExpression'=>'($data->recordstatus==0)?"delete":($data->recordstatus==1)?"new":"approved"',
	'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
   array(            
            'name'=>'poheaderid',
            'type'=>'raw', 
            'value'=>array($this,'gridData'), 
        ),		
  ),
));
?>
