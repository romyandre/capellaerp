<?php
$this->breadcrumbs=array(
	'Bsheaders',
);
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
?>
<script type="text/javascript">
function adddata() {
    jQuery.ajax({
        'url': '/smlive/index.php?r=bsheader/create',
        'data': $(this).serialize(),
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
                $('#Bsheader_bsheaderid').val(data.bsheaderid);
                $('#Bsheader_referenceno').val('');
                $('#Bsheader_bsdate').val('');
                $('#Bsheader_postdate').val('');
                document.forms[2].elements[1].value = data.bsheaderid;
                $.fn.yiiGridView.update('detaildatagrid', {
                    data: {
                        'Bsdetail[bsheaderid]': data.bsheaderid
                    }
                });
                $('#createdialog').dialog('open');
            }
            else {
                document.getElementById('messages').innerHTML = data.div;
            }
        },
        'cache': false
    });;
    return false;
}
</script>
<script type="text/javascript">
function editdata() {
    jQuery.ajax({
        'url': '/smlive/index.php?r=bsheader/update',
        'data': {
            'id': $.fn.yiiGridView.getSelection("datagrid")
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            document.getElementById('messages').innerHTML = '';
            if (data.status == 'success') {
                $('#createdialog div.divcreate').html(data.div);
                $('#Bsheader_bsheaderid').val(data.bsheaderid);
                $('#Bsheader_referenceno').val(data.referenceno);
                $('#Bsheader_bsdate').val(data.bsdate);
                $('#Bsheader_postdate').val(data.postdate);
                $('#Bsheader_headernote').val(data.headernote);
                document.forms[2].elements[1].value = data.bsheaderid;
                $.fn.yiiGridView.update('detaildatagrid', {
                    data: {
                        'Bsdetail[bsheaderid]': data.bsheaderid
                    }
                });
                $('#createdialog').dialog('open');
            }
            else {
                document.getElementById('messages').innerHTML = data.div;
            }
        },
        'cache': false
    });;
    return false;
}
</script>
<script type="text/javascript">
function deletedata()
{jQuery.ajax({'url':'/smlive/index.php?r=bsheader/delete','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function approvedata()
{jQuery.ajax({'url':'/smlive/index.php?r=bsheader/approve','data':{'id':$.fn.yiiGridView.getSelection("datagrid")},'type':'post','dataType':'json','success':function(data)
{},'cache':false});;$.fn.yiiGridView.update('datagrid');return false;}
</script>
<script type="text/javascript">
function refreshdata()
{$.fn.yiiGridView.update('datagrid');$.fn.yiiGridView.update('indatagrid');return false;}
</script>
<script type="text/javascript">
function showdetail() {
    $.fn.yiiGridView.update('indatagrid', {
                    data: {
                        'Bsdetail[bsheaderid]': $.fn.yiiGridView.getSelection("datagrid")[0]
                    }
                });
    return false;
}
</script>
<script type="text/javascript">
function helpdata(value) {
    jQuery.ajax({
        'url': '/smlive/index.php?r=bsheader/help',
        'data': {
            'id': value
        },
        'type': 'post',
        'dataType': 'json',
        'success': function(data) {
            if (data.status == 'success') {
				document.getElementById('divhelp').innerHTML = data.div;
                $('#helpdialog').dialog('open');
            } else {
                document.getElementById('messages').innerHTML = data.div;
            }
        },
        'cache': false
    });;
    return false;
}
</script>
<script type="text/javascript">
function downloaddata() {
	window.open('/smlive/index.php?r=bsheader/download&id='+$.fn.yiiGridView.getSelection("datagrid"));
}
</script>
<script type="text/javascript" >
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#messages');
		new AjaxUpload(btnUpload, {
			action: 'index.php?r=bsheader/upload',
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (!(ext && /^(csv)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only CSV files are allowed');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				status.text('');
				//Add uploaded file to list
				if(response.status==="success"){
					$.fn.yiiGridView.update('datagrid');
				} else{
					status.text('error upload');
				}
			}
		});		
	});
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
<div id="divcreate"></div>
<?php echo $this->renderPartial('_form', array('model'=>$model,
					'bsdetail'=>$bsdetail,
					'product'=>$product,
					'unitofmeasure'=>$unitofmeasure,
					'currency'=>$currency,
					'ownership'=>$ownership,
					'materialstatus'=>$materialstatus,
				  'sloc'=>$sloc)); ?>
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
<div id="divhelp"></div>
<?php $this->endWidget();?>
<h1>Transaction: Tools Stock</h1>
<div id="toolbar">
<ul>
<?php
$imgcreate=CHtml::image(Yii::app()->request->baseUrl.'/images/create.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgcreate,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{adddata()}",
	'title'=>Yii::t('app','create data')
));
echo CHtml :: closeTag('li');

$imgedit=CHtml::image(Yii::app()->request->baseUrl.'/images/edit.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgedit,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{editdata()}",
	'title'=>Yii::t('app','edit data')
));
echo CHtml :: closeTag('li');

$imgapprove=CHtml::image(Yii::app()->request->baseUrl.'/images/approve.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgapprove,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{approvedata()}",
   'title'=>Yii::t('app','approve data')
));
echo CHtml :: closeTag('li');

$imgdelete=CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgdelete,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{deletedata()}",
   'title'=>Yii::t('app','delete data')
));
echo CHtml :: closeTag('li');
?>
<li>
<a id="upload" class="hover" style="cursor: pointer; text-decoration: underline; padding-top:15px; " title="upload file">
<img src="images/up.png" alt="">
</a>
</li>
<?php
$imgdown=CHtml::image(Yii::app()->request->baseUrl.'/images/down.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgdown,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
    'onclick'=>"{downloaddata()}",
   'title'=>Yii::t('app','download data')
));
echo CHtml :: closeTag('li');

$imgrefresh=CHtml::image(Yii::app()->request->baseUrl.'/images/refresh.png');
echo CHtml :: openTag('li');
echo CHtml::link($imgrefresh,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{refreshdata()}",
   'title'=>Yii::t('app','refresh data')
));
echo CHtml :: closeTag('li');

$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml :: openTag('li');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(1)}",
   'title'=>Yii::t('app','help')
));
echo CHtml :: closeTag('li');
?>
<div class="recordpage">Record/page<?php echo CHtml::textField($pageSize,'',array('size'=>'5',
        // change 'user-grid' to the actual id of your grid!!
        'onchange'=>"$.fn.yiiGridView.update('datagrid',{ data:{pageSize: $(this).val() }})",
	  ));  ?></div></ul></div>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'datagrid',
	'dataProvider'=>$model->Searchwfstatus(),
	'filter'=>$model,
  'selectableRows'=>1,
    'selectionChanged'=>'showdetail',
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
    array(
      'class'=>'CCheckBoxColumn',
      'id'=>'ids',
    ),
	array('name'=>'bsheaderid', 'visible'=>false,'header'=>'ID','value'=>'$data->bsheaderid','htmlOptions'=>array('width'=>'1%')),
'bsheaderno',
        array(
      'name'=>'bsdate',
      'type'=>'raw',
         'value'=>'($data->bsdate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->bsdate)):""'
     ),
	 'headernote',
    	array('header'=>'Status','value'=>'Wfstatus::model()->findstatusname("appbs",$data->recordstatus)'),
  ),
));
?>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'indatagrid',
	'dataProvider'=>$bsdetail->search(),
  'selectableRows'=>1,
	'template'=>'{pager}<br>{items}{pager}',
	'columns'=>array(
	array('name'=>'bsdetailid', 'visible'=>false,'header'=>'ID','value'=>'$data->bsdetailid','htmlOptions'=>array('width'=>'1%')),
	'productcode',
	array('name'=>'productid', 'value'=>'($data->product!==null)?$data->product->productname:""'),
	array('name'=>'unitofmeasureid', 'value'=>'($data->unitofmeasure!==null)?$data->unitofmeasure->uomcode:""'),
	        array(
      'name'=>'quantity',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberqty"],$data->quantity)',
     ),
	array('name'=>'slocid', 'value'=>'($data->sloc!==null)?$data->sloc->description:""'),
	'itemnote',
	'pono',
	        array(
      'name'=>'buyprice',
      'type'=>'raw',
         'value'=>'Yii::app()->numberFormatter->format(Yii::app()->params["defaultnumberprice"],$data->buyprice)',
     ),
	array('name'=>'currencyid', 'value'=>'($data->currency!==null)?$data->currency->currencyname:""'),
	array(
      'name'=>'buydate',
      'type'=>'raw',
         'value'=>'($data->buydate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->buydate)):""'
     ),
	 array(
      'name'=>'expiredate',
      'type'=>'raw',
         'value'=>'($data->expiredate!==null)?date(Yii::app()->params["dateviewfromdb"], strtotime($data->expiredate)):""'
     ),
	 'serialno',
	array('name'=>'ownershipid', 'value'=>'($data->ownership!==null)?$data->ownership->ownershipname:""'),
	array('name'=>'materialstatusid', 'value'=>'($data->materialstatus!==null)?$data->materialstatus->materialstatusname:""'),
  ),
));
?>
