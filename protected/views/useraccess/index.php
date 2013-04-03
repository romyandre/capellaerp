<?php
$this->breadcrumbs=array(
	'Useraccesses',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata()
{
<?php echo CHtml::ajax(array(
			'url'=>array('useraccess/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
document.getElementById('messages').innerHTML = '';
                if (data.status == 'success')
                {
					$('#Useraccess_useraccessid').val('');
					$('#Useraccess_username').val('');
					$('#Useraccess_realname').val('');
					$('#Useraccess_email').val('');
					$('#passhide').val('');
					$('#Useraccess_password').val('');
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
	<?php echo CHtml::ajax(array(
					'url'=>array('useraccess/update'),
					'data'=> array('id'=>'js:value'),
					'type'=>'post',
					'dataType'=>'json',
					'success'=>"function(data)
					{
						if (data.status == 'success')
						{
		$('#Useraccess_useraccessid').val(data.useraccessid);
$('#Useraccess_username').val(data.username);$('#Useraccess_realname').val(data.realname);
$('#Useraccess_email').val(data.email);$('#passhide').val(data.password);
$('#Useraccess_password').val('');if(data.recordstatus=='1')
{document.forms[0].elements[7].checked=true;}
else
{document.forms[0].elements[7].checked=false;}
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
<?php echo CHtml::ajax(array(
			'url'=>array('useraccess/delete'),
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
                    document.getElementById('messages').innerHTML = data.div;
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
	window.open('index.php?r=useraccess/download&id='+value);
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
<h1><?php echo Catalogsys::model()->GetCatalog('useraccess') ?></h1>
		<?php
$this->widget('ToolbarButton',array('isCreate'=>true,
	'isUpload'=>true,'UrlUpload'=>'index.php?r=useraccess/upload',
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
            'name'=>'username',
            'type'=>'raw', 
            'value'=>array($this,'gridData'), 
        ),	
))); ?>
