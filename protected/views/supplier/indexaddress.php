<?php
$this->breadcrumbs=array(
	'Supplieraddresss',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
// here is the magic
function adddata1()
{
    <?php echo CHtml::ajax(array(
			'url'=>array('supplier/createaddress'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Supplieraddress_addressid').val('');
					$('#addressbook_name').val('');
					$('#Supplieraddress_addresstypeid').val('');
					$('#addresstype_name').val('');
					$('#Supplieraddress_addressname').val('');
					$('#Supplieraddress_rt').val('');
					$('#Supplieraddress_rw').val('');
					$('#Supplieraddress_cityid').val('');
					$('#city_name').val('');
					$('#Supplieraddress_kelurahanid').val('');
					$('#kelurahan_name').val('');
					$('#Supplieraddress_subdistrictid').val('');
					$('#subdistrict_name').val('');
                    $('#Supplieraddress_phoneno').val('');
                    $('#Supplieraddress_faxno').val('');
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
			'url'=>array('supplier/updateaddress'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					$('#Supplieraddress_addressid').val(data.addressid);
                    $('#addressbook_name').val(data.fullname);
                    $('#Supplieraddress_addresstypeid').val(data.addresstypeid);
                    $('#addresstype_name').val(data.addresstypename);
                    $('#Supplieraddress_addressname').val(data.addressname);
                    $('#Supplieraddress_rt').val(data.rt);
                    $('#Supplieraddress_rw').val(data.rw);
                    $('#Supplieraddress_cityid').val(data.cityid);
                    $('#city_name').val(data.cityname);
                    $('#Supplieraddress_kelurahanid').val(data.kelurahanid);
                    $('#kelurahan_name').val(data.kelurahanname);
                    $('#Supplieraddress_subdistrictid').val(data.subdistrictid);
                    $('#subdistrict_name').val(data.subdistrictname);
                    $('#Supplieraddress_phoneno').val(data.phoneno);
                    $('#Supplieraddress_faxno').val(data.faxno);
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
			'url'=>array('supplier/deleteaddress'),
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
<?php echo $this->renderPartial('_formaddress', array('model'=>$supplieraddress)); ?>
<?php $this->endWidget();?>
		<?php
$this->widget('ToolbarButton',array('cssToolbar'=>'toolbardetail','isCreate'=>true,'UrlCreate'=>'adddata1()',
	'isRefresh'=>true,
	'isRecordPage'=>true,'PageSize'=>$pageSize,'OnChange'=>"$.fn.yiiGridView.update('addressdatagrid',{data:{pageSize: $(this).val() }})"));
?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'addressdatagrid',
	'dataProvider'=>$supplieraddress->search(),
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
