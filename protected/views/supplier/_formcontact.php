<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>'multipart/form-data')
)); ?>
<?php echo $form->hiddenField($model,'addresscontactid'); ?>
<?php echo $form->hiddenField($model,'addressbookid'); ?>
	<div id="tabledata">
<div class="rowdata">
<span class="cell"><?php echo $form->labelEx($model,'contacttypeid'); ?>
<?php echo $form->hiddenField($model,'contacttypeid'); ?></span>
         <span class="cell"> <input type="text" name="contacttype_name" id="contacttype_name" readonly >
          <?php
            $this->beginWidget('zii.widgets.jui.CJuiDialog',
             array(   'id'=>'contacttype_dialog',
                      // additional javascript options for the dialog plugin
                      'options'=>array(
                                      'title'=>Yii::t('app','Contact Type'),
                                      'width'=>'auto',
                                      'autoOpen'=>false,
                                      'modal'=>true,
                                      ),
                              ));
$contacttype = new Contacttype('searchwstatus');
	  $contacttype->unsetAttributes();  // clear any default values
	  if(isset($_GET['Contacttype']))
		$contacttype->attributes=$_GET['Contacttype'];
          $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'contacttype-grid',
            'dataProvider'=>$contacttype->Searchwstatus(),
            'filter'=>$contacttype,
				'pager' => array('cssFile' => Yii::app()->theme->baseUrl . '/css/main.css'),
'cssFile' => Yii::app()->theme->baseUrl . '/css/main.css',
            'template'=>'{summary}{pager}<br>{items}{pager}{summary}',
            'columns'=>array(
              array(
                'header'=>'',
                'type'=>'raw',
              /* Here is The Button that will send the Data to The MAIN FORM */
                'value'=>'CHtml::Button("V",
                array("name" => "send_contacttype",
                "id" => "send_contacttype",
                "onClick" => "$(\"#contacttype_dialog\").dialog(\"close\"); $(\"#contacttype_name\").val(\"$data->contacttypename\"); $(\"#Suppliercontact_contacttypeid\").val(\"$data->contacttypeid\");"))',
                ),
              'contacttypeid',
              'contacttypename',
              ),
          ));

          $this->endWidget('zii.widgets.jui.CJuiDialog');
          echo CHtml::Button('...',
                                array('onclick'=>'$("#contacttype_dialog").dialog("open"); return false;',
                             ));?></span>
	</div>

	<div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'addresscontactname'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'addresscontactname',array('size'=>50,'maxlength'=>50)); ?></span>
	</div>

    <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'phoneno'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'phoneno'); ?></span>
	</div>
        <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'mobilephone'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'mobilephone'); ?></span>
	</div>

    <div class="rowdata">
		<span class="cell"><?php echo $form->labelEx($model,'emailaddress'); ?></span>
		<span class="cell"><?php echo $form->textField($model,'emailaddress'); ?></span>
	</div>

<div class="rowdata">
<span class="cell"><?php echo CHtml::ajaxSubmitButton('Save',
		array('supplier/writecontact'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
				$.fn.yiiGridView.update("contactdatagrid");
				$("#createdialog2").dialog("close");
				toastr.info(x.div);
			}
			else
			{
				toastr.error(x.div);
			}
        }')); ?><?php echo CHtml::ajaxSubmitButton('Cancel',
		array('supplier/cancelwritecontact'),
	  array(
	  'success'=>'function(data)
		{
			var x = eval("(" + data + ")");
			if (x.status == "success")
			{
				$.fn.yiiGridView.update("contactdatagrid");			  
				$("#createdialog2").dialog("close");
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
