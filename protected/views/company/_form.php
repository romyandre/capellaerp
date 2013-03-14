<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'companyid'); ?>
	<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'companyname'); ?></span>
<span class="cell"><?php echo $form->textField($model,'companyname',array('size'=>20,'maxlength'=>50)); ?></span>
<span class="cell"><?php echo $form->labelEx($model,'address'); ?></span>
<span class="cell"><?php echo $form->textArea($model,'address',array('rows'=>5, 'cols'=>30)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'city'); ?></span>
<span class="cell"><?php echo $form->textField($model,'city',array('size'=>20,'maxlength'=>50)); ?></span>
<span class="cell"><?php echo $form->labelEx($model,'zipcode'); ?></span>
<span class="cell"><?php echo $form->textField($model,'zipcode',array('size'=>10,'maxlength'=>10)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'faxno'); ?></span>
<span class="cell"><?php echo $form->textField($model,'faxno',array('size'=>20,'maxlength'=>50)); ?></span>
<span class="cell"><?php echo $form->labelEx($model,'phoneno'); ?></span>
<span class="cell"><?php echo $form->textField($model,'phoneno',array('size'=>20,'maxlength'=>50)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'webaddress'); ?></span>
<span class="cell"><?php echo $form->textField($model,'webaddress',array('size'=>20,'maxlength'=>100)); ?></span>
<span class="cell"><?php echo $form->labelEx($model,'email'); ?></span>
<span class="cell"><?php echo $form->textField($model,'email',array('size'=>20,'maxlength'=>100)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'taxno'); ?></span>
<span class="cell"><?php echo $form->textField($model,'taxno',array('size'=>20,'maxlength'=>50)); ?></span>
<span class="cell"><?php echo $form->labelEx($model,'currencyid'); ?>
            <?php echo $form->hiddenField($model,'currencyid'); ?></span>
<span class="cell"><input type="text" name="sched_name" id="currencyname" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'currency_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Currency'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'catering-grid',
      'dataProvider'=>$currency->Searchwstatus(),
      'filter'=>$currency,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#currency_dialog\").dialog(\"close\");
          $(\"#currencyname\").val(\"$data->currencyname\");
          $(\"#Company_currencyid\").val(\"$data->currencyid\");
		  "))',
          ),
	array('name'=>'currencyid', 'visible'=>false,
        'value'=>'$data->currencyid','htmlOptions'=>array('width'=>'1%')),
        'currencyname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#currency_dialog").dialog("open"); return false;',
                       ))?>	</span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'leftlogofile'); ?></span>
<span class="cell"><?php echo $form->textField($model,'leftlogofile'); ?></span>
<span class="cell"><?php echo $form->labelEx($model,'rightlogofile'); ?></span>
<span class="cell"><?php echo $form->textField($model,'rightlogofile'); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
<span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('company/write'),
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
		array('company/cancelwrite'),
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