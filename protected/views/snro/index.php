<?php
$this->breadcrumbs=array(
	'Snros',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('snro/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
 document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
					$('#Snro_snroid').val('');
					$('#Snro_description').val('');
					$('#Snro_formatdoc').val('');
					$('#Snro_formatno').val('');
					$('#Snro_repeatby').val('');
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog').dialog('open');
                }
                else
                {
                    document.getElementById('messages').innerHTML = data.div;
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
			'url'=>array('snro/update'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
 document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
					$('#Snro_snroid').val(data.snroid);
					$('#Snro_description').val(data.description);
					$('#Snro_formatdoc').val(data.formatdoc);
					$('#Snro_formatno').val(data.formatno);
					$('#Snro_repeatby').val(data.repeatby);
					if (data.recordstatus == '1')
					{
					  document.forms[0].elements[6].checked=true;
					}
					else
					{
					  document.forms[0].elements[6].checked=false;
					}
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog').dialog('open');
                }
                else
                {
                    document.getElementById('messages').innerHTML = data.div;
                }
            } ",
            ))?>;
    return false;
}
</script>
<script type="text/javascript">
function deletedata(value)
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('snro/delete'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
$.fn.yiiGridView.update('datagrid');
            } ",
            ))?>;	
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
	j$('#helpdialog').dialog('open');
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
function downloaddata() {
	window.open('index.php?r=snro/download&id='+value);
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
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
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
<h1><?php echo Catalogsys::model()->GetCatalog('snro') ?></h1>
		<?php
$this->widget('ToolbarButton',array('isCreate'=>true,
	'isUpload'=>true,'UrlUpload'=>'index.php?r=snro/upload',
	'isSearch'=>true,
	'isDownload'=>true,'isRefresh'=>true,
	'isHelp'=>true,'OnClick'=>"{helpdata(1)}",
	'isRecordPage'=>true,'PageSize'=>$pageSize,'OnChange'=>"$.fn.yiiGridView.update('datagrid',{data:{pageSize: $(this).val() }})"));
?> 
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->search(),
	'hideHeader'=>true,
'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
		array(            
            'name'=>'companyname',
            'type'=>'raw', 
            'value'=>array($this,'gridData'), 
        ),		
	), 
)); 
?>
