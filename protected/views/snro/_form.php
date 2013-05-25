<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'snro-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'snroid'); ?>
	<div id="tabledata">
<div class="rowdata">		
<span class="cell"><?php echo $form->labelEx($model,'description'); ?></span>
		<span class="cellcontent"><?php echo $form->textField($model,'description',array('size'=>50,'maxlength'=>50)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'formatdoc'); ?></span>
		<span class="cellcontent"><?php echo $form->textField($model,'formatdoc',array('size'=>50,'maxlength'=>50)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'formatno'); ?></span>
		<span class="cellcontent"><?php echo $form->textField($model,'formatno',array('size'=>10,'maxlength'=>10)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'repeatby'); ?></span>
		<span class="cellcontent"><?php echo $form->textField($model,'repeatby',array('size'=>30,'maxlength'=>30)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
		<span class="cellcontent"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
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
			else
			{
				toastr.error(x.div);
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
			else
			{
				toastr.error(x.div);
			}
        }')); ?></span>
</div>
</div>
<?php $this->endWidget(); ?>
</div><!-- form -->