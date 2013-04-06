<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usergroup-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'usergroupid'); ?>
		<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'useraccessid'); ?><?php echo $form->hiddenField($model,'useraccessid'); ?></span>
<span class="cell"><input type="text" name="username" id="username" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'useraccess_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','User Access'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
$useraccess = new Useraccess('searchwstatus');
	  $useraccess->unsetAttributes();  // clear any default values
	  if(isset($_GET['Useraccess']))
		$useraccess->attributes=$_GET['Useraccess'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'useraccess-grid',
      'dataProvider'=>$useraccess->search(),
      'filter'=>$useraccess,
      'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
      'columns'=>array(
        array(
          'header'=>'',
          'type'=>'raw',
        /* Here is The Button that will send the Data to The MAIN FORM */
          'value'=>'CHtml::Button("V",
          array("name" => "send_absschedule",
          "id" => "send_absschedule",
          "onClick" => "$(\"#useraccess_dialog\").dialog(\"close\"); $(\"#username\").val(\"$data->username\"); $(\"#Usergroup_useraccessid\").val(\"$data->useraccessid\");
		  "))',
          ),
		  array('name'=>'useraccessid', 'visible'=>false, 'value'=>'$data->useraccessid'),
        'username',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#useraccess_dialog").dialog("open"); return false;',
                       ))?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'groupaccessid'); ?><?php echo $form->hiddenField($model,'groupaccessid'); ?></span>
<span class="cell"><input type="text" name="groupname" id="groupname" readonly>
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
$groupaccess = new Groupaccess('searchwstatus');
	  $groupaccess->unsetAttributes();  // clear any default values
	  if(isset($_GET['Groupaccess']))
		$groupaccess->attributes=$_GET['Groupaccess'];
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'groupaccess-grid',
      'dataProvider'=>$groupaccess->Search(),
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
          "onClick" => "$(\"#groupaccess_dialog\").dialog(\"close\"); $(\"#groupname\").val(\"$data->groupname\"); $(\"#Usergroup_groupaccessid\").val(\"$data->groupaccessid\");
		  "))',
          ),
		  array('name'=>'groupaccessid', 'visible'=>false, 'value'=>'$data->groupaccessid'),
        'groupname',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#groupaccess_dialog").dialog("open"); return false;',
                       ))?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('usergroup/write'),
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
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Cancel',
		array('usergroup/cancelwrite'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			document.getElementById("messages").innerHTML = x.div;
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