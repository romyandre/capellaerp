<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'useraccess-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->hiddenField($model,'useraccessid'); ?>
<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'realname'); ?></span>
<span class="cellcontent"><?php echo $form->textField($model,'realname',array('size'=>50,'maxlength'=>50)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'username'); ?></span>
<span class="cellcontent"><?php echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'password'); ?><?php echo CHtml::hiddenField('passhide',''); ?></span>
<span class="cellcontent"><?php echo $form->passwordField($model,'password',array('size'=>50,'maxlength'=>50)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'email'); ?></span>
<span class="cellcontent"><?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'languageid'); ?><?php echo $form->hiddenField($model,'languageid'); ?></span>
	  <span class="cellcontent"><input type="text" name="languagename" id="languagename" readonly >
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
$language=new Language('search');
	$language->unsetAttributes();  // clear any default values
		if(isset($_GET['Language']))
			$language->attributes=$_GET['Language'];

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
<span class="cell"><?php echo $form->labelEx($model,'theme'); ?></span>
<span class="cellcontent"><?php echo $form->textField($model,'theme',array('size'=>50,'maxlength'=>50)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'background'); ?></span>
<span class="cellcontent"><?php echo $form->textField($model,'background',array('size'=>50,'maxlength'=>50)); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'recordstatus'); ?></span>
<span class="cellcontent"><?php echo $form->checkBox($model,'recordstatus'); ?></span>
</div>
<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('useraccess/write'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("datagrid");
			  $("#createdialog").dialog("close");
toastr.info(x.div);				}
else
			{
				toastr.error(x.div);
			}
        }')); ?><?php echo CHtml::ajaxSubmitButton('Cancel',
		array('useraccess/cancelwrite'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
			  $.fn.yiiGridView.update("datagrid");
			  $("#createdialog").dialog("close");
toastr.info(x.div);				}
else
			{
				toastr.error(x.div);
			}
        }')); ?></span>
</div>
</div>
<?php $this->endWidget(); ?>
</div><!-- form -->