<?php
$this->pageTitle=Yii::app()->name . ' - Login';
?>
<div id="login">
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableAjaxValidation'=>true,
)); ?>
	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'username'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'username'); ?></span>
		<span class="cell"><?php echo $form->error($model,'username'); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'password'); ?></span>
		<span class="cell"><?php echo $form->passwordField($model,'password'); ?></span>
		<span class="cell"><?php echo $form->error($model,'password'); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->checkBox($model,'rememberMe'); ?></span>
		<span class="cell"><?php echo $form->label($model,'rememberMe'); ?></span>
		<span class="cell"><?php echo $form->error($model,'rememberMe'); ?></span>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Login'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
</div>