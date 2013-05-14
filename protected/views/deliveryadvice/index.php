<?php
$this->breadcrumbs=array(
	'Deliveryadvices',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata() {
 <?php echo CHtml::ajax(array(
			'url'=>array('deliveryadvice/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
$('#Deliveryadvice_deliveryadviceid').val(data.deliveryadviceid);
					$('#Deliveryadvice_dadate').val('');
					$('#Deliveryadvice_dano').val('');
					$('#Deliveryadvice_headernote').val('');
					$('#Deliveryadvice_slocid').val('');
					$('#description').val('');
                document.forms[2].elements[1].value = data.deliveryadviceid;
                $.fn.yiiGridView.update('detaildatagrid', {
                    data: {
                        'Deliveryadvicedetail[deliveryadviceid]': data.deliveryadviceid
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
<?php echo CHtml::ajax(array(
			'url'=>array('deliveryadvice/update'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
$('#Deliveryadvice_deliveryadviceid').val(data.deliveryadviceid);
					$('#Deliveryadvice_dano').val(data.dano);
                                        $('#Deliveryadvice_dadate').val(data.dadate);
					$('#Deliveryadvice_headernote').val(data.headernote);
					$('#Deliveryadvice_slocid').val(data.slocid);
					$('#description').val(data.sloccode);
					if (data.recordstatus == '1')
					{
					  document.forms[0].elements[3].checked=true;
					}
					else
					{
					  document.forms[0].elements[3].checked=false;
					}
                document.forms[1].elements[1].value = data.deliveryadviceid;
                $.fn.yiiGridView.update('detaildatagrid', {
                    data: {
                        'Deliveryadvicedetail[deliveryadviceid]': data.deliveryadviceid
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
function deletedata(value)
{
 <?php echo CHtml::ajax(array(
			'url'=>array('deliveryadvice/delete'),
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
function approvedata(value)
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('deliveryadvice/approve'),
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
	$.fn.yiiGridView.update('datagrid');
    return false;
}
</script>
<script type="text/javascript">
function downloaddata(value) {
	window.open('index.php?r=deliveryadvice/download&id='+value);
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
					'deliveryadvicedetail'=>$deliveryadvicedetail,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'requestedby'=>$requestedby,
					'sloc'=>$sloc)); ?>
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
<h1><?php echo Catalogsys::model()->GetCatalog('deliveryadvice') ?></h1>
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
'rowCssClassExpression'=>'($data->recordstatus==0)?"delete":($data->recordstatus==1)?"new":"approved"',
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
		array(            
            'name'=>'deliveryadviceid',
            'type'=>'raw', 
            'value'=>array($this,'gridData'), 
        ),		
	), 
)); 
?>