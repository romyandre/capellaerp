<?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<h1 class="art-postheader">Login</h1>
<br />
<!-- add 3 line div -->
<div class="art-content-layout">
	<div class="art-content-layout-row">
		<div class="art-layout-cell layout-item-about" style="width: 100%;">
		
			<p>Please fill out the following form with your login credentials:</p> <br />
			<div class="form">
			
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'login-form',
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
			)); ?>
			
			<p class="note">Fields with <span class="required">*</span> are required.</p>

			<div class="row">
				<?php echo $form->labelEx($model,'username'); ?>
				<?php echo $form->textField($model,'username'); ?>
				<?php echo $form->error($model,'username'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'password'); ?>
				<?php echo $form->passwordField($model,'password'); ?>
				<?php echo $form->error($model,'password'); ?>
				<p class="hint">
					Hint: You may login with valid user.
				</p>
			</div>

			<div class="row rememberMe">
				<?php echo $form->checkBox($model,'rememberMe'); ?>
				<?php echo $form->label($model,'rememberMe'); ?>
				<?php echo $form->error($model,'rememberMe'); ?>
			</div>

			<div class="row buttons">
				<?php echo CHtml::submitButton('Login'); ?>
			</div>

			<?php $this->endWidget(); ?>
		
			</div><!-- form -->
		</div>
	</div>
</div>
