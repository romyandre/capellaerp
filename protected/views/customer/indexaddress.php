<?php
$this->breadcrumbs=array(
	'Customeraddresss',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata1()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('customer/createaddress'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Customeraddress_addressid').val('');
					$('#addressbook_name').val('');
					$('#Customeraddress_addresstypeid').val('');
					$('#addresstype_name').val('');
					$('#Customeraddress_addressname').val('');
					$('#Customeraddress_rt').val('');
					$('#Customeraddress_rw').val('');
					$('#Customeraddress_cityid').val('');
					$('#city_name').val('');
					$('#Customeraddress_kelurahanid').val('');
					$('#kelurahan_name').val('');
					$('#Customeraddress_subdistrictid').val('');
					$('#subdistrict_name').val('');
                    $('#Customeraddress_phoneno').val('');
                    $('#Customeraddress_faxno').val('');
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
function editdata1(value)
{
    <?php
	echo CHtml::ajax(array(
			'url'=>array('customer/updateaddress'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Customeraddress_addressid').val(data.addressid);
                    $('#addressbook_name').val(data.fullname);
                    $('#Customeraddress_addresstypeid').val(data.addresstypeid);
                    $('#addresstype_name').val(data.addresstypename);
                    $('#Customeraddress_addressname').val(data.addressname);
                    $('#Customeraddress_rt').val(data.rt);
                    $('#Customeraddress_rw').val(data.rw);
                    $('#Customeraddress_cityid').val(data.cityid);
                    $('#city_name').val(data.cityname);
                    $('#Customeraddress_kelurahanid').val(data.kelurahanid);
                    $('#kelurahan_name').val(data.kelurahanname);
                    $('#Customeraddress_subdistrictid').val(data.subdistrictid);
                    $('#subdistrict_name').val(data.subdistrictname);
                    $('#Customeraddress_phoneno').val(data.phoneno);
                    $('#Customeraddress_faxno').val(data.faxno);
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
 <?php echo CHtml::ajax(array(
			'url'=>array('customer/deleteaddress'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					toastr.info(data.div);
                    js:$.fn.yiiGridView.update('addressdatagrid');
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
function refreshdata1()
{
    $.fn.yiiGridView.update('addressdatagrid');
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
<?php echo $this->renderPartial('_formaddress', array('model'=>$customeraddress)); ?>
<?php $this->endWidget();?>
		<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'toolbardetail','isCreate'=>true,'UrlCreate'=>'adddata1()',
	'isRefresh'=>true,
	'isRecordPage'=>true,'PageSize'=>$pageSize,'OnChange'=>"$.fn.yiiGridView.update('addressdatagrid',{data:{pageSize: $(this).val() }})"));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'addressdatagrid',
	'dataProvider'=>$customeraddress->search(),
  'selectableRows'=>1,
  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(            
            'name'=>'addressid',
            'type'=>'raw', 
            'value'=>array($this,'gridAddress'), 
        ),		
	)
));
?>
