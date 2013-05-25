<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'addressbook-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'addressbookid'); ?>
	<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'fullname'); ?></span>
<span class="cellform"><?php echo $form->textField($model,'fullname',array('size'=>30,'maxlength'=>50)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'iscustomer'); ?></span>
		<span class="cellform"><?php echo $form->checkBox($model,'iscustomer'); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'isemployee'); ?></span>
		<span class="cellform"><?php echo $form->checkBox($model,'isemployee'); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'isapplicant'); ?></span>
		<span class="cellform"><?php echo $form->checkBox($model,'isapplicant'); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'isvendor'); ?></span>
		<span class="cellform"><?php echo $form->checkBox($model,'isvendor'); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'isinsurance'); ?></span>
		<span class="cellform"><?php echo $form->checkBox($model,'isinsurance'); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'isbank'); ?></span>
		<span class="cellform"><?php echo $form->checkBox($model,'isbank'); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'ishospital'); ?></span>
		<span class="cellform"><?php echo $form->checkBox($model,'ishospital'); ?></span>
	</div>

		<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'iscatering'); ?></span>
		<span class="cellform"><?php echo $form->checkBox($model,'iscatering'); ?></span>
	</div>

    	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'taxno'); ?></span>
		<span class="cellform"><?php echo $form->textField($model,'taxno',array('size'=>30,'maxlength'=>50)); ?></span>
	</div>

    	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'abno'); ?></span>
		<span class="cellform"><?php echo $form->textField($model,'abno',array('size'=>30,'maxlength'=>50)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
		<span class="cellform"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
	</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('addressbook/write'),
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
		array('addressbook/cancelwrite'),
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