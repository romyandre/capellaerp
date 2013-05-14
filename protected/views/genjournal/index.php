<?php
$pageSize=Yii::app()->user->getState('pageSize',Useraccess::model()->findbyattributes(array('username'=>Yii::app()->user->id))->pagesize);
?>
<script type="text/javascript">
function adddata()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('genjournal/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Genjournal_genjournalid').val(data.genjournalid);
					$('#Journaldetail_genjournalid').val(data.genjournalid);
					$('#Genjournal_referenceno').val('');
					$('#Genjournal_journaldate').val('');
					$('#Genjournal_journalnote').val('');
					$('#Genjournal_postdate').val('');
document.forms[1].elements[1].value=data.genjournalid;
$.fn.yiiGridView.update('detaildatagrid',{data:{'Journaldetail[genjournalid]':data.genjournalid}});
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
			'url'=>array('genjournal/update'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Genjournal_genjournalid').val(data.genjournalid);
					$('#Genjournal_referenceno').val(data.referenceno);
					$('#Genjournal_journaldate').val(data.journaldate);
					$('#Genjournal_postdate').val(data.postdate);
					$('#Genjournal_journalnote').val(data.journalnote);
					document.forms[1].elements[1].value=data.genjournalid;
$.fn.yiiGridView.update('detaildatagrid',{data:{'Journaldetail[genjournalid]':data.genjournalid}});
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
			'url'=>array('genjournal/delete'),
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
function approvedata(value)
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('genjournal/approve'),
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
function refreshdata()
{
    $.fn.yiiGridView.update('datagrid');
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
function searchdata() {
$('#searchdialog').dialog('open');
return false;
}
</script>
<script type="text/javascript">
function downloaddata(value) {
	window.open('index.php?r=genjournal/download&id='+value);
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
				  'journaldetail'=>$journaldetail)); ?>
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
<h1><?php echo Catalogsys::model()->GetCatalog('genjournal') ?></h1>
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
'rowCssClassExpression'=>'($data->recordstatus==0)?"deleted":($data->recordstatus==1)?"new":"approved"',
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
		array(            
            'name'=>'genjournalid',
            'type'=>'raw', 
            'value'=>array($this,'gridData'), 
        ),		
	), 
)); ?>
