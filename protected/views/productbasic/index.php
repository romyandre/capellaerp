<?php
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('productbasic/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Productbasic_productbasicid').val('');
					$('#Productbasic_productid').val('');
					$('#productname').val('');
					$('#Productbasic_baseuom').val('');
					$('#uomcode').val('');
					$('#Productbasic_materialgroupid').val('');
					$('#materialgroupcode').val('');
					$('#Productbasic_materialgroupid').val('');
					$('#materialgroupcode').val('');
					$('#Productbasic_oldmatno').val('');
					$('#Productbasic_grossweight').val('');
					$('#Productbasic_weightunit').val('');
					$('#weightuomcode').val('');
					$('#Productbasic_netweight').val('');
					$('#Productbasic_volume').val('');
					$('#Productbasic_volumeunit').val('');
					$('#volumeuomcode').val('');
					$('#Productbasic_sizedimension').val('');
					$('#Productbasic_materialpackage').val('');
					$('#materialname').val('');
                          // Here is the trick: on submit-> once again this function!
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
    <?php
	echo CHtml::ajax(array(
			'url'=>array('productbasic/update'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Productbasic_productbasicid').val(data.productbasicid);
					$('#Productbasic_productid').val(data.productid);
					$('#productname').val(data.productname);
					$('#Productbasic_baseuom').val(data.baseuom);
					$('#uomcode').val(data.uomcode);
					$('#Productbasic_materialgroupid').val(data.materialgroupid);
					$('#materialgroupcode').val(data.materialgroupcode);
					$('#Productbasic_materialgroupid').val(data.materialgroupid);
					$('#materialgroupcode').val(data.materialgroupcode);
					$('#Productbasic_grossweight').val(data.grossweight);
					$('#Productbasic_weightunit').val(data.weightunit);
					$('#weightuomcode').val(data.weightuomcode);
					$('#Productbasic_netweight').val(data.netweight);
					$('#Productbasic_volume').val(data.volume);
					$('#Productbasic_volumeunit').val(data.volumeunit);
					$('#volumeuomcode').val(data.volumeuomcode);
					$('#Productbasic_sizedimension').val(data.sizedimension);
					$('#Productbasic_materialpackage').val(data.materialpackage);
					$('#materialname').val(data.materialpackagename);
					if (data.recordstatus == '1')
					{
					  document.forms[0].elements[26].checked=true;
					}
					else
					{
					  document.forms[0].elements[26].checked=false;
					}
                          // Here is the trick: on submit-> once again this function!
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
			'url'=>array('productbasic/delete'),
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
	window.open('index.php?r=company/download&id='+value);
}
</script><?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
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
				  'product'=>$product,
				  'baseuom'=>$baseuom,
				  'materialgroup'=>$materialgroup,
				  'weightunit'=>$weightunit,
				  'volumeunit'=>$volumeunit,
				  'materialpackage'=>$materialpackage)); ?>
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
<h1><?php echo Catalogsys::model()->GetCatalog('productbasic') ?></h1>
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
            'name'=>'productbasicid',
            'type'=>'raw', 
            'value'=>array($this,'gridData'), 
        ),		
	), 
));
?>

