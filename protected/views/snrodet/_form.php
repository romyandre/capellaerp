<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'snrodet-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'snrodid'); ?>
<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'snroid'); ?></span>
<span class="cell"><?php echo $form->dropDownList($model,'snroid', CHtml::listData(Snro::model()->findAll(), 'snroid', 'description'),
      array('prompt' => 'Select a Specific Number Range Object')); ?></span>
<span class="cell"><?php echo $form->labelEx($model,'curdd'); ?></span>
<span class="cell"><?php echo $form->textField($model,'curdd'); ?></span>
</div>	
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'curmm'); ?></span>
<span class="cell"><?php echo $form->textField($model,'curmm'); ?></span>
<span class="cell"><?php echo $form->labelEx($model,'curyy'); ?></span>
<span class="cell"><?php echo $form->textField($model,'curyy'); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'curvalue'); ?></span>
<span class="cell"><?php echo $form->textField($model,'curvalue'); ?></span>
<span class="cell"><?php echo $form->labelEx($model,'curyy'); ?></span>
<span class="cell"><?php echo $form->textField($model,'curyy'); ?></span>
</div>	
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('snrodet/write'),
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
		array('snrodet/cancelwrite'),
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