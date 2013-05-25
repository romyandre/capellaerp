<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'paymentmethod-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'paymentmethodid'); ?>
<div id="tabledata">
<div class="rowdata">
<span class="cell">
		<?php echo $form->labelEx($model,'paycode'); ?></span>
		<span class="cellform"><?php echo $form->textField($model,'paycode',array('size'=>5,'maxlength'=>5)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'paymentname'); ?></span>
		<span class="cellform"><?php echo $form->textField($model,'paymentname',array('size'=>30,'maxlength'=>50)); ?></span>
	</div>

		<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'paydays'); ?></span>
		<span class="cellform"><?php echo $form->textField($model,'paydays'); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
		<span class="cellform"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
	</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('paymentmethod/write'),
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
		array('paymentmethod/cancelwrite'),
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