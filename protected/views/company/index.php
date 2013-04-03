<?php
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('company/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Company_companyid').val('');
$('#Company_companyname').val('');
$('#Company_address').val('');
$('#Company_city').val('');
$('#Company_zipcode').val('');
$('#Company_taxno').val('');
$('#Company_currencyid').val('');
$('#currencyname').val('');
$('#Company_faxno').val('');
$('#Company_webaddress').val('');
$('#Company_phoneno').val('');
$('#Company_email').val('');
$('#Company_leftlogofile').val('');
$('#Company_rightlogofile').val('');
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
function editdata(value)
{
 <?php echo CHtml::ajax(array(
			'url'=>array('company/update'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
$('#Company_companyid').val(data.companyid);
$('#Company_companyname').val(data.companyname);
$('#Company_address').val(data.address);
$('#Company_city').val(data.city);
$('#Company_zipcode').val(data.zipcode);
$('#Company_taxno').val(data.taxno);
$('#Company_faxno').val(data.faxno);
$('#Company_webaddress').val(data.webaddress);
$('#Company_phoneno').val(data.phoneno);
$('#Company_email').val(data.email);
$('#Company_leftlogofile').val(data.leftlogofile);
$('#Company_rightlogofile').val(data.rightlogofile);
if(data.recordstatus=='1')
{document.forms[0].elements[16].checked=true;}
else
{document.forms[0].elements[16].checked=false;}
$('#Company_currencyid').val(data.currencyid);
$('#currencyname').val(data.currencyname);
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
function deletedata(value)
{
 <?php echo CHtml::ajax(array(
			'url'=>array('company/delete'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
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
	window.open('index.php?r=company/download&id='+value);
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
<h1><?php echo Catalogsys::model()->GetCatalog('company') ?></h1>
		<?php
$this->widget('ToolbarButton',array('isCreate'=>true,
	'isUpload'=>true,'UrlUpload'=>'index.php?r=company/upload',
	'isSearch'=>true,
	'isDownload'=>true,'isRefresh'=>true,
	'isHelp'=>true,'OnClick'=>"{helpdata(1)}",
	'isRecordPage'=>true,'PageSize'=>$pageSize,'OnChange'=>"$.fn.yiiGridView.update('datagrid',{data:{pageSize: $(this).val() }})"));
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->search(),
'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
		array(            
            'name'=>'companyid',
            'type'=>'raw', 
            'value'=>array($this,'gridData'), 
        ),		
	), 
)); ?>