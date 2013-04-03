<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'snro-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'snroid'); ?>
	<div id="tabledata">
<div class="rowdata">		
<span class="cell"><?php echo $form->labelEx($model,'description'); ?>
		<span class="cell"><?php echo $form->textField($model,'description',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'formatdoc'); ?>
		<span class="cell"><?php echo $form->textField($model,'formatdoc',array('size'=>50,'maxlength'=>50)); ?>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'formatno'); ?>
		<span class="cell"><?php echo $form->textField($model,'formatno',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'formatno'); ?>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'repeatby'); ?>
		<span class="cell"><?php echo $form->textField($model,'repeatby',array('size'=>30,'maxlength'=>30)); ?>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?>
		<span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?>
	</div>

	<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('snro/write'),
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
        }')); ?><?php echo CHtml::ajaxSubmitButton('Cancel',
		array('snro/cancelwrite'),
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
        }')); ?></span>
</div>
</div>
<?php $this->endWidget(); ?>
</div><!-- form -->