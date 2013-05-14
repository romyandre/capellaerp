<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'menuaccess-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'menuaccessid'); ?>
<div id="tabledialog">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'menucode'); ?></span>
<span class="cell"><?php echo $form->textField($model,'menucode',array('size'=>10,'maxlength'=>10)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'menuname'); ?></span>
<span class="cell"><?php echo $form->textField($model,'menuname',array('size'=>50,'maxlength'=>50)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'menuurl'); ?></span>
<span class="cell"><?php echo $form->textField($model,'menuurl',array('size'=>50,'maxlength'=>50)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'menuicon'); ?></span>
<span class="cell"><?php echo $form->textField($model,'menuicon',array('size'=>50,'maxlength'=>50)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'description'); ?></span>
<span class="cell"><?php echo $form->textField($model,'description'); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
<span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('menuaccess/write'),
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
		array('menuaccess/cancelwrite'),
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
