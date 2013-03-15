<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'workflow-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'workflowid'); ?>
      <div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'wfname'); ?></span>
<span class="cell"><?php echo $form->textField($model,'wfname',array('size'=>20,'maxlength'=>20)); ?></span>
<span class="cell"><?php echo $form->labelEx($model,'wfdesc'); ?></span>
<span class="cell"><?php echo $form->textField($model,'wfdesc',array('size'=>50,'maxlength'=>50)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'wfminstat'); ?></span>
<span class="cell"><?php echo $form->textField($model,'wfminstat'); ?></span>
<span class="cell"><?php echo $form->labelEx($model,'wfmaxstat'); ?></span>
<span class="cell"><?php echo $form->textField($model,'wfmaxstat'); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
<span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('workflow/write'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("datagrid");
			  $("#createdialog").dialog("close");
              document.getElementById("messages").innerHTML = "";
			}
        }')); ?></span>
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Cancel',
		array('workflow/cancelwrite'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			document.getElementById("messages").innerHTML = x.div;
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("datagrid");
			  $("#createdialog").dialog("close");
              document.getElementById("messages").innerHTML = "";
			}
        }')); ?></span>
</div>
</div>
<?php $this->endWidget(); ?>
</div><!-- form -->