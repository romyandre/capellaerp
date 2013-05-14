<?php
$this->breadcrumbs=array(
	'Repprofitlosss',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata()
{
<?php echo CHtml::ajax(array(
			'url'=>array('repprofitloss/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
$('#Repprofitloss_repprofitlossid').val('');
$('#Repprofitloss_accountid').val('');
$('#accountcode').val('');
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
			'url'=>array('repprofitloss/update'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
$('#Repprofitloss_repprofitlossid').val(data.repprofitlossid);
$('#Repprofitloss_accountid').val(data.accountid);
$('#accountcode').val(data.accountcode);
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
			'url'=>array('company/delete'),
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
        'account'=>$account)); ?>
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
<h1><?php echo Catalogsys::model()->GetCatalog('repprofitloss') ?></h1>
<form action="index.php?r=repprofitloss/download" method="POST">
As of Date : <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'name'=>'dateto',
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>'yy-mm-dd',
				  'changeYear'=>true,
				  'changeMonth'=>true
              ),
              'htmlOptions'=>array(
                  'style'=>'height:20px',
                  'size'=>'10',
              ),
          ));?>
<br/><?php echo CHtml::SubmitButton('Submit',
		array('repprofitloss/download')); ?>
</form><br/>
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
            'name'=>'repprofitlossid',
            'type'=>'raw', 
            'value'=>array($this,'gridData'), 
        ),	
	)
));
?>