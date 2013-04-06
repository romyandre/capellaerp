<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'groupaccess-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'groupaccessid'); ?>
		<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'groupname'); ?></span>
<span class="cell"><?php echo $form->textField($model,'groupname',array('size'=>50,'maxlength'=>50)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
<span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('groupaccess/write'),
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
		<span class="cell"><?php echo CHtml::ajaxSubmitButton('Cancel',
		array('groupaccess/cancelwrite'),
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
