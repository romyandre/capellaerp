<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'invoicemat-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php
$imghelp1=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp1,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(4)}",
));  ?>
<?php echo $form->hiddenField($model,'invoicematid'); ?>
<?php echo $form->hiddenField($model,'invoiceapid'); ?>
	

    <table>
      <tr>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'productid'); ?>
<?php echo $form->hiddenField($model,'productid'); ?>
        <input type="text" name="productname" id="productname" title="Account name" style="width: 200px" readonly 
		value="<?php echo (Product::model()->findByPk($model->productid)!==null)?Product::model()->findByPk($model->productid)->productname:''; ?>">
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'product_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Product'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$product=new Product('searchwfstatus');
	  $product->unsetAttributes();  // clear any default values
	  if(isset($_GET['Product']))
		$product->attributes=$_GET['Product'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'product-grid',
      'dataProvider'=>$product->Searchwstatus(),
      'filter'=>$product,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#product_dialog\").dialog(\"close\"); $(\"#productname\").val(\"$data->productname\"); 
		  $(\"#Invoicemat_productid\").val(\"$data->productid\");
		  "))',
          ),
		  	array('name'=>'productid', 'visible'=>false,'value'=>'$data->productid','htmlOptions'=>array('width'=>'1%')),
		'productname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#product_dialog").dialog("open"); return false;',
                       ))?>
		<?php echo $form->error($model,'productid'); ?>
	</div>
        </td>
        <td>
          <div class="row">
		<?php echo $form->labelEx($model,'qty'); ?>
		<?php echo $form->textField($model,'qty'); ?>
		<?php echo $form->error($model,'qty'); ?>
	</div>
        </td>
		<td>
	  <div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>
	  </td>
      </tr>
	      </table>

	<div class="row buttons">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('invoiceap/writedetail'),
	  array(
	  'success'=>'function(data1)
		{
			var x = eval("(" + data1 + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("detaildatagrid");
			  $("#createdialog1").dialog("close");
			document.getElementById("messages").innerHTML = "";
			}
        }')); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- form -->