<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'language-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'languageid'); ?>
	<div id="tabledialog">
<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'languagename'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'languagename',array('size'=>30,'maxlength'=>30)); ?></span>
	</div>
	
	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'formatdate'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'formatdate',array('size'=>30,'maxlength'=>10)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
		<span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
	</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('language/write'),
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
		array('language/cancelwrite'),
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