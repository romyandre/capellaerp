<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'materialgroup-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'materialgroupid'); ?>
	<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'materialtypeid'); ?>
		<?php echo $form->hiddenField($model,'materialtypeid'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="description" title="Enter Schedule name" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'materialtype_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Material Group'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'materialtype-grid',
      'dataProvider'=>$materialtype->Searchwstatus(),
      'filter'=>$materialtype,
	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#materialtype_dialog\").dialog(\"close\"); $(\"#description\").val(\"$data->description\"); $(\"#Materialgroup_materialtypeid\").val(\"$data->materialtypeid\");
		  "))',
          ),
	array('name'=>'materialtypeid', 'visible'=>false,'value'=>'$data->materialtypeid','htmlOptions'=>array('width'=>'1%')),
        'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#materialtype_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'materialgroupcode'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'materialgroupcode',array('size'=>5,'maxlength'=>5)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'description'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'description',array('size'=>50,'maxlength'=>50)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'parentmatgroupid'); ?>
		<?php echo $form->hiddenField($model,'parentmatgroupid'); ?></span>
	  <span class="cell"><input type="text" name="sched_name" id="parentmatgroupcode" title="Enter Schedule name" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'absschedule_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Material Group'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'absschedule-grid',
      'dataProvider'=>$parentmatgroup->Searchwstatus(),
      'filter'=>$parentmatgroup,
	'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#absschedule_dialog\").dialog(\"close\"); $(\"#parentmatgroupcode\").val(\"$data->materialgroupcode\"); $(\"#Materialgroup_parentmatgroupid\").val(\"$data->materialgroupid\");
		  "))',
          ),
        'materialgroupid',
        'materialgroupcode',
        'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#absschedule_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?>
		<span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?>
	</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('materialgroup/write'),
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
		array('materialgroup/cancelwrite'),
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