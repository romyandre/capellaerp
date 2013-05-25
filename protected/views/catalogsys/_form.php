<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalogsys-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'catalogsysid'); ?>
	<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'languageid'); ?><?php echo $form->hiddenField($model,'languageid'); ?></span>
	  <span class="cellform"><input type="text" name="languagename" id="languagename" readonly >
    <?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'language_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Language'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));
    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'language-grid',
      'dataProvider'=>$language->Searchwstatus(),
      'filter'=>$language,
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
          "onClick" => "$(\"#language_dialog\").dialog(\"close\"); $(\"#languagename\").val(\"$data->languagename\"); $(\"#Catalogsys_languageid\").val(\"$data->languageid\");
		  "))',
          ),
        array('name'=>'languageid', 'visible'=>false,
        'value'=>'$data->languageid','htmlOptions'=>array('width'=>'1%')),
        'languagename',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#language_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'catalogname'); ?></span>
		<span class="cellform"><?php echo $form->hiddenField($model,'messagesid'); ?><input type="text" name="messagename" id="messagename" readonly ><?php
      $this->beginWidget('zii.widgets.jui.CJuiDialog',
       array(   'id'=>'messages_dialog',
                // additional javascript options for the dialog plugin
                'options'=>array(
                                'title'=>Yii::t('app','Messages'),
                                'width'=>'auto',
                                'autoOpen'=>false,
                                'modal'=>true,
                                ),
                        ));

    $this->widget('zii.widgets.grid.CGridView', array(
      'id'=>'messages-grid',
      'dataProvider'=>$messages->Searchwstatus(),
      'filter'=>$messages,
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
          "onClick" => "$(\"#messages_dialog\").dialog(\"close\"); $(\"#messagename\").val(\"$data->messagename\"); $(\"#Catalogsys_messagesid\").val(\"$data->messagesid\");
		  "))',
          ),
        array('name'=>'messagesid', 'visible'=>false,
        'value'=>'$data->messagesid','htmlOptions'=>array('width'=>'1%')),
        'messagename',
        ),
    ));

    $this->endWidget('zii.widgets.jui.CJuiDialog');
    echo CHtml::Button('...',
                          array('onclick'=>'$("#messages_dialog").dialog("open"); return false;',
                       ))?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'catalogval'); ?></span>
		<span class="cellform"><?php echo $form->textArea($model,'catalogval',array('rows'=>10, 'cols'=>30)); ?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
		<span class="cellform"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
	</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('catalogsys/write'),
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
		array('catalogsys/cancelwrite'),
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