<?php
$this->breadcrumbs=array(
	'Productaccounts',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata()
{
<?php echo CHtml::ajax(array(
			'url'=>array('productaccount/create'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
$('#Productaccount_productaccountid').val('');
					$('#Productaccount_productid').val('');
					$('#productname').val('');
					$('#Productaccount_expenseaccount').val('');
					$('#expenseaccountno').val('');
					$('#Productaccount_salesaccount').val('');
					$('#salesaccountno').val('');
					$('#Productaccount_salesretaccount').val('');
					$('#_salesretaccountno').val('');
					$('#Productaccount_salesitemaccount').val('');
					$('#salesitemaccountno').val('');
					$('#Productaccount_purcretaccount').val('');
					$('#purcretaccountno').val('');
					$('#Productaccount_unbilledaccount').val('');
					$('#unbilledaccountno').val('');
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
			'url'=>array('productaccount/update'),
            'data'=> array('id'=>'js:value'),
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'success')
                {
$('#Productaccount_productaccountid').val(data.productaccountid);
					$('#Productaccount_productid').val(data.productid);
					$('#productname').val(data.productname);
					$('#Productaccount_expenseaccount').val(data.expenseaccount);
					$('#expenseaccountno').val(data.expenseaccountno);
					$('#Productaccount_salesaccount').val(data.salesaccount);
					$('#salesaccountno').val(data.salesaccountno);
					$('#Productaccount_salesretaccount').val(data.salesretaccount);
					$('#salesretaccountno').val(data.salesretaccountno);
					$('#Productaccount_salesitemaccount').val(data.salesitemaccount);
					$('#salesitemaccountno').val(data.salesitemaccountno);
					$('#Productaccount_purcretaccount').val(data.purcretaccount);
					$('#purcretaccountno').val(data.purcretaccountno);
					$('#Productaccount_unbilledaccount').val(data.unbilledaccount);
					$('#unbilledaccountno').val(data.unbilledaccountno);
if (data.isactiva == '1')
					{
					  document.forms[0].elements[23].checked=true;
					}
					else
					{
					  document.forms[0].elements[23].checked=false;
					}
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
			'url'=>array('productaccount/delete'),
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
<script type="text/javascript">
function downloaddata(value) {
	window.open('index.php?r=productaccount/download&id='+value);
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
				  'product'=>$this->product,
				  'expenseaccount'=>$this->expenseaccount,
				  'salesaccount'=>$this->salesaccount,
				  'salesretaccount'=>$this->salesretaccount,
				  'salesitemaccount'=>$this->salesitemaccount,
				  'purcretaccount'=>$this->purcretaccount,
				  'unbilledaccount'=>$this->unbilledaccount)); ?>
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
<h1><?php echo Catalogsys::model()->GetCatalog('productaccount') ?></h1>
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
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
		array(            
            'name'=>'productaccountid',
            'type'=>'raw', 
            'value'=>array($this,'gridData'), 
        ),		
	), 
));
?>

