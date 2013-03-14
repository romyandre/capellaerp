<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'snro-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'snroid'); ?>
	

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'formatdoc'); ?>
		<?php echo $form->textField($model,'formatdoc',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'formatdoc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'formatno'); ?>
		<?php echo $form->textField($model,'formatno',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'formatno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'repeatby'); ?>
		<?php echo $form->textField($model,'repeatby',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'repeatby'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'recordstatus'); ?>
		<?php echo $form->checkBox($model,'recordstatus'); ?>
		<?php echo $form->error($model,'recordstatus'); ?>
	</div>

	<table>
      <tr>
        <td colspan="2" align="center">
		<?php echo CHtml::ajaxSubmitButton('Save',
		array('snro/write'),
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
        }')); ?>
		<?php echo CHtml::ajaxSubmitButton('Cancel',
		array('snro/cancelwrite'),
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
        }')); ?>
        </td>
      </tr>
    </table>
<?php $this->endWidget(); ?>
</div><!-- form -->