<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'purchasinggroup-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'purchasinggroupid'); ?>
	<div id="tabledialog">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'purchasingorgid'); ?>
<?php echo $form->hiddenField($model,'purchasingorgid'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="purchasingorgcode" title="Enter Schedule name" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'purchasingorg_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Purchasing Organization'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'absschedule-grid',
      'dataProvider'=>$purchasingorg->Searchwstatus(),
      'filter'=>$purchasingorg,
	  	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("+",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#purchasingorg_dialog\").dialog(\"close\"); $(\"#purchasingorgcode\").val(\"$data->purchasingorgcode\"); $(\"#Purchasinggroup_purchasingorgid\").val(\"$data->purchasingorgid\");
		  "))',
          ),
	array('name'=>'purchasingorgid', 'visible'=>false,'value'=>'$data->purchasingorgid','htmlOptions'=>array('width'=>'1%')),
        'purchasingorgcode',
        'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#purchasingorg_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'purchasinggroupcode'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'purchasinggroupcode',array('size'=>5,'maxlength'=>5)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'description'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'description',array('size'=>50,'maxlength'=>50)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
		<span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
	</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('purchasinggroup/write'),
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
		array('purchasinggroup/cancelwrite'),
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