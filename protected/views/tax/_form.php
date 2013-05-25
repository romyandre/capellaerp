<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tax-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'taxid'); ?>
	<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'taxcode'); ?></span>
		<span class="cellform"><?php echo $form->textField($model,'taxcode',array('size'=>20,'maxlength'=>20)); ?></span>
	</div>

		<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'taxvalue'); ?></span>
		<span class="cellform"><?php echo $form->textField($model,'taxvalue',array('size'=>5,'maxlength'=>5)); ?> %</span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'description'); ?></span>
		<span class="cellform"><?php echo $form->textField($model,'description',array('size'=>20,'maxlength'=>50)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
		<span class="cellform"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
	</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('tax/write'),
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
		array('tax/cancelwrite'),
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