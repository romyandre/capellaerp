<?php
$this->breadcrumbs=array(
	'Purchinforecs',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata()
{
<?php echo CHtml::ajax(array(
			'url'=>array('purchinforec/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
$('#Purchinforec_purchinforecid').val('');
					$('#Purchinforec_addressbookid').val('');
					$('#addressbook_name').val('');
					$('#Purchinforec_productid').val('');
					$('#productname').val('');
					$('#Purchinforec_materialgroupid').val('');
					$('#materialgroupcode').val('');
					$('#Purchinforec_purchasingorgid').val('');
					$('#purchasingorgcode').val('');
					$('#Purchinforec_deliverytime').val('');
					$('#Purchinforec_purchasinggroupid').val('');
					$('#purchasinggroupcode').val('');
					$('#Purchinforec_underdelvtol').val('');
					$('#Purchinforec_overdelvtol').val('');
					$('#Purchinforec_price').val('');
					$('#Purchinforec_currencyid').val('');
					$('#currencyname').val('');
					$('#Purchinforec_biddate').val('');
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
			'url'=>array('purchinforec/update'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
$('#Purchinforec_purchinforecid').val(data.purchinforecid);
					$('#Purchinforec_addressbookid').val(data.addressbookid);
					$('#addressbook_name').val(data.suppliername);
					$('#Purchinforec_productid').val(data.productid);
					$('#productname').val(data.productname);
					$('#Purchinforec_materialgroupid').val(data.materialgroupid);
					$('#materialgroupcode').val(data.materialgroupcode);
					$('#Purchinforec_purchasingorgid').val(data.purchasingorgid);
					$('#purchasingorgcode').val(data.purchasingorgcode);
					$('#Purchinforec_deliverytime').val(data.deliverytime);
					$('#Purchinforec_purchasinggroupid').val(data.purchasinggroupid);
					$('#purchasinggroupcode').val(data.purchasinggroupcode);
					$('#Purchinforec_underdelvtol').val(data.underdelvtol);
					$('#Purchinforec_overdelvtol').val(data.overdelvtol);
					$('#Purchinforec_price').val(data.price);
					$('#Purchinforec_currencyid').val(data.currencyid);
					$('#currencyname').val(data.currencyname);
					$('#Purchinforec_biddate').val(data.biddate);
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
			'url'=>array('purchinforec/delete'),
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
function downloaddata() {
	window.open('index.php?r=purchinforec/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
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
				  'supplier'=>$supplier,
				  'product'=>$product,
				  'purchasinggroup'=>$purchasinggroup,
    'currency'=>$currency)); ?>
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
<h1><?php echo Catalogsys::model()->GetCatalog('purchinforec') ?></h1>
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
	'dataProvider'=>$model->search(),
	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
	'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(            
            'name'=>'purchinforecid',
            'type'=>'raw', 
            'value'=>array($this,'gridData'), 
        ),		
  ),
));
?>