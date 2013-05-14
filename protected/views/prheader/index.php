<?php
$this->breadcrumbs=array(
	'Prheaders',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata() {
<?php echo CHtml::ajax(array(
			'url'=>array('prheader/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
$('#Prheader_prheaderid').val(data.prheaderid);
					$('#Prheader_prdate').val('');
					$('#Prheader_prno').val('');
					$('#Prheader_slocid').val('');
					$('#sloccode').val('');
					$('#Prheader_deliveryadviceid').val('');
					$('#dano').val('');
					$('#Prheader_headernote').val('');
                document.forms[1].elements[1].value = data.prheaderid;
                $.fn.yiiGridView.update('detaildatagrid', {
                    data: {
                        'Prmaterial[prheaderid]': data.prheaderid
                    }
                });
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
			'url'=>array('prheader/update'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
$('#Prheader_prheaderid').val(data.prheaderid);
					$('#Prheader_prno').val(data.prno);
                                        $('#Prheader_prdate').val(data.prdate);
					$('#Prheader_headernote').val(data.headernote);
					$('#Prheader_slocid').val(data.slocid);
					$('#sloccode').val(data.sloccode);
						$('#Prheader_deliveryadviceid').val(data.deliveryadviceid);
					$('#dano').val(data.dano);
				if (data.recordstatus == '1')
					{
					  document.forms[0].elements[9].checked=true;
					}
					else
					{
					  document.forms[0].elements[9].checked=false;
					}
                document.forms[1].elements[1].value = data.prheaderid;
                $.fn.yiiGridView.update('detaildatagrid', {
                    data: {
                        'Prmaterial[prheaderid]': data.prheaderid
                    }
                });
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
function generatedata1() {
<?php echo CHtml::ajax(array(
			'url'=>array('prheader/generatedetail'),
            'data'=> array('id'=>'js:$("#Prheader_projectid").val()',
				'hid'=>'js:$("#Prheader_prheaderid").val()'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					toastr.info(data.div);
					$('#fullname').val(data.customername);
                    js:$.fn.yiiGridView.update('detaildatagrid');
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
function generatedata2() {
<?php echo CHtml::ajax(array(
			'url'=>array('prheader/generatedetail1'),
            'data'=> array('id'=>'js:$("#Prheader_deliveryadviceid").val()',
				'hid'=>'js:$("#Prheader_prheaderid").val()'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
					toastr.info(data.div);
					$('#Prheader_headernote').val(data.headernote);
                    js:$.fn.yiiGridView.update('detaildatagrid');
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
			'url'=>array('prheader/delete'),
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
			'url'=>array('prheader/approve'),
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
	window.open('index.php?r=prheader/download&id='+value);
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
					'prmaterial'=>$prmaterial,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'sloc'=>$sloc,
					'requestedby'=>$requestedby,
    'deliveryadvice'=>$deliveryadvice)); ?>
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
<h1><?php echo Catalogsys::model()->GetCatalog('prheader') ?></h1>
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
	'dataProvider'=>$model->Searchwfstatus(),
  'selectableRows'=>1,
	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
'rowCssClassExpression'=>'($data->recordstatus==0)?"deleted":($data->recordstatus==1)?"new":"approved"',
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(            
            'name'=>'prheaderid',
            'type'=>'raw', 
            'value'=>array($this,'gridData'), 
        ),	
  ),
));
?>