<?php
$this->breadcrumbs=array(
	'Suppliercontacts',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata2()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('supplier/createcontact'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Suppliercontact_addresscontactid').val('');
					$('#Suppliercontact_contacttypeid').val('');
					$('#contacttype_name').val('');
					$('#Suppliercontact_addresscontactname').val('');
                    $('#Suppliercontact_phoneno').val('');
                    $('#Suppliercontact_mobilephone').val('');
                    $('#Suppliercontact_emailaddress').val('');
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
			'url'=>array('supplier/updatecontact'),
            'data'=> array('id'=>'js:$.fn.yiiGridView.getSelection("contactdatagrid")'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Suppliercontact_addresscontactid').val(data.addresscontactid);
					$('#Suppliercontact_contacttypeid').val(data.contacttypeid);
					$('#contacttype_name').val(data.contacttypename);
					$('#Suppliercontact_addresscontactname').val(data.addresscontactname);
                    $('#Suppliercontact_phoneno').val(data.phoneno);
                    $('#Suppliercontact_mobilephone').val(data.mobilephone);
                    $('#Suppliercontact_emailaddress').val(data.emailaddress);
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
			'url'=>array('supplier/deletecontact'),
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
<?php echo $this->renderPartial('_formcontact', array('model'=>$suppliercontact)); ?>
<?php $this->endWidget();?>
		<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'toolbardetail','isCreate'=>true,'UrlCreate'=>'adddata2()',
	'isRefresh'=>true,
	'isRecordPage'=>true,'PageSize'=>$pageSize,'OnChange'=>"$.fn.yiiGridView.update('addressdatagrid',{data:{pageSize: $(this).val() }})"));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'contactdatagrid',
	'dataProvider'=>$suppliercontact->search(),
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
