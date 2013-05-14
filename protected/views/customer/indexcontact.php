<?php
$this->breadcrumbs=array(
	'Customercontacts',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata2()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('customer/createcontact'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Customercontact_addresscontactid').val('');
					$('#Customercontact_contacttypeid').val('');
					$('#contacttype_name').val('');
					$('#Customercontact_addresscontactname').val('');
                    $('#Customercontact_phoneno').val('');
                    $('#Customercontact_mobilephone').val('');
                    $('#Customercontact_emailaddress').val('');
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog2').dialog('open');
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
function editdata2()
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('customer/updatecontact'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("contactdatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Customercontact_addresscontactid').val(data.addresscontactid);
					$('#Customercontact_contacttypeid').val(data.contacttypeid);
					$('#contacttype_name').val(data.contacttypename);
					$('#Customercontact_addresscontactname').val(data.addresscontactname);
                    $('#Customercontact_phoneno').val(data.phoneno);
                    $('#Customercontact_mobilephone').val(data.mobilephone);
                    $('#Customercontact_emailaddress').val(data.emailaddress);
                          // Here is the trick: on submit-> once again this function!
                    $('#createdialog2').dialog('open');
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
function deletedata2(value)
{
 <?php echo CHtml::ajax(array(
			'url'=>array('customer/deletecontact'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					toastr.info(data.div);
                    js:$.fn.yiiGridView.update('contactdatagrid');
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
function refreshdata2()
{
    $.fn.yiiGridView.update('contactdatagrid');
    return false;
}
</script>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'createdialog2',
    'options'=>array(
        'title'=>'Form Dialog',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto',
        'height'=>'auto',
    ),
));?>
<?php echo $this->renderPartial('_formcontact', array('model'=>$customercontact)); ?>
<?php $this->endWidget();?>
		<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'toolbardetail','isCreate'=>true,'UrlCreate'=>'adddata2()',
	'isRefresh'=>true,
	'isRecordPage'=>true,'PageSize'=>$pageSize,'OnChange'=>"$.fn.yiiGridView.update('addressdatagrid',{data:{pageSize: $(this).val() }})"));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'contactdatagrid',
	'dataProvider'=>$customercontact->search(),
  'selectableRows'=>1,
  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(            
            'name'=>'addresscontactid',
            'type'=>'raw', 
            'value'=>array($this,'gridContact'), 
        ),		
  ),
));
?>
