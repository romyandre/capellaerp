<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'wfgroup-form',
	'enableAjaxValidation'=>false,
)); ?>
		<?php echo $form->hiddenField($model,'wfgroupid'); ?>
	<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'groupaccessid'); ?>
<?php echo $form->hiddenField($model,'groupaccessid'); ?>
    <input type="text" name="groupname" id="groupname" readonly >
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'groupaccess_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Group Access'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'groupaccess-grid',
        'dataProvider'=>$groupaccess->searchwstatus(),
        'filter'=>$groupaccess,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#groupaccess_dialog\").dialog(\"close\"); $(\"#groupname\").val(\"$data->groupname\"); $(\"#Wfgroup_groupaccessid\").val(\"$data->groupaccessid\");"))',
          ),
	array('name'=>'groupaccessid', 'visible'=>false,'value'=>'$data->groupaccessid','htmlOptions'=>array('width'=>'1%')),
          'groupname',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#groupaccess_dialog").dialog("open"); return false;',
                       ))?>	</span>

<span class="cell">
		<?php echo $form->labelEx($model,'workflowid'); ?>
<?php echo $form->hiddenField($model,'workflowid'); ?>
    <input type="text" name="wfdesc" id="wfdesc" readonly >
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array('id'=>'workflow_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Group Access'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true
                                ),
                        ));
      $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'workflow-grid',
        'dataProvider'=>$workflow->searchwstatus(),
        'filter'=>$workflow,
        'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
        'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absstatus",
          "id" => "send_absstatus",
          "onClick" => "$(\"#workflow_dialog\").dialog(\"close\"); $(\"#wfdesc\").val(\"$data->wfdesc\"); $(\"#Wfgroup_workflowid\").val(\"$data->workflowid\");"))',
          ),
	array('name'=>'workflowid', 'visible'=>false,'value'=>'$data->workflowid','htmlOptions'=>array('width'=>'1%')),
          'wfdesc',
        ),
      ));
    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#workflow_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>
	
	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'wfbefstat'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'wfbefstat'); ?></span>
		<span class="cell"><?php echo $form->error($model,'wfbefstat'); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'wfrecstat'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'wfrecstat'); ?></span>
		<span class="cell"><?php echo $form->error($model,'wfrecstat'); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
		<span class="cell"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
		<span class="cell"><?php echo $form->error($model,'recordstatus'); ?></span>
	</div>
	
	<div class="rowdata">
		<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('wfgroup/write'),
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
		array('wfgroup/cancelwrite'),
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