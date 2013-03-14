<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'useraccess-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'useraccessid'); ?>
<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'realname'); ?></span>
<span class="cell"><?php echo $form->textField($model,'realname',array('size'=>50,'maxlength'=>50)); ?></span>
<span class="cell"><?php echo $form->labelEx($model,'username'); ?></span>
<span class="cell"><?php echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'password'); ?><?php echo CHtml::hiddenField('passhide',''); ?></span>
<span class="cell"><?php echo $form->passwordField($model,'password',array('size'=>50,'maxlength'=>50)); ?></span>
<span class="cell"><?php echo $form->labelEx($model,'email'); ?></span>
<span class="cell"><?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
<span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('useraccess/write'),
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
		array('useraccess/cancelwrite'),
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