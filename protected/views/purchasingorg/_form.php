<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'purchasingorg-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'purchasingorgid'); ?>
	<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'purchasingorgcode'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'purchasingorgcode',array('size'=>5,'maxlength'=>5)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'description'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'description',array('size'=>50,'maxlength'=>50)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
		<span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
	</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('purchasingorg/write'),
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
		array('purchasingorg/cancelwrite'),
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