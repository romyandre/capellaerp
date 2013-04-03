<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'parameter-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
$imghelp=CHtml::image(Yii::app()->request->baseUrl.'/images/help.png');
echo CHtml::link($imghelp,'#',array(
   'style'=>'cursor: pointer; text-decoration: underline;',
   'onclick'=>"{helpdata(2)}",
));  ?>

<?php echo $form->hiddenField($model,'parameterid'); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'paramname'); ?>
		<?php echo $form->textField($model,'paramname',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'paramname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'paramvalue'); ?>
		<?php echo $form->textField($model,'paramvalue',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'paramvalue'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
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
		array('parameter/write'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("datagrid");
			  $("#createdialog").dialog("close");
toastr.info(x.div);			}
        }')); ?>
		<?php echo CHtml::ajaxSubmitButton('Cancel',
		array('parameter/cancelwrite'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("datagrid");
			  $("#createdialog").dialog("close");
toastr.info(x.div);			}
        }')); ?>
        </td>
      </tr>
    </table>
<?php $this->endWidget(); ?>
</div><!-- form -->