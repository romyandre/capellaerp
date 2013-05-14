<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php echo $form->hiddenField($model,'productid'); ?>
	<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'productname'); ?></span>
		<span class="cell"><?php echo $form->textArea($model,'productname',array('rows'=>6, 'cols'=>50)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'isstock'); ?></span>
		<span class="cell"><?php echo $form->checkBox($model,'isstock'); ?></span>
	</div>

		<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
    <span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
	</div>

	<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('product/write'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
				$.fn.yiiGridView.update("datagrid");
				$("#createdialog").dialog("close");
				toastr.info(x.div);
			}
			else
			{
				toastr.error(x.div);
			}
        }')); ?><?php echo CHtml::ajaxSubmitButton('Cancel',
		array('product/cancelwrite'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
				$.fn.yiiGridView.update("datagrid");			  
				$("#createdialog").dialog("close");
				toastr.info(x.div);
			}
			else
			{
				toastr.error(x.div);
			}
        }')); ?></span>
</div>
</div>   
<?php $this->endWidget(); ?>
</div><!-- form -->