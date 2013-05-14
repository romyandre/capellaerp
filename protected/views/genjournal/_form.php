<div class="form">
<?php 
$journaldetail->genjournalid= $model->genjournalid;
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'genjournal-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php echo $form->hiddenField($model,'genjournalid'); ?>
	<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'journaldate'); ?></span>
		<span class="cellcontent"><?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'journaldate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'1900:+0'
              ),
              
          ));?></span>
		  </div>
		  <div class="rowdata">		  <span class="cell">
<?php echo $form->labelEx($model,'postdate'); ?></span>
		<span class="cellcontent"><?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
              'attribute'=>'postdate',
              'model'=>$model,
              // additional javascript options for the date picker plugin
              'options'=>array(
                  'showAnim'=>'fold',
				  'dateFormat'=>Yii::app()->params['dateviewcjui'],
				  'changeYear'=>true,
				  'changeMonth'=>true,
                                  'yearRange'=>'1900:+0'
              ),
          ));?></span>
	</div>
		  <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'referenceno'); ?></span>
		<span class="cellcontent"><?php echo $form->textfield($model,'referenceno'); ?></span>		
		</div>
		  <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'journalnote'); ?></span>
		<span class="cellcontent"><?php echo $form->textArea($model,'journalnote',array('rows'=>5, 'cols'=>20)); ?></span>
	</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('genjournal/write'),
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
        }')); ?></span><span class="cell"><?php echo CHtml::ajaxSubmitButton('Cancel',
		array('genjournal/cancelwrite'),
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
	<?php
	$this->widget('zii.widgets.jui.CJuiTabs', array(
	'tabs' => array(
		'Journal Detail' => array('content' => $this->renderPartial('indexdetail',
			array('journaldetail'=>$journaldetail),true)),
	),
	// additional javascript options for the tabs plugin
	'options' => array(
		'collapsible' => true,
	),
));?>
</div><!-- form -->