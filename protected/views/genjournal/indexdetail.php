<?php
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata1()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('genjournal/createdetail'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Journaldetail_journaldetailid').val('');
					$('#Journaldetail_accountid').val('');
					$('#account_name').val('');
					$('#Journaldetail_debit').val('0');
					$('#Journaldetail_credit').val('0');
					$('#Journaldetail_currencyid').val(data.currencyid);
					$('#currencyname').val(data.currencyname);
					$('#Journaldetail_detailnote').val('');
					$('#Journaldetail_ratevalue').val('1');
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog1').dialog('open');
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
function editdata1()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('genjournal/updatedetail'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("detaildatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Journaldetail_journaldetailid').val(data.journaldetailid);
					$('#Journaldetail_accountid').val(data.accountid);
					$('#account_name').val(data.accountname);
					$('#Journaldetail_debit').val(data.debit);
					$('#Journaldetail_credit').val(data.credit);
					$('#Journaldetail_currencyid').val(data.currencyid);
					$('#currencyname').val(data.currencyname);
					$('#Journaldetail_detailnote').val(data.detailnote);
					$('#Journaldetail_ratevalue').val(data.ratevalue);
					if (data.recordstatus == '1')
					{
					  $('#recordstatus').checked='checked';
					}
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog1').dialog('open');
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
function deletedata1(value)
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('genjournal/deletedetail'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
if (data.status == 'success')
                {
					toastr.info(data.div);
                    js:$.fn.yiiGridView.update('detaildatagrid');
                }
                else
                {
                    toastr.error(data.div);
                }
            } ",
            ))?>;
	$.fn.yiiGridView.update('detaildatagrid');
    return false;
}
</script>
<script type="text/javascript">
function refreshdata1()
{
    $.fn.yiiGridView.update('detaildatagrid');
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'createdialog1',
    'options'=>array(
        'title'=>'Form Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<?php echo $this->renderPartial('_formdetail', array('model'=>$journaldetail)); ?>
<?php $this->endWidget();?>
		<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'toolbardetail','isCreate'=>true,'UrlCreate'=>'adddata1()',
	'isRefresh'=>true,'isEdit'=>true,'UrlEdit'=>'editdata1()',
	'isRecordPage'=>true,'PageSize'=>$pageSize,'OnChange'=>"$.fn.yiiGridView.update('detaildatagrid',{data:{pageSize: $(this).val() }})"));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'detaildatagrid',
	'dataProvider'=>$journaldetail->search(),
  'selectableRows'=>1,
  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
	array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'journaldetailid', 'visible'=>false,'header'=>'ID','value'=>'$data->journaldetailid','htmlOptions'=>array('width'=>'1%')),
	array('name'=>'accountid', 'header'=>'Account Code','value'=>'$data->account->accountcode'),
	array('name'=>'currencyid', 'value'=>'($data->currency!==null)?$data->currency->currencyname:""'),
		'debit',
		'credit',
		'ratevalue'
	), 
));
?>
