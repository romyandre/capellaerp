<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'groupmenu-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'groupmenuid'); ?>
	<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'groupaccessid'); ?><?php echo $form->hiddenField($model,'groupaccessid'); ?></span>
<span class="cell">	  <input type="text" name="groupname" id="groupname" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'groupaccess_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Group Access'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'groupaccess-grid',
      'dataProvider'=>$groupaccess->Searchwstatus(),
      'filter'=>$groupaccess,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#groupaccess_dialog\").dialog(\"close\"); $(\"#groupname\").val(\"$data->groupname\"); $(\"#Groupmenu_groupaccessid\").val(\"$data->groupaccessid\");
		  "))',
          ),
	array('name'=>'groupaccessid', 'visible'=>false,'value'=>'$data->groupaccessid','htmlOptions'=>array('width'=>'1%')),
        'groupname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#groupaccess_dialog").dialog("open"); return false;',
                       ))?></span>
<span class="cell"><?php echo $form->labelEx($model,'menuaccessid'); ?><?php echo $form->hiddenField($model,'menuaccessid'); ?></span>
<span class="cell">	  <input type="text" name="menuname" id="menuname" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'menuaccess_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Menu Access'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'menuaccess-grid',
      'dataProvider'=>$menuaccess->Searchwstatus(),
      'filter'=>$menuaccess,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#menuaccess_dialog\").dialog(\"close\"); $(\"#menuname\").val(\"$data->description\"); $(\"#Groupmenu_menuaccessid\").val(\"$data->menuaccessid\");
		  "))',
          ),
	array('name'=>'menuaccessid', 'visible'=>false,'value'=>'$data->menuaccessid','htmlOptions'=>array('width'=>'1%')),
        'menuname',
          'menucode',
          'description',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#menuaccess_dialog").dialog("open"); return false;',
                       ))?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'isread'); ?></span>
<span class="cell"><?php echo $form->checkBox($model,'isread'); ?></span>
<span class="cell"><?php echo $form->labelEx($model,'iswrite'); ?></span>
<span class="cell"><?php echo $form->checkBox($model,'iswrite'); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'ispost'); ?></span>
<span class="cell"><?php echo $form->checkBox($model,'ispost'); ?></span>
<span class="cell"><?php echo $form->labelEx($model,'isreject'); ?></span>
<span class="cell"><?php echo $form->checkBox($model,'isreject'); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'isdownload'); ?></span>
<span class="cell"><?php echo $form->checkBox($model,'isdownload'); ?></span>
<span class="cell"><?php echo $form->labelEx($model,'isupload'); ?></span>
<span class="cell"><?php echo $form->checkBox($model,'isupload'); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('groupmenu/write'),
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
		array('groupmenu/cancelwrite'),
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
