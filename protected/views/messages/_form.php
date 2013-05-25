<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'messages-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'messagesid'); ?>
	<div id="tabledata">
<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'messagename'); ?></span>
		<span class="cellform"><?php echo $form->textField($model,'messagename',array('size'=>30,'maxlength'=>30)); ?></span>
	</div>
	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'description'); ?></span>
		<span class="cellform"><?php echo $form->textField($model,'description',array('size'=>30,'maxlength'=>50)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
		<span class="cellform"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
	</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('messages/write'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("datagrid");
			  $("#createdialog").dialog("close");
toastr.info(x.div);			}
else
			{
				toastr.error(x.div);
			}
        }')); ?><?php echo CHtml::ajaxSubmitButton('Cancel',
		array('messages/cancelwrite'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("datagrid");
			  $("#createdialog").dialog("close");
toastr.info(x.div);			}
else
			{
				toastr.error(x.div);
			}
        }')); ?></span>
</div>
</div>  
<?php $this->endWidget(); ?>
</div><!-- form -->