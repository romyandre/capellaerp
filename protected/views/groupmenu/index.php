<?php
$this->breadcrumbs=array(
	'Groupmenues',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata() {
<?php echo CHtml::ajax(array(
			'url'=>array('groupmenu/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Groupmenu_groupmenuid').val('');
                $('#Groupmenu_groupaccessid').val('');
                $('#groupname').val('');
                $('#Groupmenu_menuaccessid').val('');
                $('#menuname').val('');
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
			'url'=>array('groupmenu/update'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
$('#Groupmenu_groupmenuid').val(data.groupmenuid);
                $('#Groupmenu_groupaccessid').val(data.groupaccessid);
                $('#groupname').val(data.groupname);
                $('#Groupmenu_menuaccessid').val(data.menuaccessid);
                $('#menuname').val(data.menuname);
                if (data.isread == '1') {
                    document.forms[0].elements[8].checked = true;
                } else {
                    document.forms[0].elements[8].checked = false;
                }
                if (data.iswrite == '1') {
                    document.forms[0].elements[10].checked = true;
                } else {
                    document.forms[0].elements[10].checked = false;
                }
                if (data.ispost == '1') {
                    document.forms[0].elements[12].checked = true;
                } else {
                    document.forms[0].elements[12].checked = false;
                }
                if (data.isreject == '1') {
                    document.forms[0].elements[14].checked = true;
                } else {
                    document.forms[0].elements[14].checked = false;
                }
                if (data.isupload == '1') {
                    document.forms[0].elements[16].checked = true;
                } else {
                    document.forms[0].elements[16].checked = false;
                }
                if (data.isdownload == '1') {
                    document.forms[0].elements[18].checked = true;
                } else {
                    document.forms[0].elements[18].checked = false;
                }
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
			'url'=>array('groupmenu/delete'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
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
function searchdata()
{
	$('#searchdialog').dialog('open');
    return false;
}
</script>
<script type="text/javascript">
function downloaddata(value) {
	window.open('index.php?r=groupmenu/download&id='+value);
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
'groupaccess'=>$groupaccess,
'menuaccess'=>$menuaccess));?>
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
<h1><?php echo Catalogsys::model()->GetCatalog('groupmenu') ?></h1>
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
'selectableRows'=>1,
	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
		array(            
            'name'=>'groupmenuid',
            'type'=>'raw', 
            'value'=>array($this,'gridData'), 
        ),		
	), 
));
?>
